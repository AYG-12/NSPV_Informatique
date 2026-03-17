<?php

use Illuminate\Support\Facades\Route;


/* =========================================== ADMIN PANEL ========================================== */
Route::get('/wel', function () {
    return view('admin.dashboard');
});


/* =========================================== HOME APPLICATION ========================================== */

Route::get('/', function(){
    return view('welcome'); 
});

Route::get('/connexion', function(){
    return view('pages.connexion');
});

Route::get('/contact', function(){
    return view('pages.contact');
});

Route::get('/Apropos', function(){
    return view('pages.apropos');
});

//* =================================== SHOP ================================= */

Route::get('/Shop', function () {
    return view('Shop.home_product');
});

Route::get('/Shop/sc', function () {
    return view('Shop.page.service-client');
});

Route::get('/Shop/produits', function(){
    return view('Shop.page.produit');
});

Route::get('/Shop/fiche_produit', function () {
    return view('Shop.page.fiche_produit');
});

Route::get('/Shop/panier', function () {
    return view('Shop.page.panier');
});

Route::get('/Shop/favoris', function () {
    return view('Shop.page.favoris');
});

Route::get('/Shop/cart', function () {
    return view('Shop.page.cart');
});
