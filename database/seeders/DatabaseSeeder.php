<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Prospect;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//        Prospect::factory(100)->create();
//        Order::factory(500)->create();

        $this->call([
            TargetSeeder::class
        ]);

        $this->call([
            SicCodesTableSeeder::class,
        ]);
    }
}
