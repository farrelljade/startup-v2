<?php

namespace Database\Seeders;

use App\Models\Target;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TargetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            'prospects',
            'rejuves',
            'profit',
            'iho',
            'lubricants'
        ];

        foreach ($types as $type) {
            Target::create(['type' => $type]);
        }
    }
}
