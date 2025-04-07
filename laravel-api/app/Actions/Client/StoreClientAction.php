<?php

namespace App\Actions\Client;

use App\Contracts\ControllerAction;
use App\Models\Client;

class StoreClientAction implements ControllerAction
{
    public static function handle(array $data)
    {
        $client = Client::create([
            'name' => strtolower($data['name']),
        ]);

        return $client;
    }
}