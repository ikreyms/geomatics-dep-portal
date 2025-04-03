<?php

namespace App\Actions\Atoll;

use App\Models\Atoll;
use App\Contracts\ControllerAction;

class StoreAtollAction implements ControllerAction
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