@extends('layouts.app')
@section('title', 'Tambah Kategori')

@section('content')
<div style="max-width: 500px;">
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-plus-circle" style="color: var(--success); margin-right: 8px;"></i> Tambah Kategori Baru</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nama">Nama Kategori <span style="color: var(--danger);">*</span></label>
                    <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror"
                           value="{{ old('nama') }}" placeholder="Contoh: Minuman" required autofocus>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div style="display: flex; gap: 12px; margin-top: 24px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
