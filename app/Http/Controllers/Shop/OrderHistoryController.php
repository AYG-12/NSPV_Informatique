<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Support\Facades\DB;

class OrderHistoryController extends Controller
{
    public function index()
    {
        $orders = Order::with(['items', 'address'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('Shop.page.mes-commandes', compact('orders'));
    }

    public function show(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);

        $order->load(['items.product', 'address', 'promotion']);

        $reviews = collect();
        if ($order->status === 'delivered') {
            $reviews = Review::where('user_id', auth()->id())
                ->whereIn('product_id', $order->items->pluck('product_id'))
                ->get()
                ->keyBy('product_id');
        }

        return view('Shop.page.commande-detail', compact('order', 'reviews'));
    }

    public function cancel(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);
        abort_if($order->status !== 'pending', 403);

        DB::transaction(function () use ($order) {
            $order->load(['items.product', 'promotion']);

            foreach ($order->items as $item) {
                if ($item->product && $item->product->stock !== null) {
                    $item->product->increment('stock', $item->quantity);
                }
            }

            if ($order->promotion) {
                $order->promotion->decrement('usage_count');
            }

            $order->update(['status' => 'cancelled']);
        });

        return redirect()->route('shop.commandes')
            ->with('success', 'Commande ' . $order->order_number . ' annulée avec succès.');
    }
}
