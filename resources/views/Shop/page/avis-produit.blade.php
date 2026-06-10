@php $title = "Avis — " . $product->name; @endphp

@extends('layouts.guest')

@section('content')
    @include('Shop.partials._navbar')

    <style>
        .avis-page {
            max-width: 860px;
            margin: 0 auto;
            padding: 100px 20px 60px;
        }

        /* Carte produit résumé */
        .avis-product-header {
            display: flex;
            align-items: center;
            gap: 16px;
            background: var(--card, #1a1a1a);
            border: 1px solid var(--border, #2a2a2a);
            border-radius: 14px;
            padding: 16px 20px;
            margin-bottom: 28px;
        }
        .avis-product-header img {
            width: 72px;
            height: 72px;
            object-fit: cover;
            border-radius: 10px;
            flex-shrink: 0;
        }
        .avis-product-header .prod-meta { flex: 1; min-width: 0; }
        .avis-product-header .prod-meta h1 {
            font-size: 17px;
            font-weight: 700;
            margin: 0 0 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .avis-product-header .prod-meta span {
            font-size: 12px;
            color: var(--muted, #888);
        }
        .avis-back {
            font-size: 13px;
            color: var(--muted, #888);
            text-decoration: none;
            white-space: nowrap;
            transition: color .2s;
        }
        .avis-back:hover { color: var(--accent, #e8ff47); }

        /* Bloc résumé note */
        .avis-summary {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 28px;
            background: var(--card, #1a1a1a);
            border: 1px solid var(--border, #2a2a2a);
            border-radius: 14px;
            padding: 24px 28px;
            margin-bottom: 28px;
        }
        .avis-score {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding-right: 28px;
            border-right: 1px solid var(--border, #2a2a2a);
            min-width: 110px;
        }
        .avis-score .big-num {
            font-size: 52px;
            font-weight: 800;
            line-height: 1;
            color: var(--accent, #e8ff47);
        }
        .avis-score .stars-row { font-size: 22px; letter-spacing: 2px; }
        .avis-score .count-lbl { font-size: 12px; color: var(--muted, #888); }
        .avis-bars { display: flex; flex-direction: column; gap: 8px; justify-content: center; }
        .avis-bar-row { display: flex; align-items: center; gap: 10px; font-size: 13px; }
        .avis-bar-row .lbl { width: 24px; text-align: right; color: var(--muted, #888); flex-shrink: 0; }
        .avis-bar-row .bar-track {
            flex: 1;
            height: 8px;
            background: var(--border, #2a2a2a);
            border-radius: 999px;
            overflow: hidden;
        }
        .avis-bar-row .bar-fill {
            height: 100%;
            background: var(--accent, #e8ff47);
            border-radius: 999px;
            transition: width .4s ease;
        }
        .avis-bar-row .bar-count { width: 20px; color: var(--muted, #888); font-size: 12px; }

        /* Liste des avis */
        .avis-list { display: flex; flex-direction: column; gap: 14px; }
        .avis-card {
            background: var(--card, #1a1a1a);
            border: 1px solid var(--border, #2a2a2a);
            border-radius: 12px;
            padding: 18px 20px;
            transition: border-color .2s;
        }
        .avis-card:hover { border-color: rgba(232,255,71,.3); }
        .avis-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
            flex-wrap: wrap;
            gap: 8px;
        }
        .avis-card-author {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .avis-avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: rgba(232,255,71,.15);
            color: var(--accent, #e8ff47);
            font-size: 13px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .avis-card-author .name { font-weight: 600; font-size: 14px; }
        .avis-card-author .date { font-size: 12px; color: var(--muted, #888); margin-top: 2px; }
        .avis-stars { font-size: 18px; letter-spacing: 1px; }
        .avis-comment { font-size: 14px; color: var(--muted, #aaa); margin: 0; line-height: 1.65; }

        /* Vide */
        .avis-empty {
            text-align: center;
            padding: 56px 20px;
            color: var(--muted, #888);
            font-size: 14px;
            border: 1px dashed var(--border, #2a2a2a);
            border-radius: 12px;
        }
        .avis-empty .emoji { font-size: 36px; display: block; margin-bottom: 12px; }

        /* Responsive */
        @media (max-width: 600px) {
            .avis-summary { grid-template-columns: 1fr; gap: 20px; }
            .avis-score { border-right: none; border-bottom: 1px solid var(--border, #2a2a2a); padding-right: 0; padding-bottom: 20px; flex-direction: row; gap: 20px; }
            .avis-score .big-num { font-size: 40px; }
            .avis-product-header { flex-wrap: wrap; }
            .avis-back { order: -1; width: 100%; }
        }
    </style>

    <main class="avis-page">

        {{-- En-tête produit --}}
        <div class="avis-product-header">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
            @else
                <img src="{{ Vite::asset('resources/images/background.jpeg') }}" alt="{{ $product->name }}">
            @endif
            <div class="prod-meta">
                <h1>{{ $product->name }}</h1>
                <span>{{ $product->category->name }}</span>
            </div>
            <a href="{{ route('shop.fiche', $product->slug) }}" class="avis-back">← Retour au produit</a>
        </div>

        @if($reviewCount > 0)

        {{-- Résumé de la note --}}
        <div class="avis-summary">
            <div class="avis-score">
                <div class="big-num">{{ $maxRating }}</div>
                <div class="stars-row">
                    @for($i = 1; $i <= 5; $i++)
                        <span style="color:{{ $i <= $maxRating ? '#fff700' : '#444' }}">★</span>
                    @endfor
                </div>
                <div class="count-lbl">{{ $reviewCount }} {{ $reviewCount > 1 ? 'avis' : 'avis' }}</div>
            </div>

            <div class="avis-bars">
                @foreach($distribution as $star => $count)
                <div class="avis-bar-row">
                    <span class="lbl">{{ $star }}★</span>
                    <div class="bar-track">
                        <div class="bar-fill" style="width:{{ $reviewCount > 0 ? round($count / $reviewCount * 100) : 0 }}%"></div>
                    </div>
                    <span class="bar-count">{{ $count }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Liste des avis --}}
        <div class="avis-list">
            @foreach($reviews as $review)
            @php
                $initials = collect(explode(' ', $review->user->name ?? 'C'))
                    ->map(fn($w) => strtoupper(substr($w, 0, 1)))->take(2)->implode('');
            @endphp
            <div class="avis-card">
                <div class="avis-card-header">
                    <div class="avis-card-author">
                        <div class="avis-avatar">{{ $initials }}</div>
                        <div>
                            <div class="name">{{ $review->user->name ?? 'Client' }}</div>
                            <div class="date">{{ $review->created_at->translatedFormat('d F Y') }}</div>
                        </div>
                    </div>
                    <div style="display:flex;align-items:center;gap:6px">
                        <div class="avis-stars">
                            @for($i = 1; $i <= 5; $i++)
                                <span style="color:{{ $i <= $review->rating ? '#fff700' : '#444' }}">★</span>
                            @endfor
                        </div>
                        <span style="font-size:13px;color:var(--muted,#888)">{{ $review->rating }}/5</span>
                    </div>
                </div>
                @if($review->comment)
                <p class="avis-comment">{{ $review->comment }}</p>
                @endif
            </div>
            @endforeach
        </div>

        @else

        <div class="avis-empty">
            <span class="emoji">💬</span>
            Aucun avis pour ce produit pour le moment.<br>
            <a href="{{ route('shop.fiche', $product->slug) }}" style="color:var(--accent,#e8ff47);margin-top:12px;display:inline-block">
                Voir le produit
            </a>
        </div>

        @endif

    </main>
@endsection
