<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ParametresController extends Controller
{
    public function index(Request $request)
    {
        $s = Setting::all_cached();
        $activeSection = $request->session()->has('errors')
            ? 'securite'
            : session('active_section', 'general');
        return view('admin.pages.parametres', compact('s', 'activeSection'));
    }

    public function updateGeneral(Request $request)
    {
        $data = $request->validate([
            'shop_name'        => ['required', 'string', 'max:100'],
            'shop_email'       => ['required', 'email'],
            'shop_phone'       => ['nullable', 'string', 'max:30'],
            'shop_address'     => ['nullable', 'string', 'max:255'],
            'shop_description' => ['nullable', 'string', 'max:500'],
        ]);

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => 'Informations générales enregistrées.']);
        }

        return redirect()->route('admin.parametres')
            ->with('success', 'Informations générales enregistrées.')
            ->with('active_section', 'general');
    }

    public function updateBoutique(Request $request)
    {
        Setting::set('products_per_page', $request->input('products_per_page', '24'));
        Setting::set('default_sort',      $request->input('default_sort', 'latest'));
        Setting::set('show_reviews',      $request->boolean('show_reviews') ? '1' : '0');
        Setting::set('show_stock',        $request->boolean('show_stock')   ? '1' : '0');
        Setting::set('wishlist_enabled',  $request->boolean('wishlist_enabled') ? '1' : '0');

        if ($request->expectsJson()) {
            return response()->json(['success' => 'Configuration boutique enregistrée.']);
        }

        return redirect()->route('admin.parametres')
            ->with('success', 'Configuration boutique enregistrée.')
            ->with('active_section', 'boutique');
    }

    public function updateLivraison(Request $request)
    {
        $request->validate([
            'free_shipping_threshold' => ['nullable', 'numeric', 'min:0'],
            'shipping_delay'          => ['nullable', 'string', 'max:50'],
        ]);

        Setting::set('free_shipping_threshold', $request->input('free_shipping_threshold', '0'));
        Setting::set('shipping_delay',          $request->input('shipping_delay', ''));
        Setting::set('express_shipping',        $request->boolean('express_shipping') ? '1' : '0');
        Setting::set('store_pickup',            $request->boolean('store_pickup')     ? '1' : '0');

        if ($request->expectsJson()) {
            return response()->json(['success' => 'Paramètres de livraison enregistrés.']);
        }

        return redirect()->route('admin.parametres')
            ->with('success', 'Paramètres de livraison enregistrés.')
            ->with('active_section', 'livraison');
    }

    public function updatePaiement(Request $request)
    {
        Setting::set('payment_mobile_money', $request->boolean('payment_mobile_money') ? '1' : '0');
        Setting::set('payment_stripe',       $request->boolean('payment_stripe')       ? '1' : '0');
        Setting::set('payment_paypal',       $request->boolean('payment_paypal')       ? '1' : '0');
        Setting::set('payment_cod',          $request->boolean('payment_cod')          ? '1' : '0');

        if ($request->expectsJson()) {
            return response()->json(['success' => 'Méthodes de paiement enregistrées.']);
        }

        return redirect()->route('admin.parametres')
            ->with('success', 'Méthodes de paiement enregistrées.')
            ->with('active_section', 'paiement');
    }

    public function updateNotifications(Request $request)
    {
        Setting::set('notif_new_order',     $request->boolean('notif_new_order')     ? '1' : '0');
        Setting::set('notif_low_stock',     $request->boolean('notif_low_stock')     ? '1' : '0');
        Setting::set('notif_new_review',    $request->boolean('notif_new_review')    ? '1' : '0');
        Setting::set('notif_weekly_report', $request->boolean('notif_weekly_report') ? '1' : '0');

        if ($request->expectsJson()) {
            return response()->json(['success' => 'Notifications enregistrées.']);
        }

        return redirect()->route('admin.parametres')
            ->with('success', 'Notifications enregistrées.')
            ->with('active_section', 'notifications');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.current_password' => 'Le mot de passe actuel est incorrect.',
            'password.confirmed'                => 'Les mots de passe ne correspondent pas.',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->update(['password' => Hash::make($request->password)]);

        if ($request->expectsJson()) {
            return response()->json(['success' => 'Mot de passe mis à jour.']);
        }

        return redirect()->route('admin.parametres')
            ->with('success', 'Mot de passe mis à jour.')
            ->with('active_section', 'securite');
    }
}
