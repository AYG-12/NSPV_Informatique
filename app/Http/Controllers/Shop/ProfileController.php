<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show()
    {
        /** @var \App\Models\User $user */
        $user      = Auth::user();
        $addresses = $user->addresses()->orderByDesc('is_default')->get();
        $orders    = $user->orders()->latest()->take(5)->get();

        return view('Shop.page.profil', compact('user', 'addresses', 'orders'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $data = $request->validate([
            'name'  => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $user->update($data);

        return back()->with('success', 'Profil mis à jour.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', Password::min(8)],
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Mot de passe modifié.');
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

        $data['user_id'] = Auth::id();

        if (! empty($data['is_default'])) {
            Address::where('user_id', Auth::id())->update(['is_default' => false]);
        }

        Address::create($data);

        return back()->with('success', 'Adresse ajoutée.');
    }

    public function destroyAddress(Address $address)
    {
        abort_if($address->user_id !== Auth::id(), 403);
        $address->delete();

        return back()->with('success', 'Adresse supprimée.');
    }
}
