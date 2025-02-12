<?php

namespace App\Http\Controllers;

use App\Models\SicCode;
use App\Services\CompaniesHouseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

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
    public function index(): Response
    {
        return Inertia::render('Admin/CustomerDataPage');
    }

    public function search(Request $request): JsonResponse
    {
        $query = $request->input('q');
        try {
            $searchResults = $this->companiesHouseService->searchCompaniesByName($query);

            $companies = array_map(function($company) {
                try {
                    $details = $this->companiesHouseService->getCompanyDetails($company['company_number']);

                    $sicCodes = $details['sic_codes'] ?? [];
                    $sicDescriptions = SicCode::whereIn('code', $sicCodes)
                        ->pluck('description', 'code')
                        ->toArray();

                    $formattedSicCodes = array_map(function($code) use ($sicDescriptions) {
                        return [
                            'code' => $code,
                            'description' => $sicDescriptions[$code] ?? 'Description not available'
                        ];
                    }, $sicCodes);

                    return array_merge($company, [
                        'sic_codes' => $formattedSicCodes
                    ]);
                } catch (\Exception $e) {
                    return array_merge($company, [
                        'sic_codes' => []
                    ]);
                }
            }, $searchResults['items']);

            return response()->json(['items' => $companies], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

//    public function search(Request $request): JsonResponse
//    {
//        $query = $request->input('q');
//        try {
//            $companies = $this->companiesHouseService->searchCompaniesByName($query);
//            return response()->json($companies, 200);
//        } catch (\Exception $e) {
//            return response()->json(['error' => $e->getMessage()], 500);
//        }
//    }

//    public function getCompany($companyNumber): JsonResponse
//    {
//        try {
//            $details = $this->companiesHouseService->getCompanyDetails($companyNumber);
//            return response()->json($details);
//        } catch (\Exception $e) {
//            return response()->json([
//                'error' => 'Failed to fetch company details'
//            ], 500);
//        }
//    }

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
