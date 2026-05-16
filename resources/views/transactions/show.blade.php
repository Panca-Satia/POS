@extends('layouts.app')
@section('title', 'Struk Transaksi')

@section('content')
<div style="max-width: 500px; margin: 0 auto;">
    <div class="card" id="receipt">
        <div class="card-body" style="padding: 32px;">
            {{-- Receipt Header --}}
            <div style="text-align: center; margin-bottom: 24px; padding-bottom: 20px; border-bottom: 2px dashed var(--border);">
                <div style="font-size: 1.5rem; margin-bottom: 4px;">🧾</div>
                <h2 style="font-size: 1.3rem; font-weight: 800; color: var(--dark); margin-bottom: 2px;">POS App</h2>
                <p style="color: var(--gray); font-size: 0.75rem;">Point of Sale System</p>
            </div>

            {{-- Transaction Info --}}
            <div style="margin-bottom: 20px; font-size: 0.8rem;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                    <span style="color: var(--gray);">No. Invoice</span>
                    <span style="font-weight: 700;">{{ $transaction->invoice }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                    <span style="color: var(--gray);">Tanggal</span>
                    <span>{{ $transaction->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: var(--gray);">Kasir</span>
                    <span>{{ $transaction->user->name }}</span>
                </div>
            </div>

            {{-- Items --}}
            <div style="border-top: 1px dashed var(--border); border-bottom: 1px dashed var(--border); padding: 16px 0; margin-bottom: 16px;">
                @foreach($transaction->details as $detail)
                <div style="margin-bottom: 12px;">
                    <div style="font-weight: 600; font-size: 0.85rem;">{{ $detail->nama_produk }}</div>
                    <div style="display: flex; justify-content: space-between; color: var(--gray); font-size: 0.8rem;">
                        <span>{{ $detail->jumlah }} x Rp {{ number_format($detail->harga, 0, ',', '.') }}</span>
                        <span style="font-weight: 600; color: var(--dark);">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Summary --}}
            <div style="font-size: 0.85rem;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px; padding: 12px; background: linear-gradient(135deg, #f1f5f9, #e2e8f0); border-radius: 8px;">
                    <span style="font-weight: 700; font-size: 1rem;">TOTAL</span>
                    <span style="font-weight: 800; font-size: 1.1rem; color: var(--dark);">Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 6px; padding: 0 4px;">
                    <span style="color: var(--gray);">Bayar</span>
                    <span style="font-weight: 600;">Rp {{ number_format($transaction->bayar, 0, ',', '.') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 10px; background: #ecfdf5; border-radius: 8px;">
                    <span style="font-weight: 600; color: #065f46;">Kembalian</span>
                    <span style="font-weight: 800; color: #059669; font-size: 1.05rem;">Rp {{ number_format($transaction->kembalian, 0, ',', '.') }}</span>
                </div>
            </div>

            {{-- Footer --}}
            <div style="text-align: center; margin-top: 24px; padding-top: 16px; border-top: 2px dashed var(--border);">
                <p style="color: var(--gray); font-size: 0.75rem;">Terima kasih atas pembelian Anda!</p>
                <p style="color: var(--gray-light); font-size: 0.7rem; margin-top: 4px;">{{ $transaction->created_at->format('d F Y, H:i:s') }}</p>
            </div>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="no-print" style="display: flex; gap: 12px; margin-top: 20px; justify-content: center;">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="fas fa-print"></i> Cetak Struk
        </button>
        <a href="{{ route('transactions.index') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Transaksi Baru
        </a>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-home"></i> Dashboard
        </a>
    </div>
</div>
@endsection
