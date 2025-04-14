<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\PlateRequestStatus;
use App\Models\User;
use Database\Factories\ClientFactory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        
        $plateRequestStatuses = ['pending', 'approved', 'plates_issued', 'rejected', 'expired'];

        Client::factory(15)->create();

        foreach ($plateRequestStatuses as $status) {
            PlateRequestStatus::create([
                'name' => $status,
            ]);
        }
        
    }
}
