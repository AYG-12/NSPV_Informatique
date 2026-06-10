<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private function getOrCreateCart(): Cart
    {
        return Cart::firstOrCreate(['user_id' => auth()->id()]);
    }

    public function index()
    {
        $cart = $this->getOrCreateCart();
        $cart->load(['items.product', 'promotion']);

        return view('Shop.page.cart', compact('cart'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity'   => ['integer', 'min:1', 'max:99'],
        ]);

        $product = Product::findOrFail($request->product_id);

        if (! $product->is_active) {
            $msg = 'Ce produit n\'est pas disponible.';
            return $request->wantsJson()
                ? response()->json(['error' => $msg], 422)
                : back()->with('error', $msg);
        }

        $cart = $this->getOrCreateCart();
        $qty  = $request->integer('quantity', 1);

        $item = $cart->items()->where('product_id', $product->id)->first();

        if ($item) {
            $newQty = $item->quantity + $qty;
            if ($product->stock !== null) {
                $newQty = min($newQty, $product->stock);
            }
            $item->update(['quantity' => $newQty]);
        } else {
            if ($product->stock !== null) {
                $qty = min($qty, $product->stock);
            }
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity'   => $qty,
                'unit_price' => $product->current_price,
            ]);
        }

        if ($request->wantsJson()) {
            return response()->json(['cart_count' => auth()->user()->cartCount()]);
        }

        return back()->with('success', '"' . $product->name . '" ajouté au panier.');
    }

    public function update(Request $request, CartItem $item)
    {
        abort_if($item->cart->user_id !== auth()->id(), 403);

        $request->validate(['quantity' => ['required', 'integer', 'min:1', 'max:99']]);

        $product = $item->product;
        $qty     = $request->integer('quantity');

        if ($product->stock !== null) {
            $qty = min($qty, $product->stock);
        }

        $item->update(['quantity' => $qty]);

        if ($request->wantsJson()) {
            $cart = Cart::where('user_id', auth()->id())->with(['items', 'promotion'])->first();
            return response()->json([
                'line_total'  => round($item->fresh()->line_total, 2),
                'subtotal'    => round($cart->subtotal, 2),
                'discount'    => round($cart->discount_amount, 2),
                'total'       => round($cart->total, 2),
                'cart_count'  => auth()->user()->cartCount(),
            ]);
        }

        return redirect()->route('shop.cart');
    }

    public function remove(CartItem $item)
    {
        abort_if($item->cart->user_id !== auth()->id(), 403);

        $item->delete();

        if (request()->wantsJson()) {
            $cart = Cart::where('user_id', auth()->id())->with(['items', 'promotion'])->first();
            return response()->json([
                'subtotal'   => round($cart ? $cart->subtotal : 0, 2),
                'discount'   => round($cart ? $cart->discount_amount : 0, 2),
                'total'      => round($cart ? $cart->total : 0, 2),
                'cart_count' => auth()->user()->cartCount(),
                'empty'      => $cart ? $cart->items->isEmpty() : true,
            ]);
        }

        return redirect()->route('shop.cart');
    }

    public function applyPromo(Request $request)
    {
        $request->validate(['code' => ['required', 'string']]);

        $cart = $this->getOrCreateCart();
        $cart->load('items');

        $promo = Promotion::where('code', strtoupper($request->code))->first();

        if (! $promo || ! $promo->isValid($cart->subtotal)) {
            $msg = 'Code promo invalide ou expiré.';
            return $request->wantsJson()
                ? response()->json(['error' => $msg], 422)
                : back()->with('error', $msg);
        }

        $cart->update(['promotion_id' => $promo->id]);
        $cart->load(['items', 'promotion']);

        if ($request->wantsJson()) {
            return response()->json([
                'discount' => round($cart->discount_amount, 2),
                'total'    => round($cart->total, 2),
                'message'  => 'Code "' . $promo->code . '" appliqué ! −' . number_format($cart->discount_amount, 0, ',', ' ') . ' FCFA',
            ]);
        }

        return back()->with('success', 'Code promo appliqué.');
    }

    public function removePromo()
    {
        $cart = Cart::where('user_id', auth()->id())->first();
        if ($cart) {
            $cart->update(['promotion_id' => null]);
        }

        if (request()->wantsJson()) {
            $cart->load('items');
            return response()->json([
                'subtotal' => round($cart->subtotal, 2),
                'discount' => 0,
                'total'    => round($cart->subtotal, 2),
            ]);
        }

        return redirect()->route('shop.cart');
    }

    public function clear()
    {
        $cart = Cart::where('user_id', auth()->id())->first();
        if ($cart) {
            $cart->items()->delete();
            $cart->update(['promotion_id' => null]);
        }

        return redirect()->route('shop.cart');
    }
}
