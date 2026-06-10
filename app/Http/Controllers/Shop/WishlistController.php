<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    public function index()
    {
        $items = Wishlist::where('user_id', auth()->id())
            ->with(['product' => fn($q) => $q->with('category')])
            ->latest('created_at')
            ->get();

        return view('Shop.page.favoris', compact('items'));
    }

    public function toggle(Product $product)
    {
        $userId  = auth()->id();
        $row     = Wishlist::where('user_id', $userId)->where('product_id', $product->id)->first();

        if ($row) {
            $row->delete();
            $inWishlist = false;
        } else {
            Wishlist::create(['user_id' => $userId, 'product_id' => $product->id, 'created_at' => now()]);
            $inWishlist = true;
        }

        $count = Wishlist::where('user_id', $userId)->count();

        if (request()->expectsJson()) {
            return response()->json(['in_wishlist' => $inWishlist, 'count' => $count]);
        }

        return back()->with('success', $inWishlist ? 'Ajouté aux favoris.' : 'Retiré des favoris.');
    }
}
