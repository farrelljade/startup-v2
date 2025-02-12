<?php

namespace Database\Seeders;

use App\Models\SicCode;
use Illuminate\Database\Seeder;

class SicCodesTableSeeder extends Seeder
{
    public function run()
    {
        $sicCodes = [
            ['code' => '46710', 'description' => 'Wholesale of solid, liquid and gaseous fuels and related products'],
            ['code' => '46711', 'description' => 'Wholesale of petroleum and petroleum products'],
            ['code' => '46719', 'description' => 'Wholesale of other fuels and related products'],
            ['code' => '47300', 'description' => 'Retail sale of automotive fuel in specialised stores'],
            ['code' => '49410', 'description' => 'Freight transport by road'],
            ['code' => '49420', 'description' => 'Removal services'],
            ['code' => '49500', 'description' => 'Transport via pipeline'],
            ['code' => '50200', 'description' => 'Sea and coastal freight water transport'],
            ['code' => '50400', 'description' => 'Inland freight water transport'],
            ['code' => '52101', 'description' => 'Operation of warehousing and storage facilities for water transport activities'],
            ['code' => '52102', 'description' => 'Operation of warehousing and storage facilities for air transport activities'],
            ['code' => '52103', 'description' => 'Operation of warehousing and storage facilities for land transport activities'],
            ['code' => '52211', 'description' => 'Operation of rail freight terminals'],
            ['code' => '52213', 'description' => 'Operation of bus and coach stations'],
            ['code' => '52219', 'description' => 'Other service activities incidental to land transportation'],
            ['code' => '52220', 'description' => 'Service activities incidental to water transportation'],
            ['code' => '52230', 'description' => 'Service activities incidental to air transportation'],
            ['code' => '52241', 'description' => 'Cargo handling for water transport activities'],
            ['code' => '52242', 'description' => 'Cargo handling for air transport activities'],
            ['code' => '52243', 'description' => 'Cargo handling for land transport activities'],
            ['code' => '52290', 'description' => 'Other transportation support activities'],
            ['code' => '35110', 'description' => 'Production of electricity'],
            ['code' => '35120', 'description' => 'Transmission of electricity'],
            ['code' => '35130', 'description' => 'Distribution of electricity'],
            ['code' => '35140', 'description' => 'Trade of electricity'],
            ['code' => '35210', 'description' => 'Manufacture of gas'],
            ['code' => '35220', 'description' => 'Distribution of gaseous fuels through mains'],
            ['code' => '35230', 'description' => 'Trade of gas through mains'],
            ['code' => '19201', 'description' => 'Mineral oil refining'],
            ['code' => '19209', 'description' => 'Other treatment of petroleum products (excluding petrochemicals manufacture)'],
            ['code' => '06100', 'description' => 'Extraction of crude petroleum'],
            ['code' => '06200', 'description' => 'Extraction of natural gas'],
            ['code' => '09100', 'description' => 'Support activities for petroleum and natural gas extraction'],
            ['code' => '20590', 'description' => 'Manufacture of other chemical products n.e.c.'],
            ['code' => '46120', 'description' => 'Agents involved in the sale of fuels, ores, metals and industrial chemicals'],
            ['code' => '46711', 'description' => 'Wholesale of petroleum and petroleum products'],
            ['code' => '46712', 'description' => 'Wholesale of solid fuels'],
            ['code' => '46713', 'description' => 'Wholesale of gaseous fuels'],
        ];

        foreach ($sicCodes as $sicCode) {
            SicCode::updateOrCreate(
                ['code' => $sicCode['code']],
                ['description' => $sicCode['description']]
            );
        }
    }
}
