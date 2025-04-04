<?php

namespace App\Services;

use Hashids\Hashids;
use InvalidArgumentException;

class IdEncoder
{
    /**
     * The Hashids encoder instance.
     *
     * @var Hashids|null
     */
    private static ?Hashids $encoder = null;

    /**
     * Validate the Hashid configuration.
     *
     * @throws \InvalidArgumentException
     * @return void
     */
    private static function validateConfig(): void
    {
        if (!config('hashid.salt') || !config('hashid.length') || !config('hashid.chars')) {
            throw new InvalidArgumentException('Missing Hashid configuration.');
        }
    }

    /**
     * Initialize the Hashids encoder instance.
     *
     * @return void
     */
    private static function initialize(): void
    {
        static::validateConfig();

        if (static::$encoder === null) {
            static::$encoder = new Hashids(
                config('hashid.salt'),
                config('hashid.length'),
                config('hashid.chars')
            );
        }
    }

    /**
     * Get the Hashids encoder instance.
     *
     * @return \Hashids\Hashids
     */
    public static function getInstance(): Hashids
    {
        static::initialize();
        return static::$encoder;
    }

    /**
     * Encode an ID into a Hashid.
     *
     * This method encodes the given ID using the Hashids library to generate
     * a short, unique, and URL-safe hash string.
     *
     * @param  int  $id
     * @return string
     */
    public static function encodeHashid(int $id): string
    {
        return static::getInstance()->encode($id);
    }

    /**
     * Decode a Hashid into its original ID.
     *
     * This method decodes the given hash string into the original ID. If the
     * hash string is invalid, an exception will be thrown.
     *
     * @param  string  $hashid
     * @return int|null
     *
     * @throws \InvalidArgumentException
     */
    public static function decodeHashid(string $hashid): ?int
    {
        $decoded = IdEncoder::getInstance()->decode($hashid);

        if (!$decoded) {
            throw new InvalidArgumentException('Invalid Hashid.');
        }

        return $decoded[0];
    }
}
