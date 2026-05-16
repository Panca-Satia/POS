@extends('layouts.app')
@section('title', 'Transaksi Baru')

@section('content')
<div class="grid-2">
    {{-- Left: Product Selection --}}
    <div>
        <div class="card" style="margin-bottom: 20px;">
            <div class="card-header">
                <h3><i class="fas fa-boxes-stacked" style="color: var(--primary); margin-right: 8px;"></i> Pilih Produk</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('transactions.addToCart') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="product_id">Produk</label>
                        <select name="product_id" id="product_id" class="form-control" required onchange="updateProductInfo()">
                            <option value="">-- Pilih Produk --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}"
                                    data-harga="{{ $product->harga }}"
                                    data-stok="{{ $product->stok }}">
                                    {{ $product->nama }} - Rp {{ number_format($product->harga, 0, ',', '.') }} (Stok: {{ $product->stok }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div id="product-info" style="display:none; padding: 12px; background: #f1f5f9; border-radius: 8px; margin-bottom: 16px;">
                        <div style="display: flex; justify-content: space-between; font-size: 0.85rem;">
                            <span>Harga: <strong id="info-harga">-</strong></span>
                            <span>Stok: <strong id="info-stok">-</strong></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="jumlah">Jumlah</label>
                        <input type="number" name="jumlah" id="jumlah" class="form-control" value="1" min="1" required>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Right: Cart --}}
    <div>
        <div class="card" style="margin-bottom: 20px;">
            <div class="card-header">
                <h3><i class="fas fa-shopping-cart" style="color: var(--success); margin-right: 8px;"></i> Keranjang</h3>
                @if(count($cart) > 0)
                <form action="{{ route('transactions.clearCart') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Kosongkan keranjang?')">
                        <i class="fas fa-trash"></i> Kosongkan
                    </button>
                </form>
                @endif
            </div>

            @if(count($cart) > 0)
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cart as $key => $item)
                        <tr>
                            <td style="font-weight: 600;">{{ $item['nama'] }}</td>
                            <td>Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                            <td>{{ $item['jumlah'] }}</td>
                            <td style="font-weight: 600;">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('transactions.removeFromCart', $key) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-times"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Total & Payment --}}
            <div class="card-body" style="border-top: 2px solid var(--border);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding: 14px; background: linear-gradient(135deg, #f1f5f9, #e2e8f0); border-radius: 10px;">
                    <span style="font-size: 1rem; font-weight: 600; color: var(--gray);">TOTAL</span>
                    <span style="font-size: 1.5rem; font-weight: 800; color: var(--dark);">Rp {{ number_format($cartTotal, 0, ',', '.') }}</span>
                </div>

                <form action="{{ route('transactions.checkout') }}" method="POST" id="checkoutForm">
                    @csrf
                    <div class="form-group">
                        <label for="bayar">Uang Bayar (Rp)</label>
                        <input type="number" name="bayar" id="bayar" class="form-control" min="{{ $cartTotal }}" required
                               style="font-size: 1.1rem; font-weight: 700; padding: 14px;"
                               oninput="hitungKembalian()">
                    </div>

                    <div id="kembalian-display" style="display:none; padding: 14px; background: #ecfdf5; border-radius: 10px; margin-bottom: 16px; text-align: center;">
                        <span style="font-size: 0.8rem; color: #065f46;">Kembalian</span>
                        <div style="font-size: 1.3rem; font-weight: 800; color: #059669;" id="kembalian-value">Rp 0</div>
                    </div>

                    <button type="submit" class="btn btn-success" style="width: 100%; padding: 14px; font-size: 1rem;">
                        <i class="fas fa-check-circle"></i> Proses Pembayaran
                    </button>
                </form>
            </div>
            @else
            <div class="empty-state">
                <i class="fas fa-shopping-cart"></i>
                <p>Keranjang masih kosong</p>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    function updateProductInfo() {
        const select = document.getElementById('product_id');
        const option = select.options[select.selectedIndex];
        const info = document.getElementById('product-info');

        if (option.value) {
            const harga = parseFloat(option.dataset.harga);
            const stok = option.dataset.stok;
            document.getElementById('info-harga').textContent = 'Rp ' + harga.toLocaleString('id-ID');
            document.getElementById('info-stok').textContent = stok;
            document.getElementById('jumlah').max = stok;
            info.style.display = 'block';
        } else {
            info.style.display = 'none';
        }
    }

    function hitungKembalian() {
        const total = {{ $cartTotal }};
        const bayar = parseFloat(document.getElementById('bayar').value) || 0;
        const display = document.getElementById('kembalian-display');
        const value = document.getElementById('kembalian-value');

        if (bayar >= total) {
            const kembalian = bayar - total;
            value.textContent = 'Rp ' + kembalian.toLocaleString('id-ID');
            display.style.display = 'block';
            display.style.background = '#ecfdf5';
            value.style.color = '#059669';
        } else if (bayar > 0) {
            const kurang = total - bayar;
            value.textContent = 'Kurang Rp ' + kurang.toLocaleString('id-ID');
            display.style.display = 'block';
            display.style.background = '#fef2f2';
            value.style.color = '#dc2626';
        } else {
            display.style.display = 'none';
        }
    }
</script>
@endpush
@endsection
