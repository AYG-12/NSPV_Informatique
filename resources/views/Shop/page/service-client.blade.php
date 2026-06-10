@php $title = "Service Client"; @endphp

@extends('layouts.guest')
@section('content')
    @include('Shop.partials._navbar')

    <div class="service_client">
        <h1>Service Client</h1>
        <div class="info_service_client">
            <p>
                Bienvenue sur notre page de service client ! Chez {{ $appSettings['shop_name'] ?? 'nous' }}, nous sommes dédiés à fournir un support exceptionnel à nos clients. Que vous ayez des questions sur nos produits, besoin d'aide pour passer une commande ou que vous souhaitiez en savoir plus sur nos services, notre équipe de service client est là pour vous aider.
            </p>
            <p>
                Notre service client est disponible pour répondre à toutes vos préoccupations et vous offrir une expérience d'achat fluide et agréable. N'hésitez pas à nous contacter via notre formulaire de <a href="{{ url('/contact') }}">contact</a>
                @if(!empty($appSettings['shop_phone'])), par <a href="tel:{{ preg_replace('/\s+/', '', $appSettings['shop_phone']) }}">téléphone</a>@endif
                ou par Whatsapp. Nous nous engageons à répondre à vos demandes dans les plus brefs délais.
            </p>
            <p>
                Chez nous, votre satisfaction est notre priorité. Merci de choisir {{ $appSettings['shop_name'] ?? 'notre boutique' }} pour vos besoins informatiques !
            </p>
        </div>

        <div class="img_sc">
            <img src="{{Vite::asset('./resources/images/support.jpeg')}}" alt="image service client">
        </div>
    </div>
@endsection