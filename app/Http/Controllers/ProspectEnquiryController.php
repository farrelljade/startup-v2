<?php

namespace App\Http\Controllers;

use App\Models\Prospect;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProspectEnquiryController extends Controller
{
    public function index(Prospect $prospect)
    {
        $data = [];

        $prospect->load(['user', 'leadSource'])->toArray();

        $data['prospect'] = $prospect;

        return Inertia::render('Prospects/ProspectProfile', $data);
    }
}
