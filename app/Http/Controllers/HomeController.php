<?php

namespace App\Http\Controllers;

use App\Services\InventoryService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(InventoryService $inventory): View
    {
        return view('pages.home', [
            'branches' => $inventory->branches(),
            'inventory' => $inventory,
        ]);
    }
}
