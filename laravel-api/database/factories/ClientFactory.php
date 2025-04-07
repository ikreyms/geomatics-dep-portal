<?php

namespace Database\Factories;

use App\Models\Client;
use App\Services\IdEncoderService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Client $client) {
            $client->hashid = IdEncoderService::encodeHashid($client->id);
            $client->save();
        });
    }

}
