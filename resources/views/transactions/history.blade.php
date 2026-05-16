@extends('layouts.app')
@section('title', 'Riwayat Transaksi')

@section('content')
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-history" style="color: var(--primary); margin-right: 8px;"></i> Riwayat Transaksi</h3>
        <a href="{{ route('transactions.index') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Transaksi Baru
        </a>
    </div>
    <div class="table-wrapper">
        @if($transactions->count())
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Invoice</th>
                    <th>Kasir</th>
                    <th>Total</th>
                    <th>Bayar</th>
                    <th>Kembalian</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $i => $trx)
                <tr>
                    <td style="color: var(--gray);">{{ $transactions->firstItem() + $i }}</td>
                    <td style="font-weight: 700; color: var(--primary);">{{ $trx->invoice }}</td>
                    <td>{{ $trx->user->name }}</td>
                    <td style="font-weight: 600;">Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($trx->bayar, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($trx->kembalian, 0, ',', '.') }}</td>
                    <td style="color: var(--gray); font-size: 0.8rem;">{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('transactions.show', $trx->id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <i class="fas fa-receipt"></i>
            <p>Belum ada riwayat transaksi</p>
        </div>
        @endif
    </div>
    @if($transactions->hasPages())
    <div class="pagination-wrapper">
        {{ $transactions->links('pagination::simple-bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
