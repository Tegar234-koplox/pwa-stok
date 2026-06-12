@php
    $currentPath = trim(request()->path(), '/');

    $branchSlug = $branch['slug'] ?? '';
    $branchLabel = $branch['label'] ?? ($branch['short'] ?? ucfirst($branchSlug));

    $peers = collect($peers ?? [])
        ->filter(fn($peer) => is_array($peer))
        ->map(function (array $peer) {
            if (empty($peer['slug'])) {
                $peer['slug'] = \Illuminate\Support\Str::slug(
                    $peer['short'] ?? ($peer['label'] ?? ($peer['title'] ?? '')),
                );
            }

            return $peer;
        })
        ->filter(fn(array $peer) => !empty($peer['slug']))
        ->values();
@endphp
<aside class="sidebar" id="sidebar">
    <div class="brand-block">
        <img src="{{ asset('images/akangseafood.png') }}" alt="Logo" class="brand-logo">
        <div>
            <p>Inventory</p>
            <strong>{{ $branch['label'] }}</strong>
        </div>
    </div>

    <nav class="nav-list" aria-label="Navigasi cabang">
        <a class="nav-item {{ $currentPath === $branchSlug . '.php' ? 'active' : '' }}"
            href="{{ $inventory->legacyBranchUrl($branchSlug) }}">
            <span>Dashboard</span>
        </a>

        <div class="nav-section">Penerimaan</div>
        @foreach ($peers as $peer)
            @php
                $peerSlug = $peer['slug'];
                $path = $branchSlug . '-terima-dari-' . $peerSlug . '.php';
            @endphp

            <a class="nav-item {{ $currentPath === $path ? 'active' : '' }}"
                href="{{ $inventory->legacyReceiveUrl($branchSlug, $peerSlug) }}">
                <span>Terima dari {{ $peer['short'] ?? ($peer['label'] ?? ucfirst($peerSlug)) }}</span>

                @if (($badges[$peerSlug] ?? 0) > 0)
                    <span class="nav-badge">{{ $badges[$peerSlug] }}</span>
                @endif
            </a>
        @endforeach

        <div class="nav-section">Distribusi</div>
        @foreach ($peers as $peer)
            @php
                $peerSlug = $peer['slug'];
                $path = $branchSlug . '-kirim-ke-' . $peerSlug . '.php';
            @endphp

            <a class="nav-item {{ $currentPath === $path ? 'active' : '' }}"
                href="{{ $inventory->legacyTransferUrl($branchSlug, $peerSlug) }}">
                <span>Kirim ke {{ $peer['short'] ?? ($peer['label'] ?? ucfirst($peerSlug)) }}</span>
            </a>
        @endforeach

        <div class="nav-section">Operasional</div>
        <a class="nav-item {{ $currentPath === $branch['slug'] . '-penjualan.php' ? 'active' : '' }}"
            href="{{ $inventory->legacyMovementUrl($branch['slug'], 'penjualan') }}">
            <span>Penjualan</span>
        </a>
        <a class="nav-item {{ $currentPath === $branch['slug'] . '-rusak.php' ? 'active' : '' }}"
            href="{{ $inventory->legacyMovementUrl($branch['slug'], 'rusak') }}">
            <span>Rusak/Hilang</span>
        </a>
        <a class="nav-item {{ $currentPath === $branch['slug'] . '-record.php' ? 'active' : '' }}"
            href="{{ $inventory->legacyRecordUrl($branch['slug']) }}">
            <span>Record</span>
        </a>
        <a class="nav-item" href="{{ url('index.php') }}">
            <span>Menu Utama</span>
        </a>
    </nav>
</aside>
<div class="sidebar-backdrop" data-sidebar-toggle></div>
