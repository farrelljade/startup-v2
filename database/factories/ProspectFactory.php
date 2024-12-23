<?php

namespace Database\Factories;

use App\Models\LeadSource;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Prospect>
 */
class ProspectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'company_name' => fake()->company(),
            'email' => fake()->email(),
            'phone' => fake()->phoneNumber('gb'),
            'line_1' => fake()->streetAddress(),
            'line_2' => fake()->optional()->streetAddress(),
            'city' => fake()->city(),
            'postal_code' => fake()->postcode(),
            'lead_source_id' => LeadSource::inRandomOrder()->value('id')
                ?? LeadSource::factory()->create()->id,
        ];
    }
}
