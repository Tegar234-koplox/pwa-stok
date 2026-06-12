@extends('layouts.app')

@section('title', $branch['label'] . ' - Dashboard')
@section('page_title', $branch['title'])

@section('content')
    @php
        $lowCount = $cards->where('is_low', true)->count();
        $incomingTotal = $cards->sum('masuk');
    @endphp

    <section class="summary-grid">
        <article class="metric-card">
            <span>Total Produk</span>
            <strong>{{ $cards->count() }}</strong>
        </article>
        <article class="metric-card">
            <span>Stok Menipis</span>
            <strong>{{ $lowCount }}</strong>
        </article>
        <article class="metric-card">
            <span>Belum Dikonfirmasi</span>
            <strong>{{ $incomingTotal }}</strong>
        </article>
    </section>

    <section class="inventory-grid">
        @forelse ($cards as $card)
            <article class="stock-card {{ $card->is_low ? 'is-warning' : '' }}">
                <div class="stock-badges">
                    @if ($card->show_incoming)
                        <span class="badge badge-incoming">+{{ $card->masuk }}</span>
                    @endif
                    @if ($card->is_low)
                        <span class="badge badge-danger">!</span>
                    @endif
                </div>

                <div class="stock-code">{{ $card->kode }}</div>
                <h2>{{ $card->nama }}</h2>
                <p class="stock-label">Stok tersedia</p>
                <div class="stock-value">{{ $card->stok }}</div>

                @if ($branch['quick_adjust'])
                    <form method="post" class="quick-form" data-stock-form>
                        @csrf
                        <input type="hidden" name="nama" value="{{ $card->nama }}">
                        <input type="hidden" name="aksi_stok" value="" data-action-field>
                        <div class="segmented-actions">
                            <button type="button" class="segment-btn" data-action="tambah">＋</button>
                            <button type="button" class="segment-btn" data-action="kurang">－</button>
                        </div>
                        <input class="number-input" type="number" name="jumlah" min="1" placeholder="Jumlah"
                            required>
                        <button class="save-btn" type="submit" disabled data-save-button>Simpan</button>
                    </form>
                @endif
            </article>
        @empty
            <article class="empty-state">Data stok kosong.</article>
        @endforelse
    </section>
@endsection
