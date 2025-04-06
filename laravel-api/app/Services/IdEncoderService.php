<?php

namespace App\Services;

use Hashids\Hashids;
use InvalidArgumentException;

/**
 * Class IdEncoderService
 *
 * This service class provides utilities for encoding and decoding IDs using the Hashids library.
 * Hashids generates short, unique, and URL-safe hash strings based on integer values, which can be useful
 * for hiding sensitive data such as database IDs in URLs. The class includes methods for both encoding
 * an integer ID into a Hashid string and decoding a Hashid string back to its original integer ID.
 *
 * @package App\Services
 */
class IdEncoderService
{
    /**
     * The Hashids encoder instance.
     *
     * @var Hashids|null
     */
    private static ?Hashids $encoder = null;

    /**
     * Validate the Hashid configuration settings.
     *
     * This method checks whether the necessary configuration options for Hashids are properly set in the application.
     * It throws an exception if any required configuration option is missing or invalid.
     *
     * @throws \InvalidArgumentException If required configuration options are missing.
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
     * Initializes the Hashids encoder with the configured salt, length, and characters. If the encoder instance
     * hasn't been created yet, it will be instantiated here.
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
     * Get the singleton instance of the Hashids encoder.
     *
     * Returns the initialized Hashids encoder instance. If it hasn't been initialized yet, this method will
     * initialize it before returning it.
     *
     * @return \Hashids\Hashids The Hashids encoder instance.
     */
    public static function getInstance(): Hashids
    {
        static::initialize();
        return static::$encoder;
    }

    /**
     * Encode an integer ID into a Hashid.
     *
     * Converts the provided integer ID into a short, unique Hashid string using the Hashids encoder.
     * This is useful for obscuring database IDs when sharing links in URLs.
     *
     * @param  int  $id The integer ID to encode.
     * @return string The encoded Hashid.
     */
    public static function encodeHashid(int $id): string
    {
        return static::getInstance()->encode($id);
    }

    /**
     * Decode a Hashid into its original integer ID.
     *
     * Converts the given Hashid string back into its original integer ID. If the Hashid is invalid or malformed,
     * an exception will be thrown.
     *
     * @param  string  $hashid The Hashid to decode.
     * @return int|null The decoded integer ID, or null if decoding fails.
     *
     * @throws \InvalidArgumentException If the Hashid is invalid.
     */
    public static function decodeHashid(string $hashid): ?int
    {
        $decoded = static::getInstance()->decode($hashid);

        if (!$decoded) {
            throw new InvalidArgumentException('Invalid Hashid.');
        }

        return $decoded[0];
    }

    /**
     * Create and save a new model instance with a Hashid.
     *
     * Creates a new instance of the specified Eloquent model, assigns it a Hashid after saving it to the database,
     * and updates the model with the generated Hashid in the configured field.
     *
     * This method ensures that the model is saved first and then the generated Hashid is stored in the appropriate
     * field of the model.
     *
     * @param  string  $modelClass The class name of the Eloquent model.
     * @param  array   $modelData The data to create the new model.
     * @return void
     */
    public static function createNewModelWithHashid(string $modelClass, array $modelData): void
    {
        $model = new $modelClass($modelData);

        if ($model->save()) {
            $model->update([
                config('hashid.field') => static::encodeHashid($model->id),
            ]);
        }
    }
}
