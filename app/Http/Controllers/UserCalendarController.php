<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserCalendarController extends Controller
{
    public function index(Request $request)
    {
        $data['notes'] = Note::query()
            ->with(['prospect', 'user'])
            ->where('note_complete', '=', false)
            ->whereHas('user', function ($query) {
                $query->where('id', auth()->id());
            })
            ->orderBy('next_contact_date')
            ->get();

        return Inertia::render('User/UserCalendar', $data);
    }

    public function search(Request $request)
    {
        $query = Note::query()
            ->with(['prospect', 'user']);

        if ($request->has('date_from') && !empty($request->get('date_from'))) {
            $query->whereDate('next_contact_date', '>=', $request->get('date_from'));
        }

        if ($request->has('date_to') && !empty($request->get('date_to'))) {
            $query->whereDate('next_contact_date', '<=', $request->get('date_to'));
        }

        $results = $query->orderBy('next_contact_date')->get();

        return response()->json($results);
    }

    public function update(Request $request, Note $note)
    {
        $request->validate([
            'note_complete' => ['required', 'boolean']
        ]);

        if ($note->user_id === auth()->id()) {
            $note->update(['note_complete' => $request->note_complete]);
        }

        return back();
    }
}
