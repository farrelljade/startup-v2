<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Prospect;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProspectNotesController extends Controller
{
    public function index(Request $request)
    {
        $data = [];

        $data['prospect'] = Prospect::query()
            ->where('id', $request['prospect'])
            ->with(['tankSales', 'user', 'notes' => function($query) {
                $query->orderBy('created_at', 'desc');
            }, 'notes.user'])
            ->first();

        return Inertia::render('Prospects/ProspectNotes', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'note' => ['required', 'string'],
        ]);

        Note::create([
            'prospect_id' => $request->prospect_id,
            'user_id' => auth()->id(),
            'note' => $request->note,
        ]);

        return redirect()->route('prospect.notes', ['prospect' => $request->prospect_id]);
    }
}
