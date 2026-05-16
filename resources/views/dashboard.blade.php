@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-boxes-stacked"></i></div>
        <div class="stat-info">
            <h4>Total Produk</h4>
            <div class="stat-value">{{ $totalProducts }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-receipt"></i></div>
        <div class="stat-info">
            <h4>Transaksi Hari Ini</h4>
            <div class="stat-value">{{ $todayTransactions }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon purple"><i class="fas fa-wallet"></i></div>
        <div class="stat-info">
            <h4>Pendapatan Hari Ini</h4>
            <div class="stat-value">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fas fa-chart-line"></i></div>
        <div class="stat-info">
            <h4>Total Pendapatan</h4>
            <div class="stat-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        </div>
    </div>
</div>

<div class="grid-2">
    {{-- Recent Transactions --}}
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-clock" style="color: var(--primary); margin-right: 8px;"></i> Transaksi Terakhir</h3>
            <a href="{{ route('transactions.history') }}" class="btn btn-sm btn-secondary">Lihat Semua</a>
        </div>
        <div class="table-wrapper">
            @if($recentTransactions->count())
            <table>
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Total</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentTransactions as $trx)
                    <tr>
                        <td>
                            <a href="{{ route('transactions.show', $trx->id) }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">
                                {{ $trx->invoice }}
                            </a>
                        </td>
                        <td style="font-weight: 600;">Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                        <td style="color: var(--gray); font-size: 0.8rem;">{{ $trx->created_at->format('d/m H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">
                <i class="fas fa-receipt"></i>
                <p>Belum ada transaksi</p>
            </div>
            @endif
        </div>
    </div>

    {{-- Low Stock --}}
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-exclamation-triangle" style="color: var(--warning); margin-right: 8px;"></i> Stok Rendah</h3>
            @if(Auth::user()->isAdmin())
            <a href="{{ route('products.index') }}" class="btn btn-sm btn-secondary">Kelola Produk</a>
            @endif
        </div>
        <div class="table-wrapper">
            @if($lowStock->count())
            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Stok</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lowStock as $product)
                    <tr>
                        <td style="font-weight: 600;">{{ $product->nama }}</td>
                        <td>{{ $product->stok }}</td>
                        <td>
                            @if($product->stok == 0)
                                <span class="badge badge-danger">Habis</span>
                            @else
                                <span class="badge badge-warning">Rendah</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">
                <i class="fas fa-check-circle"></i>
                <p>Semua stok aman</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
