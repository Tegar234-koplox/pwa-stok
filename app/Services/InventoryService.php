<?php

namespace App\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use RuntimeException;

class InventoryService
{
    public const EXCLUDED_FROM_BADGE = ['Asam Manis', 'Jeletot', 'Lada Hitam', 'Chili Oil'];

    private const NEGATIVE_ORIGINS = ['Penjualan', 'Rusak', 'Berkurang'];

    private const BRANCHES = [
        'dapur' => [
            'table' => 'dapur',
            'short' => 'Dapur',
            'label' => 'Dapur Luar',
            'title' => 'STOCK MANAGEMENT SYSTEM',
            'description' => 'Pusat kontrol stok dapur dan distribusi antar cabang.',
            'quick_adjust' => true,
        ],
        'taman' => [
            'table' => 'taman',
            'short' => 'Taman',
            'label' => 'Taman Pinang',
            'title' => 'STOCK MANAGEMENT SYSTEM',
            'description' => 'Monitoring stok cabang Taman Pinang.',
            'quick_adjust' => false,
        ],
        'pahlawan' => [
            'table' => 'pahlawan',
            'short' => 'Pahlawan',
            'label' => 'Pahlawan',
            'title' => 'STOCK MANAGEMENT SYSTEM',
            'description' => 'Monitoring stok cabang Pahlawan',
            'quick_adjust' => false,
        ],
    ];

    public function branches(): array
    {
        return collect(self::BRANCHES)
            ->map(fn(array $branch, string $slug) => ['slug' => $slug] + $branch)
            ->all();
    }

    public function branch(string $slug): array
    {
        $slug = strtolower($slug);

        if (! array_key_exists($slug, self::BRANCHES)) {
            throw new InvalidArgumentException('Cabang tidak dikenal.');
        }

        return ['slug' => $slug] + self::BRANCHES[$slug];
    }

    public function peers(string $branchSlug): array
    {
        $this->branch($branchSlug);

        return collect(self::BRANCHES)
            ->except($branchSlug)
            ->map(fn(array $branch, string $slug) => ['slug' => $slug] + $branch)
            ->values()
            ->all();
    }

    public function legacyUrl(string $file): string
    {
        return url($file);
    }

    public function legacyBranchUrl(string $branchSlug): string
    {
        return $this->legacyUrl("{$branchSlug}.php");
    }

    public function legacyTransferUrl(string $branchSlug, string $targetSlug): string
    {
        return $this->legacyUrl("{$branchSlug}-kirim-ke-{$targetSlug}.php");
    }

    public function legacyReceiveUrl(string $branchSlug, string $sourceSlug): string
    {
        return $this->legacyUrl("{$branchSlug}-terima-dari-{$sourceSlug}.php");
    }

    public function legacyMovementUrl(string $branchSlug, string $type): string
    {
        return $this->legacyUrl("{$branchSlug}-{$type}.php");
    }

    public function legacyRecordUrl(string $branchSlug): string
    {
        return $this->legacyUrl("{$branchSlug}-record.php");
    }

    public function sidebarData(string $branchSlug): array
    {
        $branch = $this->branch($branchSlug);
        $peers = $this->peers($branchSlug);
        $badges = $this->pendingBadges($branchSlug);

        return compact('branch', 'peers', 'badges');
    }

    public function dashboardCards(string $branchSlug): Collection
    {
        $branch = $this->branch($branchSlug);
        $table = $branch['table'];
        $peers = collect($this->peers($branchSlug))->pluck('short')->all();

        return $this->baseItems($branchSlug)->map(function (object $item) use ($branchSlug, $table, $peers) {
            $incoming = DB::table($table)
                ->where('nama', $item->nama)
                ->where('konfirmasi', 'Belum')
                ->where(function ($query) use ($peers) {
                    foreach ($peers as $peer) {
                        $query->orWhereRaw('LOWER(asal) = ?', [strtolower($peer)]);
                    }
                })
                ->sum('stok');

            $stock = $this->stockByName($branchSlug, $item->nama);

            return (object) [
                'id' => $item->id,
                'kode' => $item->kode,
                'nama' => $item->nama,
                'stok' => $stock,
                'masuk' => (int) $incoming,
                'is_low' => $stock < 10 && ! in_array($item->nama, self::EXCLUDED_FROM_BADGE, true),
                'show_incoming' => $incoming > 0 && ! in_array($item->nama, self::EXCLUDED_FROM_BADGE, true),
            ];
        });
    }

    public function actionItems(string $branchSlug): Collection
    {
        return $this->baseItems($branchSlug)->map(function (object $item) use ($branchSlug) {
            return (object) [
                'id' => $item->id,
                'kode' => $item->kode,
                'nama' => $item->nama,
                'stok' => $this->stockByName($branchSlug, $item->nama),
            ];
        });
    }

    public function pendingIncoming(string $branchSlug, string $sourceSlug): Collection
    {
        $branch = $this->branch($branchSlug);
        $source = $this->branch($sourceSlug);

        return DB::table($branch['table'])
            ->select('nama', DB::raw('MIN(kode) as kode'), DB::raw('SUM(stok) as jumlah'), DB::raw('MIN(created_at) as created_at'))
            ->where('konfirmasi', 'Belum')
            ->whereRaw('LOWER(asal) = ?', [strtolower($source['short'])])
            ->groupBy('nama')
            ->orderBy('nama')
            ->get()
            ->map(function (object $row) {
                $row->jumlah = (int) $row->jumlah;
                $row->is_excluded = in_array($row->nama, self::EXCLUDED_FROM_BADGE, true);
                return $row;
            });
    }

    public function records(string $branchSlug, ?string $date): array
    {
        $branch = $this->branch($branchSlug);
        $table = $branch['table'];

        $query = DB::table($table)->orderByDesc('id');
        $totalsQuery = DB::table($table)->select('asal', DB::raw('SUM(stok) as total'));

        if ($date) {
            $parsed = Carbon::createFromFormat('Y-m-d', $date);
            $query->whereDate('updated_at', $parsed->toDateString());
            $totalsQuery->whereDate('updated_at', $parsed->toDateString());
        }

        $records = $query->get();
        $totals = $totalsQuery
            ->groupBy('asal')
            ->get()
            ->mapWithKeys(fn(object $row) => [($row->asal ?: 'Stok Awal') => (int) $row->total])
            ->all();

        return compact('records', 'totals');
    }

    public function adjustStock(string $branchSlug, string $nama, string $action, int $quantity): string
    {
        $branch = $this->branch($branchSlug);
        $quantity = abs($quantity);

        if (! $branch['quick_adjust']) {
            throw new RuntimeException('Koreksi cepat hanya tersedia pada halaman Dapur Luar.');
        }

        if ($quantity < 1 || ! in_array($action, ['tambah', 'kurang'], true)) {
            throw new RuntimeException('Input koreksi stok tidak valid.');
        }

        $kode = DB::table($branch['table'])
            ->where('nama', $nama)
            ->whereNotNull('kode')
            ->where('kode', '!=', '')
            ->orderBy('id')
            ->value('kode') ?: 'UNKNOWN';

        DB::table($branch['table'])->insert([
            'kode' => $kode,
            'nama' => $nama,
            'stok' => $quantity,
            'asal' => $action === 'tambah' ? 'Tambah' : 'Berkurang',
            'konfirmasi' => 'Sudah',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $action === 'tambah'
            ? "Stok {$nama} berhasil ditambah {$quantity}."
            : "Stok {$nama} berhasil dikurangi {$quantity}.";
    }

    public function transfer(string $sourceSlug, string $targetSlug, int $itemId, int $quantity): string
    {
        $source = $this->branch($sourceSlug);
        $target = $this->branch($targetSlug);

        if ($sourceSlug === $targetSlug) {
            throw new RuntimeException('Cabang sumber dan tujuan tidak boleh sama.');
        }

        if ($quantity < 1) {
            throw new RuntimeException('Jumlah kirim harus lebih dari 0.');
        }

        DB::transaction(function () use ($source, $target, $itemId, $quantity): void {
            $item = DB::table($source['table'])->where('id', $itemId)->first();

            if (! $item) {
                throw new RuntimeException('Data barang tidak ditemukan.');
            }

            $this->reduceAvailableRows($source['table'], $item->nama, $quantity);

            DB::table($target['table'])->insert([
                'kode' => $item->kode,
                'nama' => $item->nama,
                'stok' => $quantity,
                'asal' => $source['short'],
                'konfirmasi' => 'Belum',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        return "Pengiriman {$quantity} {$source['short']} → {$target['short']} berhasil dicatat.";
    }

    public function reduceForPurpose(string $branchSlug, string $purpose, int $itemId, int $quantity): string
    {
        $branch = $this->branch($branchSlug);
        $purpose = ucfirst(strtolower($purpose));

        if (! in_array($purpose, ['Penjualan', 'Rusak'], true)) {
            throw new RuntimeException('Jenis pengurangan stok tidak valid.');
        }

        if ($quantity < 1) {
            throw new RuntimeException('Jumlah harus lebih dari 0.');
        }

        DB::transaction(function () use ($branch, $purpose, $itemId, $quantity): void {
            $item = DB::table($branch['table'])->where('id', $itemId)->first();

            if (! $item) {
                throw new RuntimeException('Data barang tidak ditemukan.');
            }

            $this->reduceAvailableRows($branch['table'], $item->nama, $quantity);

            DB::table($branch['table'])->insert([
                'kode' => $item->kode,
                'nama' => $item->nama,
                'stok' => $quantity,
                'asal' => $purpose,
                'konfirmasi' => 'Sudah',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        return "Stok {$purpose} berhasil dicatat.";
    }

    public function confirmIncoming(string $branchSlug, string $sourceSlug, string $nama): string
    {
        $branch = $this->branch($branchSlug);
        $source = $this->branch($sourceSlug);

        $updated = DB::table($branch['table'])
            ->where('nama', $nama)
            ->where('konfirmasi', 'Belum')
            ->whereRaw('LOWER(asal) = ?', [strtolower($source['short'])])
            ->update([
                'konfirmasi' => 'Sudah',
                'updated_at' => now(),
            ]);

        if ($updated < 1) {
            throw new RuntimeException('Tidak ada stok masuk yang perlu dikonfirmasi.');
        }

        return "Penerimaan {$nama} dari {$source['short']} berhasil dikonfirmasi.";
    }

    public function pendingBadges(string $branchSlug): array
    {
        $branch = $this->branch($branchSlug);
        $table = $branch['table'];
        $badges = [];

        foreach ($this->peers($branchSlug) as $peer) {
            $rows = DB::table($table)
                ->select('nama', DB::raw('SUM(stok) as jumlah'))
                ->where('konfirmasi', 'Belum')
                ->whereRaw('LOWER(asal) = ?', [strtolower($peer['short'])])
                ->groupBy('nama')
                ->get();

            $badges[$peer['slug']] = $rows->reduce(function (int $carry, object $row): int {
                if (in_array($row->nama, self::EXCLUDED_FROM_BADGE, true)) {
                    return $carry;
                }

                return $carry + (int) $row->jumlah;
            }, 0);
        }

        return $badges;
    }

    private function baseItems(string $branchSlug): Collection
    {
        $branch = $this->branch($branchSlug);

        return DB::table($branch['table'])
            ->whereBetween('id', [1, 21])
            ->orderBy('id')
            ->get();
    }

    private function stockByName(string $branchSlug, string $name): int
    {
        $branch = $this->branch($branchSlug);

        return DB::table($branch['table'])
            ->select('asal', 'stok')
            ->where('nama', $name)
            ->where('konfirmasi', 'Sudah')
            ->get()
            ->sum(function (object $row): int {
                return $this->isNegativeOrigin($row->asal) ? - ((int) $row->stok) : (int) $row->stok;
            });
    }

    private function isNegativeOrigin(?string $origin): bool
    {
        if ($origin === null || $origin === '') {
            return false;
        }

        return in_array(strtolower($origin), array_map('strtolower', self::NEGATIVE_ORIGINS), true);
    }

    private function reduceAvailableRows(string $table, string $name, int $quantity): void
    {
        $rows = DB::table($table)
            ->where('nama', $name)
            ->where('konfirmasi', 'Sudah')
            ->orderBy('id')
            ->lockForUpdate()
            ->get();

        $available = $rows->sum(function (object $row): int {
            return $this->isNegativeOrigin($row->asal) ? - ((int) $row->stok) : (int) $row->stok;
        });

        if ($quantity > $available) {
            throw new RuntimeException("Stok {$name} tidak mencukupi. Tersedia {$available}, diminta {$quantity}.");
        }

        $positiveRows = $rows->filter(function (object $row): bool {
            return (int) $row->stok > 0 && ! $this->isNegativeOrigin($row->asal);
        });

        $remaining = $quantity;

        foreach ($positiveRows as $row) {
            if ($remaining <= 0) {
                break;
            }

            $deduct = min((int) $row->stok, $remaining);

            DB::table($table)
                ->where('id', $row->id)
                ->update([
                    'stok' => (int) $row->stok - $deduct,
                    'updated_at' => now(),
                ]);

            $remaining -= $deduct;
        }
    }
}
