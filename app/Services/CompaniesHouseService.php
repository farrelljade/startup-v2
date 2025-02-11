<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class CompaniesHouseService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.companies_house.api_key');
        $this->baseUrl = config('services.companies_house.base_url');
    }

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

    public function advancedSearch(array $params)
    {
        $url = "{$this->baseUrl}/advanced-search/companies";

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode($this->apiKey . ':')
        ])->get($url, $params);

        if ($response->successful()) {
            return $response->json();
        }

        $response->throw();
    }

    // Helper method to get companies by SIC codes
    public function searchBySicCodes(array $sicCodes, array $additionalParams = [])
    {
        $params = array_merge([
            'sic_codes' => implode(',', $sicCodes),
            'size' => 20  // default page size
        ], $additionalParams);

        return $this->advancedSearch($params);
    }

    public function getCompanyProfile($companyNumber)
    {
        $url = "{$this->baseUrl}/company/{$companyNumber}";

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode($this->apiKey . ':')
        ])->get($url);

        if ($response->successful()) {
            return $response->json();
        }

        $response->throw();
    }
}
