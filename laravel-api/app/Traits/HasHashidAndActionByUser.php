<?php

namespace App\Traits;

use App\Services\IdEncoder;
use Hashids\Hashids;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasHashid\HashidUtils;

trait HasHashidAndActionByUser
{
    use HashidUtils;

    /**
     * Boot the trait to listen for the saved event on the model.
     * This ensures the `hashid` is generated when the model is saved.
     * Also, it assigns `created_by` during creation and `updated_by` during updates.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::saved(function (Model $model) {
            if (empty($model->{config('hashid.field')}) && ! $model->isDirty(config('hashid.field'))) {
                $model->{config('hashid.field')} = IdEncoder::encodeHashid($model->{$model->getKeyName()});
                $model->save();
            }
        });

        // Automatically assign 'created_by' during creation
        static::creating(function (Model $model) {
            $model->created_by = Auth::id(); // Auth::id() gets the currently authenticated user's ID
        });

        // Automatically update 'updated_by' during updates
        static::updating(function (Model $model) {
            $model->updated_by = Auth::id(); // Assumes you have an `updated_by` field in your table
        });

        // Automatically assign 'deleted_by' during deletion (soft delete or hard delete)
        static::deleted(function (Model $model) {
            if ($model->trashed()) {
                $model->deleted_by = Auth::id(); // Assign the currently authenticated user's ID when soft deleting
                $model->save();
            }
        });
    }
}
