<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Prospect;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProspectNotesController extends Controller
{
    public function index(Prospect $prospect)
    {
        $data = [];

        $prospect->load(['user', 'notes'])->toArray();

        $data['prospect'] = $prospect;

        return Inertia::render('Prospects/ProspectNotes', $data);
    }
}
