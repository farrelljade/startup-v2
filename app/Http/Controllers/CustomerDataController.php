<?php

namespace App\Http\Controllers;

use App\Services\CompaniesHouseService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerDataController extends Controller
{
    protected CompaniesHouseService $companiesHouseService;

    public function __construct(CompaniesHouseService $companiesHouseService)
    {
        $this->companiesHouseService = $companiesHouseService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Admin/CustomerDataPage');
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        try {
            $companies = $this->companiesHouseService->searchCompaniesByName($query);
            return response()->json($companies, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function advancedSearch(Request $request)
    {
        try {
            $params = $request->validate([
                'sic_codes' => 'nullable|array',
                'company_name_includes' => 'nullable|string',
                'company_status' => 'nullable|string',
                'size' => 'nullable|integer|min:1|max:5000',
                'start_index' => 'nullable|integer|min:0',
            ]);

            $results = $this->companiesHouseService->advancedSearch($params);

            return response()->json($results);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch company data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
