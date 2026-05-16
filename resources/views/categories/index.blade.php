@extends('layouts.app')
@section('title', 'Kategori Produk')

@section('content')
<div class="card" style="max-width: 800px;">
    <div class="card-header">
        <h3><i class="fas fa-tags" style="color: var(--primary); margin-right: 8px;"></i> Daftar Kategori</h3>
        <a href="{{ route('categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Kategori
        </a>
    </div>
    <div class="table-wrapper">
        @if($categories->count())
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Jumlah Produk</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $i => $category)
                <tr>
                    <td style="color: var(--gray);">{{ $i + 1 }}</td>
                    <td style="font-weight: 600;">{{ $category->nama }}</td>
                    <td><span class="badge badge-info">{{ $category->products_count }}</span></td>
                    <td>
                        <div style="display: flex; gap: 6px;">
                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Yakin hapus kategori ini?')">
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
            <i class="fas fa-tags"></i>
            <p>Belum ada kategori. <a href="{{ route('categories.create') }}" style="color: var(--primary);">Tambah sekarang</a></p>
        </div>
        @endif
    </div>
</div>
@endsection
