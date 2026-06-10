@php $title = "Mon profil"; @endphp

@extends('layouts.guest')

@section('content')
    @include('Shop.partials._navbar')

    <main class="content-main" style="padding:40px 20px">
        <div style="max-width:860px;margin:0 auto">

            <h1 style="font-size:22px;font-weight:700;margin-bottom:28px">Mon profil</h1>

            @if(session('success'))
                <div style="background:rgba(45,204,127,.15);border:1px solid #2dcc7f;color:#2dcc7f;padding:12px 16px;border-radius:8px;margin-bottom:20px;font-size:13px;">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div style="background:rgba(255,71,87,.15);border:1px solid #ff4757;color:#ff4757;padding:12px 16px;border-radius:8px;margin-bottom:20px;font-size:13px;">{{ session('error') }}</div>
            @endif

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">

                {{-- Informations personnelles --}}
                <div style="background:var(--card,#1a1a1a);border:1px solid var(--border,#2a2a2a);border-radius:12px;padding:22px;grid-column:span 2">
                    <div style="font-weight:600;font-size:15px;margin-bottom:18px">Informations personnelles</div>
                    <form method="POST" action="{{ route('shop.profil.update') }}">
                        @csrf @method('PUT')
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px">
                            <div>
                                <label style="font-size:12px;color:var(--muted,#888);display:block;margin-bottom:4px">Nom complet</label>
                                <input name="name" class="promo-input" style="width:100%" value="{{ old('name', $user->name) }}" required>
                                @error('name')<div style="color:#ff4757;font-size:11px;margin-top:3px">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label style="font-size:12px;color:var(--muted,#888);display:block;margin-bottom:4px">Email</label>
                                <input name="email" type="email" class="promo-input" style="width:100%" value="{{ old('email', $user->email) }}" required>
                                @error('email')<div style="color:#ff4757;font-size:11px;margin-top:3px">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label style="font-size:12px;color:var(--muted,#888);display:block;margin-bottom:4px">Téléphone</label>
                                <input name="phone" class="promo-input" style="width:100%" value="{{ old('phone', $user->phone) }}" placeholder="07 00 00 00 00">
                            </div>
                            <div style="display:flex;align-items:flex-end">
                                <button type="submit" class="promo-apply" style="width:100%">Enregistrer</button>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Changer le mot de passe --}}
                <div style="background:var(--card,#1a1a1a);border:1px solid var(--border,#2a2a2a);border-radius:12px;padding:22px">
                    <div style="font-weight:600;font-size:15px;margin-bottom:18px">Changer le mot de passe</div>
                    <form method="POST" action="{{ route('shop.profil.password') }}">
                        @csrf @method('PUT')
                        <div style="display:flex;flex-direction:column;gap:12px">
                            <div>
                                <label style="font-size:12px;color:var(--muted,#888);display:block;margin-bottom:4px">Mot de passe actuel</label>
                                <input name="current_password" type="password" class="promo-input" style="width:100%" required>
                                @error('current_password')<div style="color:#ff4757;font-size:11px;margin-top:3px">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label style="font-size:12px;color:var(--muted,#888);display:block;margin-bottom:4px">Nouveau mot de passe</label>
                                <input name="password" type="password" class="promo-input" style="width:100%" required>
                                @error('password')<div style="color:#ff4757;font-size:11px;margin-top:3px">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label style="font-size:12px;color:var(--muted,#888);display:block;margin-bottom:4px">Confirmer le nouveau</label>
                                <input name="password_confirmation" type="password" class="promo-input" style="width:100%" required>
                            </div>
                            <button type="submit" class="promo-apply">Modifier le mot de passe</button>
                        </div>
                    </form>
                </div>

                {{-- Commandes récentes --}}
                <div style="background:var(--card,#1a1a1a);border:1px solid var(--border,#2a2a2a);border-radius:12px;padding:22px">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px">
                        <div style="font-weight:600;font-size:15px">Commandes récentes</div>
                        <a href="{{ route('shop.commandes') }}" style="font-size:12px;color:var(--accent,#e8ff47);text-decoration:none">Voir tout →</a>
                    </div>
                    @forelse($orders as $order)
                    @php
                        $colors = ['pending'=>'#f39c12','confirmed'=>'#3498db','processing'=>'#9b59b6','shipped'=>'#1abc9c','delivered'=>'#2dcc7f','cancelled'=>'#ff4757'];
                        $labels = ['pending'=>'En attente','confirmed'=>'Confirmée','processing'=>'Traitement','shipped'=>'Expédiée','delivered'=>'Livrée','cancelled'=>'Annulée'];
                        $c = $colors[$order->status] ?? '#888';
                        $l = $labels[$order->status] ?? $order->status;
                    @endphp
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid var(--border,#2a2a2a);font-size:13px">
                        <div>
                            <a href="{{ route('shop.commandes.show', $order) }}" style="color:var(--accent,#e8ff47);text-decoration:none;font-weight:600">{{ $order->order_number }}</a>
                            <div style="color:var(--muted,#888);font-size:11px">{{ $order->created_at->format('d M Y') }}</div>
                        </div>
                        <div style="text-align:right">
                            <div style="font-weight:600">{{ number_format($order->total, 0, ',', ' ') }} F CFA</div>
                            <span style="font-size:11px;color:{{ $c }}">{{ $l }}</span>
                        </div>
                    </div>
                    @empty
                    <div style="color:var(--muted,#888);font-size:13px;text-align:center;padding:20px 0">Aucune commande.</div>
                    @endforelse
                </div>

            </div>

            {{-- Adresses de livraison --}}
            <div style="background:var(--card,#1a1a1a);border:1px solid var(--border,#2a2a2a);border-radius:12px;padding:22px;margin-top:20px">
                <div style="font-weight:600;font-size:15px;margin-bottom:18px">Adresses de livraison</div>

                <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:12px;margin-bottom:20px">
                    @forelse($addresses as $addr)
                    <div style="border:1px solid var(--border,#2a2a2a);border-radius:10px;padding:14px;position:relative">
                        @if($addr->is_default)
                        <span style="position:absolute;top:10px;right:10px;font-size:10px;background:rgba(232,255,71,.15);color:var(--accent,#e8ff47);padding:2px 8px;border-radius:4px">Par défaut</span>
                        @endif
                        <div style="font-weight:600;font-size:13px">{{ $addr->full_name }}</div>
                        <div style="font-size:12px;color:var(--muted,#888);margin-top:4px;line-height:1.6">
                            {{ $addr->phone }}<br>
                            {{ $addr->address_line }}{{ $addr->quartier ? ', ' . $addr->quartier : '' }}<br>
                            {{ $addr->city }}
                        </div>
                        <form method="POST" action="{{ route('shop.profil.address.destroy', $addr) }}" style="margin-top:10px" onsubmit="return confirm('Supprimer cette adresse ?')">
                            @csrf @method('DELETE')
                            <button type="submit" style="font-size:11px;color:#ff4757;background:none;border:none;cursor:pointer;padding:0">Supprimer</button>
                        </form>
                    </div>
                    @empty
                    <div style="color:var(--muted,#888);font-size:13px">Aucune adresse enregistrée.</div>
                    @endforelse
                </div>

                {{-- Ajouter adresse --}}
                <div style="border-top:1px solid var(--border,#2a2a2a);padding-top:16px">
                    <div style="font-size:13px;font-weight:600;margin-bottom:12px;cursor:pointer" onclick="this.nextElementSibling.style.display=this.nextElementSibling.style.display==='none'?'':'none'">
                        + Ajouter une adresse
                    </div>
                    <form method="POST" action="{{ route('shop.profil.address.store') }}" style="display:none">
                        @csrf
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
                            <div>
                                <label style="font-size:12px;color:var(--muted,#888)">Nom complet</label>
                                <input name="full_name" class="promo-input" style="width:100%;margin-top:4px" required>
                            </div>
                            <div>
                                <label style="font-size:12px;color:var(--muted,#888)">Téléphone</label>
                                <input name="phone" class="promo-input" style="width:100%;margin-top:4px" required>
                            </div>
                            <div>
                                <label style="font-size:12px;color:var(--muted,#888)">Ville</label>
                                <input name="city" class="promo-input" style="width:100%;margin-top:4px" required>
                            </div>
                            <div>
                                <label style="font-size:12px;color:var(--muted,#888)">Quartier</label>
                                <input name="quartier" class="promo-input" style="width:100%;margin-top:4px">
                            </div>
                            <div style="grid-column:span 2">
                                <label style="font-size:12px;color:var(--muted,#888)">Adresse complète</label>
                                <input name="address_line" class="promo-input" style="width:100%;margin-top:4px" required>
                            </div>
                            <div style="grid-column:span 2;display:flex;align-items:center;gap:8px">
                                <input type="checkbox" name="is_default" value="1" id="p-default" style="accent-color:var(--accent,#e8ff47)">
                                <label for="p-default" style="font-size:13px;cursor:pointer">Définir comme adresse par défaut</label>
                            </div>
                        </div>
                        <button type="submit" class="promo-apply" style="margin-top:14px">Enregistrer</button>
                    </form>
                </div>
            </div>

        </div>
    </main>
@endsection
