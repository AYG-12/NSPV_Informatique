@php $title = "A propos"; @endphp

@extends('layouts.guest')

@include('partials._navbar')

@section('content')
<main class="content-main apropos">
    <h1>À propos de {{ $appSettings['shop_name'] ?? 'Nous' }}</h1>

    @if(!empty($appSettings['shop_description']))
    <p class="about-desc">{{ $appSettings['shop_description'] }}</p>
    @endif

    <div class="about-info">
        @if(!empty($appSettings['shop_address']))
        <p><span>Adresse :</span> {{ $appSettings['shop_address'] }}</p>
        @endif
        @if(!empty($appSettings['shop_phone']))
        <p><span>Téléphone :</span> {{ $appSettings['shop_phone'] }}</p>
        @endif
        @if(!empty($appSettings['shop_email']))
        <p><span>Email :</span> <a href="mailto:{{ $appSettings['shop_email'] }}">{{ $appSettings['shop_email'] }}</a></p>
        @endif
    </div>
</main>
@endsection