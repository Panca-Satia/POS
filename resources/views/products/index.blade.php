@extends('layouts.app')
@section('title', 'Manajemen Produk')

@section('content')
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-boxes-stacked" style="color: var(--primary); margin-right: 8px;"></i> Daftar Produk</h3>
        <div style="display: flex; gap: 12px; align-items: center;">
            <form action="{{ route('products.index') }}" method="GET" style="display: flex; gap: 8px;">
                <input type="text" name="search" class="form-control" placeholder="Cari produk..." value="{{ $search ?? '' }}" style="width: 220px; margin:0;">
                <button type="submit" class="btn btn-secondary btn-sm"><i class="fas fa-search"></i></button>
            </form>
            <a href="{{ route('products.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Produk
            </a>
        </div>
    </div>
    <div class="table-wrapper">
        @if($products->count())
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $i => $product)
                <tr>
                    <td style="color: var(--gray);">{{ $products->firstItem() + $i }}</td>
                    <td style="font-weight: 600;">{{ $product->nama }}</td>
                    <td>
                        @if($product->category)
                            <span class="badge badge-info">{{ $product->category->nama }}</span>
                        @else
                            <span style="color: var(--gray-light); font-size: 0.8rem;">Tanpa Kategori</span>
                        @endif
                    </td>
                    <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                    <td>{{ $product->stok }}</td>
                    <td>
                        @if($product->stok == 0)
                            <span class="badge badge-danger">Habis</span>
                        @elseif($product->stok <= 5)
                            <span class="badge badge-warning">Rendah</span>
                        @else
                            <span class="badge badge-success">Tersedia</span>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; gap: 6px;">
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Yakin hapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <i class="fas fa-box-open"></i>
            <p>Belum ada produk. <a href="{{ route('products.create') }}" style="color: var(--primary);">Tambah sekarang</a></p>
        </div>
        @endif
    </div>
    @if($products->hasPages())
    <div class="pagination-wrapper">
        {{ $products->withQueryString()->links('pagination::simple-bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
