<?php

namespace App\Services;

use Hashids\Hashids;
use InvalidArgumentException;

/**
 * Class IdEncoder
 *
 * A utility class for encoding and decoding IDs using Hashids. This class
 * provides methods to transform integers into short, unique, and URL-safe
 * hash strings, as well as to decode them back to their original values.
 *
 * @package App\Services
 */
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
     * Ensures that the necessary configuration options for Hashids
     * are set. Throws an exception if any are missing.
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
     * Sets up the Hashids encoder using the configuration values
     * specified in the application.
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
     * Returns the initialized Hashids encoder instance. If it hasn't been
     * initialized yet, this method will initialize it.
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
     * Converts the given integer ID into a Hashid string using the
     * Hashids library.
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
     * Converts the given Hashid string back into the original integer
     * ID. Throws an exception if the Hashid is invalid.
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

    /**
     * Create a new model instance with a Hashid.
     *
     * Creates and saves a new instance of the specified Eloquent model class,
     * assigns it a Hashid, and updates the Hashid field in the database.
     *
     * @param  string  $modelClass
     * @param  array  $modelData
     * @return void
     */
    public static function createNewModelWithHashid(string $modelClass, array $modelData): void
    {   
        $model = new $modelClass($modelData);

        if ($model->save()) {
            $model->update([
                config('hashid.field') => IdEncoder::encodeHashid($model->id),
            ]);
        }
    }
}
