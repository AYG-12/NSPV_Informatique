<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Shop\ShopController;
use App\Http\Controllers\Shop\CartController;
use App\Http\Controllers\Shop\CheckoutController;
use App\Http\Controllers\Shop\OrderHistoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\AnalytiqueController;
use App\Http\Controllers\Admin\ParametresController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\VisitController as AdminVisitController;
use App\Http\Controllers\Admin\NotificationController as AdminNotifController;
use App\Http\Controllers\Shop\ProfileController;
use App\Http\Controllers\Shop\WishlistController;
use App\Http\Controllers\Shop\ReviewController;

/* ══════════════════════════════════════════════════════
   PAGES PUBLIQUES
══════════════════════════════════════════════════════ */

Route::get('/', fn() => view('welcome'));
Route::get('/contact', fn() => view('pages.contact'));
Route::get('/Apropos', fn() => view('pages.apropos'));

/* ══════════════════════════════════════════════════════
   AUTHENTIFICATION
══════════════════════════════════════════════════════ */

Route::middleware('guest')->group(function () {
    Route::get('/connexion', [AuthController::class, 'showConnexion'])->name('connexion');
    Route::post('/connexion', [AuthController::class, 'login'])->name('login');
    Route::post('/inscription', [AuthController::class, 'register'])->name('register');
});

// Google OAuth (pas de middleware guest : le callback peut arriver après redirection)
Route::get('/auth/google',          [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

Route::post('/deconnexion', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/* ══════════════════════════════════════════════════════
   SHOP (accessible à tous, panier nécessite auth)
══════════════════════════════════════════════════════ */

Route::prefix('Shop')->group(function () {
    Route::get('/', [ShopController::class, 'home'])->name('shop.home');
    Route::get('/produits', [ShopController::class, 'produits'])->name('shop.produits');
    Route::get('/produit/{slug}', [ShopController::class, 'fiche'])->name('shop.fiche');
    Route::get('/produit/{slug}/avis', [ShopController::class, 'avisPage'])->name('shop.produit.avis');
    Route::get('/sc', fn() => view('Shop.page.service-client'))->name('shop.sc');
    Route::get('/favoris', [WishlistController::class, 'index'])->name('shop.favoris')->middleware('auth');
    Route::post('/favoris/{product}/toggle', [WishlistController::class, 'toggle'])->name('shop.wishlist.toggle')->middleware('auth');

    // Panier : réservé aux clients connectés
    Route::middleware('auth')->group(function () {
        Route::get('/cart',              [CartController::class, 'index'])->name('shop.cart');
        Route::post('/cart/ajouter',     [CartController::class, 'add'])->name('shop.cart.add');
        Route::patch('/cart/items/{item}', [CartController::class, 'update'])->name('shop.cart.update');
        Route::delete('/cart/items/{item}', [CartController::class, 'remove'])->name('shop.cart.remove');
        Route::post('/cart/promo',       [CartController::class, 'applyPromo'])->name('shop.cart.promo');
        Route::delete('/cart/promo',     [CartController::class, 'removePromo'])->name('shop.cart.promo.remove');
        Route::delete('/cart',           [CartController::class, 'clear'])->name('shop.cart.clear');

        // Checkout
        Route::get('/checkout',              [CheckoutController::class, 'index'])->name('shop.checkout');
        Route::post('/checkout',             [CheckoutController::class, 'store'])->name('shop.checkout.store');
        Route::post('/checkout/adresse',     [CheckoutController::class, 'storeAddress'])->name('shop.checkout.address');

        // Historique commandes client
        Route::get('/mes-commandes',                    [OrderHistoryController::class, 'index'])->name('shop.commandes');
        Route::get('/mes-commandes/{order}',            [OrderHistoryController::class, 'show'])->name('shop.commandes.show');
        Route::patch('/mes-commandes/{order}/annuler',  [OrderHistoryController::class, 'cancel'])->name('shop.commandes.cancel');

        // Avis produits
        Route::post('/mes-commandes/{order}/avis/{item}', [ReviewController::class, 'store'])->name('shop.review.store');

        // Profil client
        Route::get('/profil',                    [ProfileController::class, 'show'])->name('shop.profil');
        Route::put('/profil',                    [ProfileController::class, 'update'])->name('shop.profil.update');
        Route::put('/profil/mot-de-passe',       [ProfileController::class, 'updatePassword'])->name('shop.profil.password');
        Route::post('/profil/adresses',          [ProfileController::class, 'storeAddress'])->name('shop.profil.address.store');
        Route::delete('/profil/adresses/{address}', [ProfileController::class, 'destroyAddress'])->name('shop.profil.address.destroy');
    });
});

/* ══════════════════════════════════════════════════════
   ADMIN (réservé aux administrateurs)
══════════════════════════════════════════════════════ */

Route::prefix('welAdminnspv')->middleware('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    // Clients
    Route::get('/clients',              [ClientController::class, 'index'])->name('admin.clients');
    Route::post('/clients',             [ClientController::class, 'store'])->name('admin.clients.store');
    Route::put('/clients/{user}',       [ClientController::class, 'update'])->name('admin.clients.update');
    Route::delete('/clients/{user}',    [ClientController::class, 'destroy'])->name('admin.clients.destroy');

    // Promotions CRUD
    Route::get('/promotions',                     [PromotionController::class, 'index'])->name('admin.promotions');
    Route::post('/promotions',                    [PromotionController::class, 'store'])->name('admin.promotions.store');
    Route::put('/promotions/{promotion}',         [PromotionController::class, 'update'])->name('admin.promotions.update');
    Route::patch('/promotions/{promotion}/toggle',[PromotionController::class, 'toggle'])->name('admin.promotions.toggle');
    Route::delete('/promotions/{promotion}',      [PromotionController::class, 'destroy'])->name('admin.promotions.destroy');

    // Analytique
    Route::get('/analytique', [AnalytiqueController::class, 'index'])->name('admin.analytique');

    // Paramètres
    Route::get('/parametres',                      [ParametresController::class, 'index'])->name('admin.parametres');
    Route::put('/parametres/general',              [ParametresController::class, 'updateGeneral'])->name('admin.parametres.general');
    Route::put('/parametres/boutique',             [ParametresController::class, 'updateBoutique'])->name('admin.parametres.boutique');
    Route::put('/parametres/livraison',            [ParametresController::class, 'updateLivraison'])->name('admin.parametres.livraison');
    Route::put('/parametres/paiement',             [ParametresController::class, 'updatePaiement'])->name('admin.parametres.paiement');
    Route::put('/parametres/notifications',        [ParametresController::class, 'updateNotifications'])->name('admin.parametres.notifications');
    Route::put('/parametres/mot-de-passe',         [ParametresController::class, 'updatePassword'])->name('admin.parametres.password');

    // Produits CRUD
    Route::get('/produits',                  [ProductController::class, 'index'])->name('admin.produits');
    Route::post('/produits',                 [ProductController::class, 'store'])->name('admin.produits.store');
    Route::put('/produits/{product}',        [ProductController::class, 'update'])->name('admin.produits.update');
    Route::delete('/produits/{product}',     [ProductController::class, 'destroy'])->name('admin.produits.destroy');

    // Catégories CRUD
    Route::get('/categories',                [CategoryController::class, 'index'])->name('admin.categories');
    Route::post('/categories',               [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::put('/categories/{category}',     [CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/categories/{category}',  [CategoryController::class, 'destroy'])->name('admin.categories.destroy');

    // Commandes
    Route::get('/commandes',                        [OrderController::class, 'index'])->name('admin.commandes');
    Route::post('/commandes',                       [OrderController::class, 'store'])->name('admin.commandes.store');
    Route::patch('/commandes/{order}/statut',       [OrderController::class, 'updateStatus'])->name('admin.commandes.statut');

    // Visites
    Route::get('/visites', [AdminVisitController::class, 'index'])->name('admin.visites');

    // Notifications
    Route::get('/notifications',              [AdminNotifController::class, 'index'])->name('admin.notifications');
    Route::patch('/notifications/read-all',   [AdminNotifController::class, 'markAllRead'])->name('admin.notifications.read-all');
    Route::patch('/notifications/{id}/read',  [AdminNotifController::class, 'markRead'])->name('admin.notifications.read');

    // Avis clients
    Route::get('/avis',                             [AdminReviewController::class, 'index'])->name('admin.avis');
    Route::patch('/avis/{review}/approuver',         [AdminReviewController::class, 'approve'])->name('admin.avis.approve');
    Route::patch('/avis/{review}/desapprouver',      [AdminReviewController::class, 'disapprove'])->name('admin.avis.disapprove');
    Route::delete('/avis/{review}',                 [AdminReviewController::class, 'destroy'])->name('admin.avis.destroy');
});
 