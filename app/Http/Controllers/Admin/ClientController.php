<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'client')
            ->withCount('orders')
            ->withSum(['orders as total_spent' => fn($q) => $q->where('status', '!=', 'cancelled')], 'total');

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->q . '%')
                  ->orWhere('email', 'like', '%' . $request->q . '%');
            });
        }

        if ($request->filled('segment')) {
            match ($request->segment) {
                'vip'     => $query->having('orders_count', '>=', 10),
                'regulier'=> $query->having('orders_count', '>=', 3)->having('orders_count', '<', 10),
                'nouveau' => $query->having('orders_count', '<', 3),
                default   => null,
            };
        }

        $clients     = $query->latest()->paginate(8)->withQueryString();
        $totalClients = User::where('role', 'client')->count();

        return view('admin.pages.clients', compact('clients', 'totalClients'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'phone'    => ['nullable', 'string', 'max:30'],
            'password' => ['nullable', 'string', 'min:8'],
        ], [
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
        ]);

        $data['role']     = 'client';
        $data['password'] = $data['password'] ? Hash::make($data['password']) : null;

        $client = User::create($data);

        return redirect()->route('admin.clients')
            ->with('success', 'Client "' . $client->name . '" créé avec succès.');
    }

    public function update(Request $request, User $user)
    {
        abort_if($user->role === 'admin', 403);

        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email,' . $user->id],
            'phone'    => ['nullable', 'string', 'max:30'],
            'password' => ['nullable', 'string', 'min:8'],
        ], [
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.clients')
            ->with('success', 'Client "' . $user->name . '" mis à jour.');
    }

    public function destroy(User $user)
    {
        abort_if($user->role === 'admin', 403);
        $user->delete();

        return redirect()->route('admin.clients')
            ->with('success', 'Client "' . $user->name . '" supprimé.');
    }
}
