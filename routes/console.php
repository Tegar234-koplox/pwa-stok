<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('app:about-stock', function () {
    $this->info('PWA Stok Resto - Laravel 11');
})->purpose('Menampilkan informasi aplikasi stok.');
