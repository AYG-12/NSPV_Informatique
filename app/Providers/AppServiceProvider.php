<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Review;
use App\Models\Promotion;
use App\Models\Setting;
use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Compteurs → sidebar admin
        View::composer('admin.*', function ($view) {
            $view->with('pendingOrdersCount',  Order::where('status', 'pending')->count());
            $view->with('pendingReviewsCount', Review::where('is_approved', false)->count());
        });

        // Paramètres de la boutique → disponibles dans toutes les vues
        View::share('appSettings', Setting::all_cached());

        // Wishlist → IDs et compteur pour les vues Shop
        View::composer('Shop.*', function ($view) {
            if (Auth::check()) {
                $ids   = Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray();
                $count = count($ids);
            } else {
                $ids   = [];
                $count = 0;
            }
            $view->with('wishlistProductIds', $ids);
            $view->with('wishlistCount', $count);
        });

        // Force Carbon à utiliser le français
        Carbon::setLocale('fr');

        // On définit les vues qui doivent recevoir ces données
        // Vous pouvez mettre un tableau de vues ou '*' pour toutes les vues
        View::composer(['admin.pages.promotions', 'Shop.*'], function ($view) {
            
            $active = Promotion::where('is_active', true)
                                ->where('expires_at', '>', now())
                                ->latest()
                                ->get();
                                
            $expired = Promotion::where(function ($q) {
                $q->where('is_active', false)
                  ->orWhere('expires_at', '<', now());
            })->latest()->get();

            // On injecte les variables dans les vues concernées
            $activeCount = $active->count();
            $view->with([
                'active'      => $active,
                'expired'     => $expired,
                'activeCount' => $activeCount
            ]);
        });
    }
}
