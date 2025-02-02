<?php

namespace Database\Seeders;

use App\Models\LeadSource;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeadSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sources = [
            'Outbound Call',
            'Inbound Call',
            'Website',
            'Live Chat',
        ];

        foreach ($sources as $source) {
            LeadSource::create(['name' => $source]);
        }
    }
}
