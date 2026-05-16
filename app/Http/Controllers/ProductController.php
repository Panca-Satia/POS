<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $products = Product::with('category')
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'like', "%{$search}%");
            })->orderBy('created_at', 'desc')->paginate(10);

        return view('products.index', compact('products', 'search'));
    }

    public function create()
    {
        $categories = Category::orderBy('nama')->get();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
        ], [
            'nama.required' => 'Nama produk wajib diisi.',
            'harga.required' => 'Harga wajib diisi.',
            'category_id.exists' => 'Kategori tidak valid.',
        ]);

        Product::create($request->only('nama', 'harga', 'stok', 'category_id'));

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('nama')->get();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
        ], [
            'nama.required' => 'Nama produk wajib diisi.',
            'category_id.exists' => 'Kategori tidak valid.',
        ]);

        $product->update($request->only('nama', 'harga', 'stok', 'category_id'));

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }
}
