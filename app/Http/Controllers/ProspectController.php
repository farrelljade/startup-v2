<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProspectStoreRequest;
use App\Models\Address;
use App\Models\Contact;
use App\Models\LeadSource;
use App\Models\Prospect;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ProspectController extends Controller
{
    public function index()
    {
        $data = [];

        $data['prospects'] = Prospect::query()
            ->with(['user:id,name', 'leadSource:id,name'])
            ->select(['id', 'company_name', 'user_id', 'lead_source_id', 'created_at', 'status'])
            ->where('status', '=', 'prospect')
            ->orderBy('created_at', 'desc')
            ->get();
        $data['users'] = User::all();
        $data['leadSource'] = LeadSource::all();

        return Inertia::render('Prospects/ProspectsPage', $data);
    }

    public function store(ProspectStoreRequest $request)
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated) {
            $prospect = Prospect::create([
                'user_id' => $validated['user_id'],
                'company_name' => $validated['company_name'],
                'lead_source_id' => $validated['lead_source_id'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'line_1' => $validated['line_1'],
                'line_2' => $validated['line_2'],
                'line_3' => $validated['line_3'],
                'city' => $validated['city'],
                'county' => $validated['county'],
                'postal_code' => $validated['postal_code'],
                'status' => 'prospect'
            ]);

            $contact = new Contact([
                'contact_email' => $validated['email'],
                'contact_name' => $validated['contact_name'],
                'contact_role' => $validated['contact_role'],
                'contact_phone' => $validated['phone']
            ]);
            $contact->prospect_id = $prospect->id;
            $contact->save();

            $address = new Address([
                'line_1' => $validated['line_1'],
                'line_2' => $validated['line_2'],
                'line_3' => $validated['line_3'],
                'city' => $validated['city'],
                'county' => $validated['county'],
                'postal_code' => $validated['postal_code']
            ]);
            $address->prospect_id = $prospect->id;
            $address->save();
        });
    }

    public function search(Request $request)
    {
        $query = Prospect::query()
            ->with(['user', 'leadSource']);

        if ($request->has('company_name') && !empty($request->get('company_name'))) {
            $query->where('company_name', 'LIKE', '%' . $request->get('company_name') . '%');
        }

        $results = $query->orderBy('created_at', 'desc')->get();

        return response()->json($results);
    }
}
