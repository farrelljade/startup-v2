<?php

namespace App\Http\Controllers;

use App\Models\Prospect;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProspectController extends Controller
{
    public function index()
    {
        $data = [];

        $data['prospects'] = Prospect::query()
            ->with(['user', 'leadSource'])
            ->get();

        return Inertia::render('Prospects/ProspectsPage', $data);
    }

    public function show(Prospect $prospect)
    {
        $data = [];

        $data['prospect'] = $prospect;

        return Inertia::render('Prospects/ProspectProfile', $data);
    }
}
