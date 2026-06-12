<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0f172a">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Akang Seafood')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/akangseafood.png') }}">
    <link rel="icon" href="{{ asset('akangseafood.png') }}" type="image/png">
    <link rel="manifest" href="{{ asset('manifest.webmanifest') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <div class="page-glow" aria-hidden="true"></div>

    @isset($branch)
        <div class="app-shell">
            @include('components.sidebar', [
                'branch' => $branch,
                'peers' => $peers ?? [],
                'badges' => $badges ?? [],
                'inventory' => $inventory,
            ])

            <main class="workspace" id="workspace">
                <header class="topbar">
                    <button class="icon-button" type="button" data-sidebar-toggle aria-label="Buka menu">
                        <span></span><span></span><span></span>
                    </button>
                    <div>
                        <p class="eyebrow">Akang Seafood</p>
                        <h1>@yield('page_title', $branch['title'])</h1>
                        <p class="topbar-date" id="tanggalHari"></p>
                    </div>
                    <a class="ghost-link" href="{{ url('index.php') }}">Menu Utama</a>
                </header>

                @include('components.flash')

                @yield('content')
            </main>
        </div>
    @else
        @include('components.flash')
        @yield('content')
    @endisset

    <script src="{{ asset('js/app.js') }}" defer></script>
</body>

</html>
