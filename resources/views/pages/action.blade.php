@extends('layouts.app')

@section('title', $branch['label'].' - '.$title)
@section('page_title', $title)

@section('content')
<section class="section-card">
    <div class="section-heading">
        <div>
            <p class="eyebrow">{{ $branch['label'] }}</p>
            <h2>{{ $title }}</h2>
            <p>{{ $subtitle }}</p>
        </div>
        <a class="ghost-link" href="{{ $inventory->legacyBranchUrl($branch['slug']) }}">Kembali</a>
    </div>

    <div class="table-wrap action-list">
        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $item)
                    <tr>
                        <td><span class="code-pill">{{ $item->kode }}</span></td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->stok }}</td>
                        <td>
                            <form method="post" class="row-form">
                                @csrf
                                <input type="hidden" name="id" value="{{ $item->id }}">
                                <input class="number-input" type="number" name="jumlah_kirim" min="1" max="100000" placeholder="Jumlah" required>
                                <button class="launch-button small" type="submit">{{ $submitLabel }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Data barang kosong.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
