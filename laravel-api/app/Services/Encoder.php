<?php

namespace App\Services;

use Hashids\Hashids;
use InvalidArgumentException;

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

    /**
     * Encode the model's ID (or any other field) using Hashids.
     * 
     * This method takes an ID and encodes it using the Hashids library
     * to create a short, URL-safe hashid.
     *
     * @param  int $id
     * @return string
     */
    public static function encodeHashid(int $id): string
    {
        return Encoder::getInstance()->encode($id);
    }

    /**
     * Decode the hashid to retrieve the original ID.
     * 
     * This method decodes a given hashid and returns the corresponding
     * model's ID. If the hashid is invalid, an exception is thrown.
     *
     * @param  string $hashid
     * @return int|null
     * @throws InvalidArgumentException if the hashid is invalid
     */
    public static function decodeHashid(string $hashid): ?int
    {
        $decoded = Encoder::getInstance()->decode($hashid);
        if (!$decoded) {
            throw new InvalidArgumentException('Invalid Hashid');
        }
        return $decoded[0];
    }
}
