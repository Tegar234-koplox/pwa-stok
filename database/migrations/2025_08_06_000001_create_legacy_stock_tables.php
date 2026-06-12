<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $sqlPath = database_path('sql/stok.sql');

        if (! file_exists($sqlPath)) {
            throw new RuntimeException('File database/sql/stok.sql tidak ditemukan.');
        }

        DB::unprepared(file_get_contents($sqlPath));
    }

    public function down(): void
    {
        Schema::dropIfExists('dapur');
        Schema::dropIfExists('pahlawan');
        Schema::dropIfExists('taman');
    }
};
