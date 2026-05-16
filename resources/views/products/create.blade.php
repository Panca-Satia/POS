@extends('layouts.app')
@section('title', 'Tambah Produk')

@section('content')
<div style="max-width: 600px;">
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-plus-circle" style="color: var(--success); margin-right: 8px;"></i> Tambah Produk Baru</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('products.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nama">Nama Produk <span style="color: var(--danger);">*</span></label>
                    <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror"
                           value="{{ old('nama') }}" placeholder="Masukkan nama produk" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="category_id">Kategori</label>
                    <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                           value="{{ old('harga') }}" placeholder="0" min="0" step="100" required>
                    @error('harga')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="stok">Stok <span style="color: var(--danger);">*</span></label>
                    <input type="number" id="stok" name="stok" class="form-control @error('stok') is-invalid @enderror"
                           value="{{ old('stok', 0) }}" placeholder="0" min="0" required>
                    @error('stok')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div style="display: flex; gap: 12px; margin-top: 24px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
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
