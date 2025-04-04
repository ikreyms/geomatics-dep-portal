<?php

namespace App\Traits\HasHashid;

use App\Services\IdEncoder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait HashidUtils
{
    /**
     * Define the field to be used for route model binding.
     * 
     * Returns the field name (usually 'hashid') that should be used
     * when performing route model binding.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return config('hashid.field', 'hashid');
    }

    /**
     * Get the model instance by hashid.
     * 
     * This method looks up a model by its hashid, decodes the hashid,
     * and returns the corresponding model instance.
     *
     * @param string $hash
     * @return Model|null
     */
    public static function findByHashid(string $hashid): ?Model
    {
        $id = IdEncoder::decodeHashid($hashid);
        if ($id) {
            return static::find($id);
        }
        return static::find($id) ?? null;
    }

    /**
     * Finds a model by the hashid or fails.
     * 
     * This method tries to find a model by its hashid. If no model is
     * found for the given hashid, it throws a `ModelNotFoundException`.
     *
     * @param string $hash
     * @return \Illuminate\Database\Eloquent\Model
     * @throws ModelNotFoundException if no model is found for the given hashid
     */
    public static function findByHashidOrFail(string $hashid): Model
    {
        $id = IdEncoder::decodeHashid($hashid);
        if (!$id) {
            throw new ModelNotFoundException('Model not found for the provided Hashid');
        }
        return static::findOrFail($id);
    }

    /**
     * Scope a query to get the model with the given hashid.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query The query builder instance.
     * @param string $hashid The hashid to filter the model by.
     * @return void
     */
    public function scopeOfHashid(Builder $query, string $hashid): void
    {
        $query->where(config('hashid.field'), $hashid);
    }
}
