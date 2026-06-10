<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('connexion')
                ->with('error', 'Connexion Google annulée ou échouée. Réessayez.');
        }

        // Chercher un compte existant par google_id ou par email
        $user = User::where('google_id', $googleUser->getId())->first()
            ?? User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            // Associer google_id si ce n'est pas encore fait
            if (! $user->google_id) {
                $user->update(['google_id' => $googleUser->getId()]);
            }
        } else {
            // Créer un nouveau compte client
            $user = User::create([
                'name'      => $googleUser->getName(),
                'email'     => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar'    => $googleUser->getAvatar(),
                'role'      => 'client',
                'password'  => null,
            ]);
        }

        Auth::login($user, true);

        return redirect($user->isAdmin() ? '/welAdminnspv' : '/Shop')
            ->with('success', 'Bienvenue ' . $user->name . ' !');
    }
}
