<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderConfirmedMail;
use App\Mail\OrderDeliveredMail;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items']);

        if ($request->filled('q')) {
            $query->where('order_number', 'like', '%' . $request->q . '%')
                  ->orWhereHas('user', fn($q) => $q->where('name', 'like', '%' . $request->q . '%'));
        }

        if ($request->filled('statut')) {
            $query->where('status', $request->statut);
        }

        $orders       = $query->latest()->paginate(8)->withQueryString();
        $pendingCount = Order::where('status', 'pending')->count();
        $clients      = User::where('role', 'client')->orderBy('name')->get(['id', 'name', 'email', 'phone']);
        $products     = Product::where('is_active', true)->orderBy('name')->get(['id', 'name', 'price', 'sale_price', 'stock']);

        return view('admin.pages.commandes', compact('orders', 'pendingCount', 'clients', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'              => ['required', 'exists:users,id'],
            'source'               => ['required', 'in:phone,store'],
            'status'               => ['required', 'in:pending,confirmed,processing,shipped,delivered,cancelled'],
            'notes'                => ['nullable', 'string', 'max:500'],
            'items'                => ['required', 'array', 'min:1'],
            'items.*.product_id'   => ['required', 'exists:products,id'],
            'items.*.quantity'     => ['required', 'integer', 'min:1'],
            'items.*.unit_price'   => ['required', 'numeric', 'min:0'],
        ], [
            'items.required' => 'Ajoutez au moins un produit à la commande.',
            'items.min'      => 'Ajoutez au moins un produit à la commande.',
        ]);

        DB::transaction(function () use ($request) {
            $sourceLabel = $request->source === 'phone' ? '[Téléphone] ' : '[Boutique] ';
            $notes       = $sourceLabel . ($request->notes ?? '');

            $subtotal = 0;
            $lines    = [];

            foreach ($request->items as $item) {
                $product   = Product::findOrFail($item['product_id']);
                $lineTotal = $item['quantity'] * $item['unit_price'];
                $subtotal += $lineTotal;

                $lines[] = [
                    'product_id'   => $product->id,
                    'product_name' => $product->name,
                    'quantity'     => $item['quantity'],
                    'unit_price'   => $item['unit_price'],
                    'total_price'  => $lineTotal,
                ];
            }

            $order = Order::create([
                'user_id'         => $request->user_id,
                'status'          => $request->status,
                'subtotal'        => $subtotal,
                'discount_amount' => 0,
                'total'           => $subtotal,
                'notes'           => $notes,
            ]);

            $order->items()->createMany($lines);
        });

        return redirect()->route('admin.commandes')
            ->with('success', 'Commande créée avec succès.');
    }

    public function updateStatus(Request $request, Order $order)
    {
        if ($order->status === 'cancelled') {
            return redirect()->route('admin.commandes')
                ->with('error', 'La commande ' . $order->order_number . ' est annulée et ne peut plus être modifiée.');
        }

        $request->validate([
            'status' => ['required', 'in:pending,confirmed,processing,shipped,delivered,cancelled'],
        ]);

        $previousStatus = $order->status;
        $order->update(['status' => $request->status]);

        $newStatus = $request->status;
        if ($newStatus !== $previousStatus && in_array($newStatus, ['confirmed', 'delivered'])) {
            defer(function () use ($order, $newStatus) {
                try {
                    $order->loadMissing(['user', 'items', 'address']);
                    if ($newStatus === 'confirmed') {
                        Mail::to($order->user->email)->send(new OrderConfirmedMail($order));
                    } else {
                        Mail::to($order->user->email)->send(new OrderDeliveredMail($order));
                    }
                } catch (\Throwable $e) {
                    \Log::error('Mail statut commande : ' . $e->getMessage());
                }
            });
        }

        return redirect()->route('admin.commandes')
            ->with('success', 'Statut de la commande ' . $order->order_number . ' mis à jour.');
    }
}
