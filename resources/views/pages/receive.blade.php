@extends('layouts.app')

@section('title', $branch['label'].' - Terima dari '.$source['short'])
@section('page_title', 'Terima dari '.$source['short'])

@section('content')
<section class="section-card">
    <div class="section-heading">
        <div>
            <p class="eyebrow">{{ $source['short'] }} → {{ $branch['short'] }}</p>
            <h2>Konfirmasi Stok Masuk</h2>
            <p>Konfirmasi akan mengubah status seluruh stok masuk dengan nama barang yang sama menjadi <strong>Sudah</strong>.</p>
        </div>
        <a class="ghost-link" href="{{ $inventory->legacyBranchUrl($branch['slug']) }}">Kembali</a>
    </div>

    <div class="receive-grid">
        @forelse ($items as $item)
            <article class="receive-card {{ $item->is_excluded ? 'muted' : '' }}">
                <div>
                    <span class="code-pill">{{ $item->kode }}</span>
                    <h3>{{ $item->nama }}</h3>
                    <p>Menunggu konfirmasi dari {{ $source['short'] }}</p>
                </div>
                <div class="receive-amount">{{ $item->jumlah }}</div>
                <form method="post">
                    @csrf
                    <input type="hidden" name="nama" value="{{ $item->nama }}">
                    <button class="launch-button small" type="submit">Konfirmasi</button>
                </form>
            </article>
        @empty
            <article class="empty-state">
                Tidak ada stok masuk dari {{ $source['short'] }} yang belum dikonfirmasi.
            </article>
        @endforelse
    </div>
</section>
@endsection
