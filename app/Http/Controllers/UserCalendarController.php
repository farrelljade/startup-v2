<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserCalendarController extends Controller
{
    public function index()
    {
        $data['notes'] = Note::query()
            ->with(['prospect', 'user'])
            ->where('next_contact_date', '=', now()->format('Y-m-d 00:00:00'))
            ->whereHas('user', function ($query) {
                $query->where('id', auth()->id());
            })
            ->orderBy('next_contact_date')
            ->get();

        return Inertia::render('User/UserCalendar', $data);
    }
}
