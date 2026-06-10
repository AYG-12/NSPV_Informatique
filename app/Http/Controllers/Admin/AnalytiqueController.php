<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Support\Facades\DB;

class AnalytiqueController extends Controller
{
    public function index()
    {
        $now   = now();
        $start = $now->copy()->subDays(29)->startOfDay();

        // Revenus totaux (30 derniers jours, hors annulées)
        $revenueTotal = Order::where('status', '!=', 'cancelled')
            ->where('created_at', '>=', $start)
            ->sum('total');

        // Panier moyen
        $avgCart = Order::where('status', '!=', 'cancelled')
            ->where('created_at', '>=', $start)
            ->avg('total') ?? 0;

        // Revenus par jour (7 derniers jours)
        $revenueByDay = Order::where('status', '!=', 'cancelled')
            ->where('created_at', '>=', $now->copy()->subDays(6)->startOfDay())
            ->select(
                DB::raw('DATE(created_at) as day'),
                DB::raw('SUM(total) as total')
            )
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->keyBy('day');

        $days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = $now->copy()->subDays($i)->format('Y-m-d');
            $days->push([
                'label' => $now->copy()->subDays($i)->locale('fr')->isoFormat('ddd'),
                'total' => $revenueByDay->get($date)?->total ?? 0,
            ]);
        }
        $maxDay = $days->max('total') ?: 1;

        // Top 5 produits par revenus
        $topProducts = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->leftJoin('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.status', '!=', 'cancelled')
            ->select(
                'order_items.product_id',
                'order_items.product_name',
                'products.image as product_image',
                DB::raw('SUM(order_items.quantity) as qty'),
                DB::raw('SUM(order_items.total_price) as revenue')
            )
            ->groupBy('order_items.product_id', 'order_items.product_name', 'products.image')
            ->orderByDesc('revenue')
            ->take(5)
            ->get();

        // Avis
        $totalReviews = Review::count();
        $avgRating    = Review::avg('rating') ?? 0;
        $ratingDist   = Review::select('rating', DB::raw('count(*) as count'))
            ->groupBy('rating')
            ->orderByDesc('rating')
            ->get()
            ->keyBy('rating');

        return view('admin.pages.analytique', compact(
            'revenueTotal', 'avgCart',
            'days', 'maxDay',
            'topProducts',
            'totalReviews', 'avgRating', 'ratingDist'
        ));
    }
}
