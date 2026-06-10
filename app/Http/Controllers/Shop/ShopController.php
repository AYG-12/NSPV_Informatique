<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function home()
    {
        $featuredProducts = Product::with('category')
            ->where('is_active', true)
            ->where('is_featured', true)
            ->latest()
            ->take(5)
            ->get();

        $bannerProd = Product::with('Category')->where('is_active', true)->latest()->take(3)->get();

        // Si pas assez de produits en vedette, compléter avec les derniers produits
        if ($featuredProducts->count() < 4) {
            $featuredProducts = Product::with('category')
                ->where('is_active', true)
                ->latest()
                ->take(5)
                ->get();
        }

        return view('Shop.home_product', compact('featuredProducts', 'bannerProd'));
    }

    public function produits(Request $request)
    {
        $settings = Setting::all_cached();

        $categories = Category::where('is_active', true)
            ->withCount(['products' => fn($q) => $q->where('is_active', true)])
            ->get();

        $query = Product::with(['category', 'reviews'])->where('is_active', true);

        if ($request->filled('categorie')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->categorie));
        }

        if ($request->filled('pmin')) {
            $query->where('price', '>=', $request->pmin);
        }

        if ($request->filled('pmax')) {
            $query->where('price', '<=', $request->pmax);
        }

        // Use setting-driven default sort when no explicit sort param given
        $defaultSort = match ($settings['default_sort'] ?? 'latest') {
            'price_asc' => 'price-asc',
            'popular'   => 'popular',
            default     => 'latest',
        };
        $sort = $request->get('tri', $defaultSort);

        match ($sort) {
            'price-asc'  => $query->orderBy('price', 'asc'),
            'price-desc' => $query->orderBy('price', 'desc'),
            'name'       => $query->orderBy('name', 'asc'),
            'popular'    => $query->withCount('orderItems')->orderByDesc('order_items_count'),
            default      => $query->latest(),
        };

        $products = $query->get();

        return view('Shop.page.produit', compact('products', 'categories'));
    }

    public function avisPage(string $slug)
    {
        $product = Product::with(['category', 'reviews' => fn($q) => $q->where('is_approved', true)->with('user')->latest()])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $reviews     = $product->reviews;
        $maxRating   = $reviews->max('rating');
        $reviewCount = $reviews->count();

        $distribution = collect(range(5, 1))->mapWithKeys(
            fn($star) => [$star => $reviews->where('rating', $star)->count()]
        );

        return view('Shop.page.avis-produit', compact('product', 'reviews', 'maxRating', 'reviewCount', 'distribution'));
    }

    public function fiche(string $slug)
    {
        $product = Product::with(['category', 'images', 'reviews.user'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $related = Product::with('category')
            ->where('is_active', true)
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('Shop.page.fiche_produit', compact('product', 'related'));
    }
}
