@php $title = "Acceuil"; @endphp

@extends('layouts.guest')

@include('partials._navbar')

@section('content')

    <!-- Part Banner -->
     <div class=" home_banner">
        <div class="banner_content">
            <h1>Bienvenue chez NSPV Informatique</h1>
            <p>Votre partenaire de confiance pour la vente d'ordinateurs et de services informatiques.</p>
            <a href="{{ url('/Shop') }}" class="bt">Accéder à la boutique</a>
        </div>
     </div>
    <!-- Partie Service -->
    <div class="services">
        <h2>Nos services</h2> 

        <div class="serv_grid">
            <div class="serv">
                <div class="serv_ico">
                    <img src="{{Vite::asset('resources/images/maintenance.jpg')}}" alt="">
                </div>
                <div class="serv-info">
                    <h3>maintenance informatiques</h3>
                    <p>Service complet de maintenance préventive et corrective pour garder vos équipements en parfait état de fonctionnement.</p>
                </div>
            </div>

            <div class="serv">
                <div class="serv_ico">
                    <img src="{{Vite::asset('resources/images/support.jpeg')}}" alt="">
                </div>
                <div class="serv-info">
                    <h3>support technique à distance</h3>
                    <p>Service complet de maintenance préventive et corrective pour garder vos équipements en parfait état de fonctionnement.</p>
                </div>
            </div>
            <div class="serv">
                <div class="serv_ico">
                    <img src="{{Vite::asset('resources/images/installation.jpeg')}}" alt="">
                </div>
                <div class="serv-info">
                    <h3>installation de logiciels</h3>
                    <p>Service complet de maintenance préventive et corrective pour garder vos équipements en parfait état de fonctionnement.</p>
                </div>
            </div>
        </div>

        <p><a href="#">Cliquez-ici</a> pour découvrir encore d'autres services.</p>
    </div>
@endsection