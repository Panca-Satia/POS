@extends('layouts.app')
@section('title', 'Edit Produk')

@section('content')
<div style="max-width: 600px;">
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-edit" style="color: var(--warning); margin-right: 8px;"></i> Edit Produk</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('products.update', $product) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nama">Nama Produk <span style="color: var(--danger);">*</span></label>
                    <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror"
                           value="{{ old('nama', $product->nama) }}" placeholder="Masukkan nama produk" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="category_id">Kategori</label>
                    <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="harga">Harga (Rp) <span style="color: var(--danger);">*</span></label>
                    <input type="number" id="harga" name="harga" class="form-control @error('harga') is-invalid @enderror"
                           value="{{ old('harga', $product->harga) }}" placeholder="0" min="0" step="100" required>
                    @error('harga')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="stok">Stok <span style="color: var(--danger);">*</span></label>
                    <input type="number" id="stok" name="stok" class="form-control @error('stok') is-invalid @enderror"
                           value="{{ old('stok', $product->stok) }}" placeholder="0" min="0" required>
                    @error('stok')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div style="display: flex; gap: 12px; margin-top: 24px;">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i> Update
                    </button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
