<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Mail\OrderPlacedMail;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\LowStockNotification;
use App\Notifications\NewOrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', auth()->id())
            ->with(['items.product', 'promotion'])
            ->first();

        if (! $cart || $cart->items->isEmpty()) {
            return redirect()->route('shop.cart')->with('error', 'Votre panier est vide.');
        }

        $addresses = auth()->user()->addresses()->orderByDesc('is_default')->get();

        return view('Shop.page.checkout', compact('cart', 'addresses'));
    }

    public function store(Request $request)
    {
        $cart = Cart::where('user_id', auth()->id())
            ->with(['items.product', 'promotion'])
            ->first();

        if (! $cart || $cart->items->isEmpty()) {
            return redirect()->route('shop.cart')->with('error', 'Votre panier est vide.');
        }

        $request->validate([
            'delivery_type' => ['required', 'in:delivery,pickup'],
            'address_id'    => ['required_if:delivery_type,delivery', 'nullable', 'exists:addresses,id'],
            'notes'         => ['nullable', 'string', 'max:500'],
        ]);

        $isDelivery = $request->delivery_type === 'delivery';

        $address = null;
        if ($isDelivery) {
            $address = Address::where('id', $request->address_id)
                ->where('user_id', auth()->id())
                ->firstOrFail();
        }

        $order = DB::transaction(function () use ($cart, $address, $request, $isDelivery) {
            $order = Order::create([
                'user_id'         => auth()->id(),
                'address_id'      => $address?->id,
                'promotion_id'    => $cart->promotion_id,
                'status'          => 'pending',
                'delivery_type'   => $request->delivery_type,
                'subtotal'        => $cart->subtotal,
                'discount_amount' => $cart->discount_amount,
                'total'           => $cart->total,
                'notes'           => $request->notes,
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item->product_id,
                    'product_name' => $item->product->name,
                    'quantity'     => $item->quantity,
                    'unit_price'   => $item->unit_price,
                    'total_price'  => $item->unit_price * $item->quantity,
                ]);

                // Décrémenter le stock si défini
                if ($item->product->stock !== null) {
                    $item->product->decrement('stock', $item->quantity);
                }
            }

            // Incrémenter l'usage du code promo
            if ($cart->promotion) {
                $cart->promotion->increment('usage_count');
            }

            // Vider le panier
            $cart->items()->delete();
            $cart->update(['promotion_id' => null]);

            return $order;
        });

        // Emails et notifications après l'envoi de la réponse (non-bloquant)
        defer(function () use ($order) {
            try {
                $order->loadMissing(['user', 'items', 'address']);
                Mail::to($order->user->email)->send(new OrderPlacedMail($order));
            } catch (\Throwable $e) {
                \Log::error('Mail commande passée : ' . $e->getMessage());
            }

            try {
                $settings = Setting::all_cached();
                $admin    = User::where('role', 'admin')->first();

                if ($admin) {
                    $order->loadMissing(['user', 'items.product', 'address']);

                    if (($settings['notif_new_order'] ?? '1') === '1') {
                        $admin->notify(new NewOrderNotification($order));
                    }

                    if (($settings['notif_low_stock'] ?? '1') === '1') {
                        foreach ($order->items as $item) {
                            $product = $item->product;
                            if ($product && $product->stock !== null && $product->stock <= 5) {
                                $admin->notify(new LowStockNotification($product));
                            }
                        }
                    }
                }
            } catch (\Throwable $e) {
                \Log::error('Notification checkout : ' . $e->getMessage());
            }
        });

        return redirect()->route('shop.commandes.show', $order)
            ->with('success', 'Commande ' . $order->order_number . ' passée avec succès !');
    }

    public function storeAddress(Request $request)
    {
        $data = $request->validate([
            'full_name'    => ['required', 'string', 'max:100'],
            'phone'        => ['required', 'string', 'max:20'],
            'city'         => ['required', 'string', 'max:100'],
            'quartier'     => ['nullable', 'string', 'max:100'],
            'address_line' => ['required', 'string', 'max:255'],
            'is_default'   => ['nullable', 'boolean'],
        ]);

        $data['user_id'] = auth()->id();

        if (! empty($data['is_default'])) {
            Address::where('user_id', auth()->id())->update(['is_default' => false]);
        }

        Address::create($data);

        return redirect()->route('shop.checkout')
            ->with('success', 'Adresse ajoutée.');
    }
}
