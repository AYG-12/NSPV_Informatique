@php $title = 'Produits'; @endphp

@extends('layouts.guest')

<!-- Appel de la barre de navigation -->
@include('Shop.partials._navbar')

@section('content')
    <main class="content-product">

        <!-- <div class="ticker">
            <span class="ticker-inner">
                LIVRAISON GRATUITE DÈS 80€ &nbsp;///&nbsp; NOUVELLE COLLECTION DISPONIBLE &nbsp;///&nbsp; -20% SUR LES ACCESSOIRES AVEC CODE GRID20 &nbsp;///&nbsp; RETOURS GRATUITS SOUS 30 JOURS &nbsp;///&nbsp; LIVRAISON GRATUITE DÈS 80€ &nbsp;///&nbsp; NOUVELLE COLLECTION DISPONIBLE &nbsp;///&nbsp; -20% SUR LES ACCESSOIRES AVEC CODE GRID20 &nbsp;///&nbsp; RETOURS GRATUITS SOUS 30 JOURS &nbsp;///&nbsp;
            </span>
        </div> -->

        <div class="pag">
            <aside>
                <!-- Categories -->
                <div class="filter-block">
                    <div class="sidebar-label">Catégorie</div>

                    <div class="cat-list" id="cat-list">
                        <button class="cat-btn active" data-cat="all">
                            Tout <span class="cat-count" id="count-all">0</span>
                        </button>

                        <button class="cat-btn" data-cat="Tech">
                            Tech <span class="cat-count" id="count-tech">0</span>
                        </button>

                        <button class="cat-btn" data-cat="Mode">
                            Mode <span class="cat-count" id="count-mode">0</span>
                        </button>

                        <button class="cat-btn" data-cat="Sport">
                            Sport <span class="cat-count" id="count-sport">0</span>
                        </button>
                        
                        <button class="cat-btn" data-cat="Lifestyle">
                            Lifestyle <span class="cat-count" id="count-lifestyle">0</span>
                        </button>
                    </div>
                    </div>

                    <!-- Price -->
                    <div class="filter-block">

                    <div class="sidebar-label">Prix</div>

                    <div class="price-range-display" id="price-display">0 F CFA — 999 F CFA</div>

                    <div class="range-inputs">
                        <div class="range-input-wrap">
                            <label>MIN</label>
                            <input type="number" id="pmin" placeholder="0" min="0">
                        </div>

                        <div class="range-input-wrap">
                            <label>MAX</label>
                            <input type="number" id="pmax" placeholder="999" min="0">
                        </div>
                    </div>
                </div>

                <!-- Brands -->
                <div class="filter-block">
                    <div class="sidebar-label">Marque</div>
                    <div class="brand-grid" id="brand-grid">
                        
                    </div>
                </div>

                <button class="reset" onclick="resetAll()">// RESET FILTRES</button>
            </aside>

            <div class="products-section">
                <div class="section-header">
                    <div class="section-title">
                        TOUS LES<br><span>PRODUITS</span>
                    </div>

                    <div class="meta-info">
                        <div class="count-big" id="count-display">24</div>
                        <div class="count-label">RÉSULTATS</div>
                    </div>
                </div>

                <div class="toolbar">
                    <span class="toolbar-label">TRIER :</span>

                    <button class="sort-btn active" data-sort="default">DÉFAUT</button>

                    <button class="sort-btn" data-sort="price-asc">PRIX ↑</button>

                    <button class="sort-btn" data-sort="price-desc">PRIX ↓</button>

                    <button class="sort-btn" data-sort="name">A–Z</button>
                </div>

                <div class="grid" id="grid">
                    <div class="prod">
                        <div class="img_prod">
                            <a href=" {{url('Shop/fiche_produit')}} " title="Détail du produit">
                                <img src="{{Vite::asset('resources/images/panier.jpg')}}" alt="alter_img">
                            </a>
                        </div>
                        
                        <div class="prod_info">
                            <h3>titre_du_produit</h3>
                            <p>caractéristiques ############# ########### #########</p>
                            <div class="star_price">
                                <div class="prix_prod"><h4>350 000 FCFA</h4></div>
                                <!-- <div class="star">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-star-half" viewBox="0 0 16 16">
                                        <path d="M5.354 5.119 7.538.792A.52.52 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.54.54 0 0 1 16 6.32a.55.55 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.5.5 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403.6.6 0 0 1 .085-.302.51.51 0 0 1 .37-.245zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894-.694-3.957a.56.56 0 0 1 .162-.505l2.907-2.77-4.052-.576a.53.53 0 0 1-.393-.288L8.001 2.223 8 2.226z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                        <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z"/>
                                    </svg>
                                </div> -->
                            </div>
                            <a href="#" class="btn">Ajouter au Panier</a>

                            <a href="{{url('/Shop/favoris')}}" class="btn_favoris" title="Ajoutez aux Favoris">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
        
                    <div class="prod">
                        <div class="img_prod">
                            <a href="{{url('Shop/fiche_produit')}}" title="Détail du produit">
                                <img src="{{Vite::asset('resources/images/background.jpeg')}}" alt="alter_img">
                            </a>
                        </div>
                        
                        <div class="prod_info">
                            <h3>titre_du_produit</h3>
                            <p>caractéristiques ############# ########### #########</p>
                            <div class="star_price">
                                <div class="prix_prod"><h4>350 000 FCFA</h4></div>
                                <!-- <div class="star">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-star-half" viewBox="0 0 16 16">
                                        <path d="M5.354 5.119 7.538.792A.52.52 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.54.54 0 0 1 16 6.32a.55.55 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.5.5 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403.6.6 0 0 1 .085-.302.51.51 0 0 1 .37-.245zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894-.694-3.957a.56.56 0 0 1 .162-.505l2.907-2.77-4.052-.576a.53.53 0 0 1-.393-.288L8.001 2.223 8 2.226z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                        <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z"/>
                                    </svg>
                                </div> -->
                            </div>
                            <a href="#" class="btn">Ajouter au Panier</a>

                            <a href="{{url('/Shop/favoris')}}" class="btn_favoris" title="Ajoutez aux Favoris">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
        
                    <div class="prod">
                        <div class="img_prod">
                            <a href="{{url('Shop/fiche_produit')}}">
                                <img src="{{Vite::asset('resources/images/ppppp.webp')}}" alt="alter_img">
                            </a>
                        </div>
                        
                        <div class="prod_info">
                            <h3>titre_du_produit</h3>
                            <p>caractéristiques ############# ########### #########</p>
                            <div class="star_price">
                                <div class="prix_prod"><h4>350 000 FCFA</h4></div>
                                <!-- <div class="star">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-star-half" viewBox="0 0 16 16">
                                        <path d="M5.354 5.119 7.538.792A.52.52 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.54.54 0 0 1 16 6.32a.55.55 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.5.5 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403.6.6 0 0 1 .085-.302.51.51 0 0 1 .37-.245zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894-.694-3.957a.56.56 0 0 1 .162-.505l2.907-2.77-4.052-.576a.53.53 0 0 1-.393-.288L8.001 2.223 8 2.226z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                        <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z"/>
                                    </svg>
                                </div> -->
                            </div>
                            <a href="#" class="btn">Ajouter au Panier</a>

                            <a href="{{url('/Shop/favoris')}}" class="btn_favoris" title="Ajoutez aux Favoris">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
    
                    <div class="prod">
                        <div class="img_prod">
                            <a href="{{url('Shop/fiche_produit')}}" title="Détails">
                                <img src="{{Vite::asset('resources/images/slide.jpeg')}}" alt="alter_img">
                            </a>
                        </div>
                        
                        <div class="prod_info">
                            <h3>titre_du_produit</h3>
                            <p>caractéristiques ############# ########### #########</p>
                            <div class="star_price">
                                <div class="prix_prod"><h4>350 000 FCFA</h4></div>
                                <!-- <div class="star">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-star-half" viewBox="0 0 16 16">
                                        <path d="M5.354 5.119 7.538.792A.52.52 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.54.54 0 0 1 16 6.32a.55.55 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.5.5 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403.6.6 0 0 1 .085-.302.51.51 0 0 1 .37-.245zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894-.694-3.957a.56.56 0 0 1 .162-.505l2.907-2.77-4.052-.576a.53.53 0 0 1-.393-.288L8.001 2.223 8 2.226z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                        <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z"/>
                                    </svg>
                                </div> -->
                            </div>
                            
                            <a href="#" class="btn">Ajouter au Panier</a>

                            <a href="{{url('/Shop/favoris')}}" class="btn_favoris" title="Ajoutez aux Favoris">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div class="prod">
                        <div class="img_prod">
                            <a href="{{url('Shop/fiche_produit')}}">
                                <img src="{{Vite::asset('resources/images/panier.jpg')}}" alt="alter_img">
                            </a>
                        </div>
                        
                        <div class="prod_info">
                            <h3>titre_du_produit</h3>
                            <p>caractéristiques ############# ########### #########</p>
                            <div class="star_price">
                                <div class="prix_prod"><h4>350 000 FCFA</h4></div>
                                <!-- <div class="star">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-star-half" viewBox="0 0 16 16">
                                        <path d="M5.354 5.119 7.538.792A.52.52 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.54.54 0 0 1 16 6.32a.55.55 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.5.5 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403.6.6 0 0 1 .085-.302.51.51 0 0 1 .37-.245zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894-.694-3.957a.56.56 0 0 1 .162-.505l2.907-2.77-4.052-.576a.53.53 0 0 1-.393-.288L8.001 2.223 8 2.226z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                        <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z"/>
                                    </svg>
                                </div> -->
                            </div>
                            <a href="#" class="btn">Ajouter au Panier</a>

                            <a href="{{url('/Shop/favoris')}}" class="btn_favoris" title="Ajoutez aux Favoris">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
        
                    <div class="prod">
                        <div class="img_prod">
                            <a href="{{url('Shop/fiche_produit')}}">
                                <img src="{{Vite::asset('resources/images/background.jpeg')}}" alt="alter_img">
                            </a>
                        </div>
                        
                        <div class="prod_info">
                            <h3>titre_du_produit</h3>
                            <p>caractéristiques ############# ########### #########</p>
                            <div class="star_price">
                                <div class="prix_prod"><h4>350 000 FCFA</h4></div>
                                <!-- <div class="star">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-star-half" viewBox="0 0 16 16">
                                        <path d="M5.354 5.119 7.538.792A.52.52 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.54.54 0 0 1 16 6.32a.55.55 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.5.5 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403.6.6 0 0 1 .085-.302.51.51 0 0 1 .37-.245zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894-.694-3.957a.56.56 0 0 1 .162-.505l2.907-2.77-4.052-.576a.53.53 0 0 1-.393-.288L8.001 2.223 8 2.226z"/>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                        <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z"/>
                                    </svg>
                                </div> -->
                            </div>
                            <a href="#" class="btn">Ajouter au Panier</a>

                            <a href="#?action=fav5" class="btn_favoris" title="Ajoutez aux Favoris">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="status-bar">
            <div class="status-item">
                <div class="dot-live"></div> EN LIGNE
            </div>

            <div class="status-item">STOCK TEMPS RÉEL</div>

            <div class="status-item">MISE À JOUR : AUJOURD'HUI</div>
        </div>
    </main>
@endsection
        <script>
            const products = [
                { id:1, name:"AirPod Ultra X", brand:"SoundCore", category:"Tech", price:199, badge:"NEW", emoji:"🎧" },
                { id:2, name:"SmartWatch S7", brand:"TechGear", category:"Tech", price:349, badge:"", emoji:"⌚" },
                { id:3, name:"Veste Alpha", brand:"Urban Bloc", category:"Mode", price:185, badge:"", emoji:"🧥" },
                { id:4, name:"Running Pro+", brand:"SpeedFit", category:"Sport", price:129, badge:"SALE", emoji:"👟" },
                { id:5, name:"Cam 4K Mini", brand:"TechGear", category:"Tech", price:289, badge:"", emoji:"📷" },
                { id:6, name:"Hoodie Oversize", brand:"Urban Bloc", category:"Mode", price:95, badge:"NEW", emoji:"👕" },
                { id:7, name:"Yoga Mat Pro", brand:"SpeedFit", category:"Sport", price:68, badge:"", emoji:"🧘" },
                { id:8, name:"Lampe LED Arc", brand:"HomeLux", category:"Lifestyle", price:149, badge:"", emoji:"💡" },
                { id:9, name:"Clavier Meca K2", brand:"SoundCore", category:"Tech", price:219, badge:"", emoji:"⌨️" },
                { id:10, name:"Pantalon Cargo", brand:"Urban Bloc", category:"Mode", price:110, badge:"", emoji:"👖" },
                { id:11, name:"Vélo Électrique", brand:"SpeedFit", category:"Sport", price:899, badge:"EXCLU", emoji:"🚴" },
                { id:12, name:"Carafe Design", brand:"HomeLux", category:"Lifestyle", price:59, badge:"", emoji:"🫗" },
                { id:13, name:"Tablette X12", brand:"TechGear", category:"Tech", price:479, badge:"", emoji:"📱" },
                { id:14, name:"Casquette Grid", brand:"Urban Bloc", category:"Mode", price:42, badge:"SALE", emoji:"🧢" },
                { id:15, name:"Gants Training", brand:"SpeedFit", category:"Sport", price:35, badge:"", emoji:"🥊" },
                { id:16, name:"Diffuseur Smart", brand:"HomeLux", category:"Lifestyle", price:89, badge:"NEW", emoji:"🌿" },
                { id:17, name:"Speaker BT GO", brand:"SoundCore", category:"Tech", price:79, badge:"", emoji:"🔊" },
                { id:18, name:"Sneakers Grid", brand:"Urban Bloc", category:"Mode", price:165, badge:"EXCLU", emoji:"👟" },
                { id:19, name:"Tapis Course", brand:"SpeedFit", category:"Sport", price:599, badge:"", emoji:"🏃" },
                { id:20, name:"Robot Aspirateur", brand:"HomeLux", category:"Lifestyle", price:329, badge:"", emoji:"🤖" },
                { id:21, name:"Drone Pro V2", brand:"TechGear", category:"Tech", price:699, badge:"NEW", emoji:"🚁" },
                { id:22, name:"Manteau Laine", brand:"Urban Bloc", category:"Mode", price:255, badge:"", emoji:"🧤" },
                { id:23, name:"Kettlebell Set", brand:"SpeedFit", category:"Sport", price:145, badge:"", emoji:"🏋️" },
                { id:24, name:"Cadre Photo IA", brand:"HomeLux", category:"Lifestyle", price:199, badge:"", emoji:"🖼️" },
            ];

            const brands = [...new Set(products.map(p => p.brand))].sort();
            let selCat = 'all';
            let selBrands = new Set(brands);
            let pMin = 0, pMax = Infinity;
            let sortMode = 'default';

            // Update category counts
            function updateCounts(data) {
            document.getElementById('count-all').textContent = data.length;
            ['Tech','Mode','Sport','Lifestyle'].forEach(cat => {
                const el = document.getElementById('count-' + cat.toLowerCase());
                if(el) el.textContent = data.filter(p => p.category === cat).length;
            });
            }

            // Build brands
            const brandGrid = document.getElementById('brand-grid');
            brands.forEach(b => {
                const div = document.createElement('label');
                div.className = 'brand-toggle checked';
                div.innerHTML = `
                    <input type="checkbox" value="${b}" checked>
                    <div class="b-indicator checked"></div>
                    <span class="b-name">${b}</span>
                    <div class="b-dot"></div>`;
                    
                div.querySelector('input').addEventListener('change', (e) => {
                    if(e.target.checked) selBrands.add(b);
                    else selBrands.delete(b);
                    div.classList.toggle('checked', e.target.checked);
                    div.querySelector('.b-indicator').classList.toggle('checked', e.target.checked);
                    render();
                });
                brandGrid.appendChild(div);
            });

            // Category buttons
            document.querySelectorAll('.cat-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.cat-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                selCat = btn.dataset.cat;
                render();
            });
            });

            // Price
            document.getElementById('pmin').addEventListener('input', e => { pMin = parseFloat(e.target.value)||0; updatePriceDisplay(); render(); });
            document.getElementById('pmax').addEventListener('input', e => { pMax = parseFloat(e.target.value)||Infinity; updatePriceDisplay(); render(); });

            function updatePriceDisplay() {
            document.getElementById('price-display').textContent = `€${pMin} — €${pMax === Infinity ? '∞' : pMax}`;
            }

            // Sort
            document.querySelectorAll('.sort-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.sort-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                sortMode = btn.dataset.sort;
                render();
            });
            });

            function getFiltered() {
            return products.filter(p => {
                if(selCat !== 'all' && p.category !== selCat) return false;
                if(!selBrands.has(p.brand)) return false;
                if(p.price < pMin) return false;
                if(pMax !== Infinity && p.price > pMax) return false;
                return true;
            });
            }

            function getSorted(arr) {
            const a = [...arr];
            if(sortMode === 'price-asc') return a.sort((x,y) => x.price - y.price);
            if(sortMode === 'price-desc') return a.sort((x,y) => y.price - x.price);
            if(sortMode === 'name') return a.sort((x,y) => x.name.localeCompare(y.name));
            return a;
            }

            function render() {
            const filtered = getFiltered();
            const sorted = getSorted(filtered);
            updateCounts(filtered);
            document.getElementById('count-display').textContent = sorted.length;

            const grid = document.getElementById('grid');

            if(sorted.length === 0) {
                grid.innerHTML = `<div class="empty">
                <div class="empty-code">ERROR_404</div>
                <div class="empty-msg">AUCUN RÉSULTAT</div>
                <div class="empty-sub">Modifiez vos filtres pour afficher des produits.</div>
                </div>`;
                return;
            }

            grid.innerHTML = sorted.map((p, i) => `
                <div class="product-card" style="animation-delay:${i*0.04}s">
                <div class="card-img">
                    ${p.badge ? `<div class="badge-corner ${p.badge==='SALE'?'sale':''}">${p.badge}</div>` : ''}
                    ${p.emoji}
                    <button class="overlay-btn">+ AJOUTER AU PANIER</button>
                </div>
                <div class="card-body">
                    <div class="card-brand">${p.brand}</div>
                    <div class="card-name">${p.name}</div>
                    <div class="card-cat">${p.category}</div>
                    <div class="card-footer">
                    <div class="card-price"><span class="currency">€</span>${p.price}</div>
                    <button class="wishlist-btn">♡</button>
                    </div>
                </div>
                </div>`).join('');
            }

            resetAll();
            function resetAll() {
            selCat = 'all';
            selBrands = new Set(brands);
            pMin = 0; pMax = Infinity;
            sortMode = 'default';
            document.querySelectorAll('.cat-btn').forEach((b,i) => b.classList.toggle('active', i===0));
            document.querySelectorAll('.sort-btn').forEach((b,i) => b.classList.toggle('active', i===0));
            document.querySelectorAll('.brand-toggle input').forEach(i => { i.checked = true; });
            document.querySelectorAll('.brand-toggle').forEach(d => { d.classList.add('checked'); d.querySelector('.b-indicator').classList.add('checked'); });
            document.getElementById('pmin').value = '';
            document.getElementById('pmax').value = '';
            document.getElementById('price-display').textContent = '€0 — €∞';
            render();
            }
        </script>
