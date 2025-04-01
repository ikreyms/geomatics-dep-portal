<?php

namespace App\Actions\Atoll;

use App\Models\Atoll;

class StoreAtollAction
{
    public static function run(array $data): Atoll
    {
        $atoll = Atoll::create([
            'short_name' => $data['short_name'],
            'abbreviation' => $data['abbreviation'],
        ]);

        return $atoll;
    }
}