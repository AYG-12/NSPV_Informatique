<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PageVisit;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $now       = now();
        $startMonth = $now->copy()->startOfMonth();
        $lastMonth  = $now->copy()->subMonth()->startOfMonth();
        $endLast    = $now->copy()->subMonth()->endOfMonth();

        // Revenus ce mois vs mois dernier
        $revenueThisMonth = Order::where('status', '!=', 'cancelled')
            ->whereBetween('created_at', [$startMonth, $now])
            ->sum('total');

        $revenueLastMonth = Order::where('status', '!=', 'cancelled')
            ->whereBetween('created_at', [$lastMonth, $endLast])
            ->sum('total');

        $revenuePct = $revenueLastMonth > 0
            ? round((($revenueThisMonth - $revenueLastMonth) / $revenueLastMonth) * 100, 1)
            : 0;

        // Commandes ce mois
        $ordersThisMonth = Order::whereBetween('created_at', [$startMonth, $now])->count();
        $ordersLastMonth = Order::whereBetween('created_at', [$lastMonth, $endLast])->count();
        $ordersPct = $ordersLastMonth > 0
            ? round((($ordersThisMonth - $ordersLastMonth) / $ordersLastMonth) * 100, 1)
            : 0;

        // Clients ce mois
        $clientsThisMonth = User::where('role', 'client')->whereBetween('created_at', [$startMonth, $now])->count();
        $clientsLastMonth = User::where('role', 'client')->whereBetween('created_at', [$lastMonth, $endLast])->count();
        $clientsPct = $clientsLastMonth > 0
            ? round((($clientsThisMonth - $clientsLastMonth) / $clientsLastMonth) * 100, 1)
            : 0;

        // Commandes en attente
        $pendingCount = Order::where('status', 'pending')->count();

        // Visites du site
        $visitsToday     = PageVisit::where('date', today())->value('count') ?? 0;
        $visitsThisMonth = PageVisit::whereBetween('date', [$startMonth->toDateString(), $now->toDateString()])->sum('count');
        $visitsLastMonth = PageVisit::whereBetween('date', [$lastMonth->toDateString(), $endLast->toDateString()])->sum('count');
        $visitsTotal     = PageVisit::sum('count');
        $visitsPct       = $visitsLastMonth > 0
            ? round((($visitsThisMonth - $visitsLastMonth) / $visitsLastMonth) * 100, 1)
            : 0;

        // 5 dernières commandes
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Produits en stock faible (≤5 et non null)
        $lowStock = Product::where('is_active', true)
            ->whereNotNull('stock')
            ->where('stock', '<=', 5)
            ->orderBy('stock')
            ->take(5)
            ->get();

        // Ventes par catégorie (top 5)
        $salesByCategory = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', '!=', 'cancelled')
            ->select('categories.name', DB::raw('SUM(order_items.total_price) as total'))
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'revenueThisMonth', 'revenuePct',
            'ordersThisMonth', 'ordersPct',
            'clientsThisMonth', 'clientsPct',
            'pendingCount',
            'recentOrders',
            'lowStock',
            'salesByCategory',
            'visitsToday', 'visitsThisMonth', 'visitsTotal', 'visitsPct'
        ));
    }
}
