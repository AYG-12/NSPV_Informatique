<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->q . '%')
                  ->orWhere('sku', 'like', '%' . $request->q . '%');
            });
        }

        if ($request->filled('categorie')) {
            $query->where('category_id', $request->categorie);
        }

        if ($request->filled('stock')) {
            match ($request->stock) {
                'en_stock'    => $query->where('stock', '>', 5)->orWhereNull('stock'),
                'stock_faible'=> $query->whereBetween('stock', [1, 5]),
                'rupture'     => $query->where('stock', 0),
                default       => null,
            };
        }

        $products   = $query->latest()->paginate(8)->withQueryString();
        $categories = Category::where('is_active', true)->get();
        $totalOutOfStock = Product::where('stock', 0)->count();

        return view('admin.pages.produits', compact('products', 'categories', 'totalOutOfStock'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'category_id'       => ['required', 'exists:categories,id'],
            'type'              => ['required', 'in:product,service'],
            'price'             => ['required', 'numeric', 'min:0'],
            'sale_price'        => ['nullable', 'numeric', 'min:0'],
            'stock'             => ['nullable', 'integer', 'min:0'],
            'sku'               => ['nullable', 'string', 'unique:products,sku'],
            'short_description' => ['nullable', 'string', 'max:255'],
            'description'       => ['nullable', 'string'],
            'is_featured'       => ['boolean'],
            'is_active'         => ['boolean'],
            'image'             => ['nullable', 'image', 'max:2048'],
        ]);

        $base = Str::slug($data['name']);
        $slug = $base;
        $i    = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }
        $data['slug']        = $slug;
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active']   = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.produits')
            ->with('success', 'Produit "' . $data['name'] . '" créé avec succès.');
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'category_id'       => ['required', 'exists:categories,id'],
            'type'              => ['required', 'in:product,service'],
            'price'             => ['required', 'numeric', 'min:0'],
            'sale_price'        => ['nullable', 'numeric', 'min:0'],
            'stock'             => ['nullable', 'integer', 'min:0'],
            'sku'               => ['nullable', 'string', 'unique:products,sku,' . $product->id],
            'short_description' => ['nullable', 'string', 'max:255'],
            'description'       => ['nullable', 'string'],
            'is_featured'       => ['boolean'],
            'is_active'         => ['boolean'],
            'image'             => ['nullable', 'image', 'max:2048'],
        ]);

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active']   = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.produits')
            ->with('success', 'Produit mis à jour avec succès.');
    }

    public function destroy(Product $product)
    {
        $name = $product->name;
        $product->delete();

        return redirect()->route('admin.produits')
            ->with('success', 'Produit "' . $name . '" supprimé.');
    }
}
