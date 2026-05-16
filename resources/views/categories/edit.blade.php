@extends('layouts.app')
@section('title', 'Edit Kategori')

@section('content')
<div style="max-width: 500px;">
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-edit" style="color: var(--warning); margin-right: 8px;"></i> Edit Kategori</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('categories.update', $category) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nama">Nama Kategori <span style="color: var(--danger);">*</span></label>
                    <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror"
                           value="{{ old('nama', $category->nama) }}" placeholder="Contoh: Minuman" required autofocus>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div style="display: flex; gap: 12px; margin-top: 24px;">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i> Update
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
