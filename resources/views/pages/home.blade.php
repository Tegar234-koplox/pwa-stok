@extends('layouts.app')

@section('title', 'Stock Management System')

@section('content')
    <main class="home-shell">
        <section class="home-hero cosmic-card">
            <div class="hero-copy">
                <p class="eyebrow">Stock Management System</p>
                <h1>Akang Seafood</h1>
            </div>
            <div class="hero-orb" aria-hidden="true"></div>
        </section>

        <section class="branch-grid" aria-label="Pilih cabang">
            @foreach ($branches as $slug => $branch)
                <article class="launch-card">
                    <div class="particle-field" aria-hidden="true"></div>
                    <div class="launch-card-content">
                        <p class="eyebrow">Cabang</p>
                        <h2>{{ $branch['label'] }}</h2>
                        <p>{{ $branch['description'] }}</p>
                    </div>
                    <a class="launch-button" href="{{ $inventory->legacyBranchUrl($slug) }}">Launch</a>
                </article>
            @endforeach
        </section>
    </main>
@endsection
