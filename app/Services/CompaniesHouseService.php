<?php

namespace App\Services;

use App\Models\SicCode;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CompaniesHouseService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.companies_house.api_key');
        $this->baseUrl = config('services.companies_house.base_url');
    }

    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function searchCompaniesByName($query)
    {
        $url = "{$this->baseUrl}/search/companies";

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode($this->apiKey . ':')
        ])->get($url, [
            'q' => $query,
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        $response->throw();
    }

    /**
     * @throws RequestException
     * @throws ConnectionException
     */
    public function getCompanyDetails($companyNumber)
    {
        try {
            $url = "{$this->baseUrl}/company/{$companyNumber}";

            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . base64_encode($this->apiKey . ':')
            ])->get($url);

            if ($response->successful()) {
                $companyData = $response->json();

                if (!empty($companyData['sic_codes'])) {
                    $descriptions = SicCode::whereIn('code', $companyData['sic_codes'])
                        ->pluck('description', 'code')
                        ->toArray();

                    $companyData['sic_descriptions'] = array_map(function($code) use ($descriptions) {
                        return $descriptions[$code] ?? 'Description not available';
                    }, $companyData['sic_codes']);
                }

                return $companyData;
            }

            $response->throw();
        } catch (\Exception $e) {
            Log::error('Company details error', [
                'message' => $e->getMessage(),
                'company_number' => $companyNumber
            ]);
            throw $e;
        }
    }

//    public function getCompanyDetails($companyNumber)
//    {
//        $url = "{$this->baseUrl}/company/{$companyNumber}";
//
//        $response = Http::withHeaders([
//            'Authorization' => 'Basic ' . base64_encode($this->apiKey . ':')
//        ])->get($url);
//
//        if ($response->successful()) {
//            return $response->json();
//        }
//
//        $response->throw();
//    }
}
