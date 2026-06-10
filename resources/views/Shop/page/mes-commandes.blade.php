@php $title = "Mes commandes"; @endphp

@extends('layouts.guest')

@section('content')
    @include('Shop.partials._navbar')
    
    <main style="padding:100px;">

        <div style="max-width:860px;margin:0 auto;">

            <h1 style="font-size:22px;font-weight:700; margin-top: 10px;">Mes commandes</h1>

            @forelse($orders as $order)
                @php
                    $statusMap = [
                        'pending'    => ['label' => 'En attente',  'color' => '#f39c12'],
                        'confirmed'  => ['label' => 'Confirmée',   'color' => '#3498db'],
                        'processing' => ['label' => 'Traitement',  'color' => '#9b59b6'],
                        'shipped'    => ['label' => 'Expédiée',    'color' => '#1abc9c'],
                        'delivered'  => ['label' => 'Livrée',      'color' => '#2dcc7f'],
                        'cancelled'  => ['label' => 'Annulée',     'color' => '#ff4757'],
                    ];
                    $s = $statusMap[$order->status] ?? ['label' => $order->status, 'color' => '#888'];
                @endphp
                <div style="background:var(--card,#1a1a1a);border:1px solid var(--border,#2a2a2a);border-radius:12px;padding:18px 20px;margin-bottom:14px;">
                    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;">
                        <div>
                            <div style="font-weight:700;font-size:15px;">{{ $order->order_number }}</div>
                            <div style="color:var(--muted,#888);font-size:12px;margin-top:3px;">
                                {{ $order->created_at->format('d M Y') }} ·
                                {{ $order->items->count() }} article{{ $order->items->count() > 1 ? 's' : '' }}
                            </div>
                        </div>
                        <div style="display:flex;align-items:center;gap:14px;">
                            <span style="font-weight:700;font-size:15px;">{{ number_format($order->total, 0, ',', ' ') }} F CFA</span>
                            <span style="background:{{ $s['color'] }}22;color:{{ $s['color'] }};border:1px solid {{ $s['color'] }};padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600;">
                                {{ $s['label'] }}
                            </span>
                            <a href="{{ route('shop.commandes.show', $order) }}"
                            style="font-size:13px;color:var(--accent,#e8ff47);text-decoration:none;font-weight:500;">
                                Détails →
                            </a>
                            @if($order->status === 'pending')
                            <form method="POST" action="{{ route('shop.commandes.cancel', $order) }}"
                                onsubmit="return confirm('Annuler la commande {{ $order->order_number }} ? Cette action est irréversible.')">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        style="font-size:12px;color:#ff4757;background:transparent;border:1px solid #ff475740;padding:4px 12px;border-radius:20px;cursor:pointer;font-family:inherit;transition:background .2s;"
                                        onmouseover="this.style.background='rgba(255,71,87,.12)'"
                                        onmouseout="this.style.background='transparent'">
                                    Annuler
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>

                    @if($order->items->isNotEmpty())
                        <div style="margin-top:10px;padding-top:10px;border-top:1px solid var(--border,#2a2a2a);font-size:13px;color:var(--muted,#888);">
                            {{ $order->items->pluck('product_name')->take(3)->implode(', ') }}{{ $order->items->count() > 3 ? '…' : '' }}
                        </div>
                    @endif
                </div>
            @empty
                <div style="text-align:center;padding:60px 20px;color:var(--muted,#888)">
                    <div style="font-size:40px;margin-bottom:14px">🛒</div>
                    <div style="font-size:16px;font-weight:600;margin-bottom:8px">Aucune commande pour l'instant</div>
                    <a href="{{ route('shop.produits') }}" class="pay-btn" style="display:inline-block;margin-top:12px;padding:10px 24px;border-radius:8px;text-decoration:none;font-size:14px">Découvrir nos produits</a>
                </div>
            @endforelse

            
            @if($orders->hasPages())
                <div style="margin-top:20px; color:#ff4757; background:#e8ff47;">{{ $orders->links() }}</div>
            @endif
        </div>
    </main>
@endsection
