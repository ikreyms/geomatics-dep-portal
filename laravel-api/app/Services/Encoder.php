<?php

namespace App\Services;

use Hashids\Hashids;

class Encoder {

    protected static ?Hashids $encoder = null;

    public static function getInstance(): Hashids
    {
        if (static::$encoder === null) {
            static::$encoder = new Hashids(
                config('hashid.salt'),
                config('hashid.length'),
                config('hashid.chars')
            );
        }

        return static::$encoder;
    }
}
