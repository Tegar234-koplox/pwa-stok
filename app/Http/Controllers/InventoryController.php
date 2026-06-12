<?php

namespace App\Http\Controllers;

use App\Services\InventoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use InvalidArgumentException;
use RuntimeException;

class InventoryController extends Controller
{
    public function legacy(Request $request, string $legacy, InventoryService $inventory): View|RedirectResponse
    {
        $legacy = strtolower($legacy);

        if ($legacy === 'index.php') {
            return view('pages.home', [
                'branches' => $inventory->branches(),
                'inventory' => $inventory,
            ]);
        }

        $page = preg_replace('/\.php$/', '', $legacy);
        $parts = explode('-', $page);
        $branchSlug = $parts[0] ?? '';

        try {
            $branch = $inventory->branch($branchSlug);
        } catch (InvalidArgumentException) {
            abort(404);
        }

        if (count($parts) === 1) {
            return $this->dashboard($request, $branchSlug, $inventory);
        }

        if (count($parts) === 2 && $parts[1] === 'record') {
            return $this->record($request, $branchSlug, $inventory);
        }

        if (count($parts) === 2 && in_array($parts[1], ['penjualan', 'rusak'], true)) {
            return $this->movement($request, $branchSlug, $parts[1], $inventory);
        }

        if (count($parts) === 4 && $parts[1] === 'kirim' && $parts[2] === 'ke') {
            return $this->transfer($request, $branchSlug, $parts[3], $inventory);
        }

        if (count($parts) === 4 && $parts[1] === 'terima' && $parts[2] === 'dari') {
            return $this->receive($request, $branchSlug, $parts[3], $inventory);
        }

        abort(404);
    }

    public function dashboard(Request $request, string $branchSlug, InventoryService $inventory): View|RedirectResponse
    {
        $branch = $inventory->branch($branchSlug);

        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'nama' => ['required', 'string', 'max:100'],
                'aksi_stok' => ['required', 'in:tambah,kurang'],
                'jumlah' => ['required', 'integer', 'min:1', 'max:100000'],
            ]);

            try {
                $message = $inventory->adjustStock(
                    $branchSlug,
                    $validated['nama'],
                    $validated['aksi_stok'],
                    (int) $validated['jumlah']
                );

                return back()->with('status', $message);
            } catch (RuntimeException $exception) {
                return back()->withErrors(['stok' => $exception->getMessage()])->withInput();
            }
        }

        return view('pages.dashboard', [
            'branch' => $branch,
            'peers' => $inventory->peers($branchSlug),
            'badges' => $inventory->pendingBadges($branchSlug),
            'cards' => $inventory->dashboardCards($branchSlug),
            'inventory' => $inventory,
        ]);
    }

    public function transfer(Request $request, string $sourceSlug, string $targetSlug, InventoryService $inventory): View|RedirectResponse
    {
        try {
            $source = $inventory->branch($sourceSlug);
            $target = $inventory->branch($targetSlug);
        } catch (InvalidArgumentException) {
            abort(404);
        }

        if ($sourceSlug === $targetSlug) {
            abort(404);
        }

        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'id' => ['required', 'integer', 'min:1'],
                'jumlah_kirim' => ['required', 'integer', 'min:1', 'max:100000'],
            ]);

            try {
                $message = $inventory->transfer($sourceSlug, $targetSlug, (int) $validated['id'], (int) $validated['jumlah_kirim']);
                return back()->with('status', $message);
            } catch (RuntimeException $exception) {
                return back()->withErrors(['stok' => $exception->getMessage()])->withInput();
            }
        }

        return view('pages.action', [
            'mode' => 'transfer',
            'branch' => $source,
            'target' => $target,
            'peers' => $inventory->peers($sourceSlug),
            'badges' => $inventory->pendingBadges($sourceSlug),
            'items' => $inventory->actionItems($sourceSlug),
            'title' => "Kirim ke {$target['short']}",
            'subtitle' => "Distribusi stok dari {$source['short']} ke {$target['short']}.",
            'submitLabel' => 'Kirim Stok',
            'inventory' => $inventory,
        ]);
    }

    public function movement(Request $request, string $branchSlug, string $type, InventoryService $inventory): View|RedirectResponse
    {
        $branch = $inventory->branch($branchSlug);
        $purpose = $type === 'penjualan' ? 'Penjualan' : 'Rusak';

        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'id' => ['required', 'integer', 'min:1'],
                'jumlah_kirim' => ['required', 'integer', 'min:1', 'max:100000'],
            ]);

            try {
                $message = $inventory->reduceForPurpose($branchSlug, $purpose, (int) $validated['id'], (int) $validated['jumlah_kirim']);
                return back()->with('status', $message);
            } catch (RuntimeException $exception) {
                return back()->withErrors(['stok' => $exception->getMessage()])->withInput();
            }
        }

        return view('pages.action', [
            'mode' => $type,
            'branch' => $branch,
            'target' => null,
            'peers' => $inventory->peers($branchSlug),
            'badges' => $inventory->pendingBadges($branchSlug),
            'items' => $inventory->actionItems($branchSlug),
            'title' => $purpose === 'Penjualan' ? 'Catat Penjualan' : 'Catat Rusak/Hilang',
            'subtitle' => $purpose === 'Penjualan'
                ? "Kurangi stok {$branch['short']} karena penjualan."
                : "Kurangi stok {$branch['short']} karena barang rusak atau hilang.",
            'submitLabel' => $purpose === 'Penjualan' ? 'Simpan Penjualan' : 'Simpan Rusak/Hilang',
            'inventory' => $inventory,
        ]);
    }

    public function receive(Request $request, string $branchSlug, string $sourceSlug, InventoryService $inventory): View|RedirectResponse
    {
        try {
            $branch = $inventory->branch($branchSlug);
            $source = $inventory->branch($sourceSlug);
        } catch (InvalidArgumentException) {
            abort(404);
        }

        if ($branchSlug === $sourceSlug) {
            abort(404);
        }

        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'nama' => ['required', 'string', 'max:100'],
            ]);

            try {
                $message = $inventory->confirmIncoming($branchSlug, $sourceSlug, $validated['nama']);
                return back()->with('status', $message);
            } catch (RuntimeException $exception) {
                return back()->withErrors(['stok' => $exception->getMessage()]);
            }
        }

        return view('pages.receive', [
            'branch' => $branch,
            'source' => $source,
            'peers' => $inventory->peers($branchSlug),
            'badges' => $inventory->pendingBadges($branchSlug),
            'items' => $inventory->pendingIncoming($branchSlug, $sourceSlug),
            'inventory' => $inventory,
        ]);
    }

    public function record(Request $request, string $branchSlug, InventoryService $inventory): View
    {
        $branch = $inventory->branch($branchSlug);
        $date = $request->query('tanggal');

        $request->validate([
            'tanggal' => ['nullable', 'date_format:Y-m-d'],
        ]);

        $data = $inventory->records($branchSlug, $date);

        return view('pages.record', [
            'branch' => $branch,
            'peers' => $inventory->peers($branchSlug),
            'badges' => $inventory->pendingBadges($branchSlug),
            'records' => $data['records'],
            'totals' => $data['totals'],
            'tanggal' => $date,
            'inventory' => $inventory,
        ]);
    }
}
