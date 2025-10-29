<?php

namespace Database\Factories;

use App\Enums\InteractionTypes;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Interaction>
 */
class InteractionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'contact_id' => Contact::factory()->create(),
            'type' => fake()->randomElement(InteractionTypes::values()),
            'note' => fake()->words(nb: rand(1, 3), asText: true),
            'timestamp' => now(),
        ];
    }
}
