<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $products = Product::where('stok', '>', 0)->orderBy('nama')->get();
        $cart = session()->get('cart', []);
        $cartTotal = collect($cart)->sum('subtotal');
        return view('transactions.index', compact('products', 'cart', 'cartTotal'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($request->jumlah > $product->stok) {
            return back()->with('error', 'Jumlah melebihi stok tersedia! (Stok: ' . $product->stok . ')');
        }

        $cart = session()->get('cart', []);

        $key = $product->id;
        if (isset($cart[$key])) {
            $newJumlah = $cart[$key]['jumlah'] + $request->jumlah;
            if ($newJumlah > $product->stok) {
                return back()->with('error', 'Total jumlah di keranjang melebihi stok! (Stok: ' . $product->stok . ', Di keranjang: ' . $cart[$key]['jumlah'] . ')');
            }
            $cart[$key]['jumlah'] = $newJumlah;
            $cart[$key]['subtotal'] = $newJumlah * $product->harga;
        } else {
            $cart[$key] = [
                'product_id' => $product->id,
                'nama' => $product->nama,
                'harga' => $product->harga,
                'jumlah' => $request->jumlah,
                'subtotal' => $request->jumlah * $product->harga,
            ];
        }

        session()->put('cart', $cart);
        return back()->with('success', $product->nama . ' ditambahkan ke keranjang!');
    }

    public function removeFromCart($key)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$key])) {
            unset($cart[$key]);
            session()->put('cart', $cart);
        }
        return back()->with('success', 'Item dihapus dari keranjang.');
    }

    public function clearCart()
    {
        session()->forget('cart');
        return back()->with('success', 'Keranjang dikosongkan.');
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Keranjang masih kosong!');
        }

        $total = collect($cart)->sum('subtotal');

        $request->validate([
            'bayar' => 'required|numeric|min:' . $total,
        ], [
            'bayar.required' => 'Jumlah bayar wajib diisi.',
            'bayar.numeric' => 'Jumlah bayar harus berupa angka.',
            'bayar.min' => 'Uang bayar kurang! Minimum: Rp ' . number_format($total, 0, ',', '.'),
        ]);

        try {
            DB::beginTransaction();

            $transaction = Transaction::create([
                'invoice' => Transaction::generateInvoice(),
                'user_id' => Auth::id(),
                'total' => $total,
                'bayar' => $request->bayar,
                'kembalian' => $request->bayar - $total,
            ]);

            foreach ($cart as $item) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['product_id'],
                    'nama_produk' => $item['nama'],
                    'harga' => $item['harga'],
                    'jumlah' => $item['jumlah'],
                    'subtotal' => $item['subtotal'],
                ]);

                $product = Product::find($item['product_id']);
                $product->decrement('stok', $item['jumlah']);
            }

            DB::commit();
            session()->forget('cart');

            return redirect()->route('transactions.show', $transaction->id)
                ->with('success', 'Transaksi berhasil!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Transaksi gagal: ' . $e->getMessage());
        }
    }

    public function show(Transaction $transaction)
    {
        $transaction->load('details', 'user');
        return view('transactions.show', compact('transaction'));
    }

    public function history()
    {
        $transactions = Transaction::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('transactions.history', compact('transactions'));
    }
}
