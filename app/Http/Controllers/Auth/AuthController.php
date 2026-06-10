<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showConnexion()
    {
        if (Auth::check()) {
            return redirect($this->redirectAfterLogin());
        }

        return view('pages.connexion');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required'    => 'L\'adresse e-mail est obligatoire.',
            'email.email'       => 'L\'adresse e-mail n\'est pas valide.',
            'password.required' => 'Le mot de passe est obligatoire.',
        ]);

        $key = 'login:' . Str::lower($request->email) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()
                ->withInput($request->only('email'))
                ->with('_form', 'login')
                ->withErrors(['email' => "Trop de tentatives. Réessayez dans {$seconds} secondes."]);
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            RateLimiter::clear($key);
            $request->session()->regenerate();

            return redirect($this->redirectAfterLogin());
        }

        RateLimiter::hit($key, 300); // blocage 5 min après 5 échecs

        return back()
            ->withInput($request->only('email'))
            ->with('_form', 'login')
            ->withErrors(['email' => 'Email ou mot de passe incorrect.']);
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'firstname' => ['required', 'string', 'max:100'],
            'lastname'  => ['required', 'string', 'max:100'],
            'email'     => ['required', 'email', 'unique:users,email'],
            'phone'     => ['nullable', 'string', 'max:20'],
            'password'  => ['required', 'confirmed', Password::min(8)],
        ], [
            'firstname.required' => 'Le prénom est obligatoire.',
            'lastname.required'  => 'Le nom est obligatoire.',
            'email.required'     => 'L\'adresse e-mail est obligatoire.',
            'email.email'        => 'L\'adresse e-mail n\'est pas valide.',
            'email.unique'       => 'Cet e-mail est déjà utilisé.',
            'password.required'  => 'Le mot de passe est obligatoire.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
            'password.min'       => 'Le mot de passe doit contenir au moins 8 caractères.',
        ]);

        $user = User::create([
            'name'     => trim($data['firstname'] . ' ' . $data['lastname']),
            'email'    => $data['email'],
            'phone'    => $data['phone'] ?? null,
            'password' => Hash::make($data['password']),
            'role'     => 'client',
        ]);

        Auth::login($user);

        return redirect('/Shop')->with('success', 'Bienvenue ' . $user->name . ' ! Votre compte a été créé.');
    }

    public function logout(Request $request)
    {
        $referer = $request->headers->get('referer', '/');

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Rediriger vers l'accueil de la section d'origine
        if (str_contains($referer, '/welAdminnspv')) {
            return redirect('/');
        }

        if (str_contains($referer, '/Shop')) {
            return redirect('/Shop');
        }

        return redirect('/');
    }

    private function redirectAfterLogin(): string
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return '/welAdminnspv';
        }

        return '/Shop';
    }
}
