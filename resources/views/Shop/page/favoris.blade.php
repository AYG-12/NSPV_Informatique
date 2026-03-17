@php $title = "Favoris"; @endphp

@extends('layouts.guest')

<!-- Appel de la barre de navigation -->
@include('Shop.partials._navbar')

@section('content')
    <main class="content-favoris">
        <div class="favoris">

            <div class="pro_favoris">
                <div class="cont_favoris">
                    <div class="favoris_pro_img">
                        <a href="{{url('Shop/fiche_produit')}}" title="Détail du produit">
                            <img src="{{ Vite::asset('resources/images/background.jpeg') }}" alt="Image du produit">
                        </a>
                    </div>
                    <div class="favoris_pro_info">
                        <h2>PC Gamer</h2>
                        <p>999,99 F CFA</p>
                    </div>
                </div>
                <div class="act_favoris">
                    <a href="#" class="fav_btn_sup">Supprimer</a>
                    <a href="#" class="fav_btn_ajou">Ajouter</a>
                </div>
            </div>

            <div class="pro_favoris">
                <div class="cont_favoris">
                    <div class="favoris_pro_img">
                        <a href="{{url('Shop/fiche_produit')}}" title="Détail du produit">
                            <img src="{{ Vite::asset('resources/images/background.jpeg') }}" alt="Image du produit">
                        </a>
                    </div>
                    <div class="favoris_pro_info">
                        <h2>PC Gamer</h2>
                        <p>999,99 F CFA</p>
                    </div>
                </div>
                <div class="act_favoris">
                    <a href="#" class="fav_btn_sup">Supprimer</a>
                    <a href="#" class="fav_btn_ajou">Ajouter</a>
                </div>
            </div>

            <div class="pro_favoris">
                <div class="cont_favoris">
                    <div class="favoris_pro_img">
                        <a href="{{url('Shop/fiche_produit')}}" title="Détail du produit">
                            <img src="{{ Vite::asset('resources/images/background.jpeg') }}" alt="Image du produit">
                        </a>
                    </div>
                    <div class="favoris_pro_info">
                        <h2>PC Gamer</h2>
                        <p>999,99 F CFA</p>
                    </div>
                </div>
                <div class="act_favoris">
                    <a href="#" class="fav_btn_sup">Supprimer</a>
                    <a href="#" class="fav_btn_ajou">Ajouter</a>
                </div>
            </div>

            <div class="pro_favoris">
                <div class="cont_favoris">
                    <div class="favoris_pro_img">
                        <a href="{{url('Shop/fiche_produit')}}" title="Détail du produit">
                            <img src="{{ Vite::asset('resources/images/background.jpeg') }}" alt="Image du produit">
                        </a>
                    </div>
                    <div class="favoris_pro_info">
                        <h2>PC Gamer</h2>
                        <p>999,99 F CFA</p>
                    </div>
                </div>
                <div class="act_favoris">
                    <a href="#" class="fav_btn_sup">Supprimer</a>
                    <a href="#" class="fav_btn_ajou">Ajouter</a>
                </div>
            </div>

            <div class="pro_favoris">
                <div class="cont_favoris">
                    <div class="favoris_pro_img">
                        <a href="{{url('Shop/fiche_produit')}}" title="Détail du produit">
                            <img src="{{ Vite::asset('resources/images/background.jpeg') }}" alt="Image du produit">
                        </a>
                    </div>
                    <div class="favoris_pro_info">
                        <h2>PC Gamer</h2>
                        <p>999,99 F CFA</p>
                    </div>
                </div>
                <div class="act_favoris">
                    <a href="#" class="fav_btn_sup">Supprimer</a>
                    <a href="#" class="fav_btn_ajou">Ajouter</a>
                </div>
            </div>
        </div>
    </main>
@endsection 