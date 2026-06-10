<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Review;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\NewReviewNotification;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Order $order, OrderItem $item)
    {
        abort_if($order->user_id !== auth()->id(), 403);
        abort_if($order->status !== 'delivered', 403);
        abort_if($item->order_id !== $order->id, 403);

        $data = $request->validate([
            'rating'  => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $review = Review::updateOrCreate(
            ['product_id' => $item->product_id, 'user_id' => auth()->id()],
            [
                'rating'      => $data['rating'],
                'comment'     => $data['comment'] ?? null,
                'is_approved' => true,
            ]
        );

        defer(function () use ($review) {
            try {
                $settings = Setting::all_cached();
                if (($settings['notif_new_review'] ?? '1') === '1') {
                    $admin = User::where('role', 'admin')->first();
                    $admin?->notify(new NewReviewNotification($review->load(['user', 'product'])));
                }
            } catch (\Throwable $e) {
                \Log::error('Notification review : ' . $e->getMessage());
            }
        });

        return back()->with('success', 'Votre avis sur "' . $item->product_name . '" a bien été enregistré.');
    }
}
