@extends('layouts.app')

@section('title', $branch['label'].' - Record')
@section('page_title', 'Record '.$branch['label'])

@section('content')
<section class="section-card">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Riwayat Transaksi</p>
            <h2>Record {{ $branch['label'] }}</h2>
            <p>Filter berdasarkan tanggal update untuk audit stok harian.</p>
        </div>
        <a class="ghost-link" href="{{ $inventory->legacyBranchUrl($branch['slug']) }}">Kembali</a>
    </div>

    <form method="get" class="filter-form">
        <label>
            <span>Tanggal</span>
            <input class="date-input" type="date" name="tanggal" value="{{ $tanggal }}">
        </label>
        <button class="launch-button small" type="submit">Filter</button>
        <a class="ghost-link" href="{{ $inventory->legacyRecordUrl($branch['slug']) }}">Reset</a>
    </form>

    <div class="totals-row">
        @forelse ($totals as $origin => $total)
            <div class="metric-card compact">
                <span>{{ $origin }}</span>
                <strong>{{ $total }}</strong>
            </div>
        @empty
            <div class="metric-card compact">
                <span>Total</span>
                <strong>0</strong>
            </div>
        @endforelse
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Asal</th>
                    <th>Stok</th>
                    <th>Konfirmasi</th>
                    <th>Dibuat</th>
                    <th>Diupdate</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($records as $record)
                    <tr>
                        <td>{{ $record->id }}</td>
                        <td><span class="code-pill">{{ $record->kode }}</span></td>
                        <td>{{ $record->nama }}</td>
                        <td>{{ $record->asal ?: 'Stok Awal' }}</td>
                        <td>{{ $record->stok }}</td>
                        <td><span class="status-pill {{ strtolower($record->konfirmasi) === 'sudah' ? 'ok' : 'pending' }}">{{ $record->konfirmasi }}</span></td>
                        <td>{{ $record->created_at }}</td>
                        <td>{{ $record->updated_at }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">Tidak ada record pada filter ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
