<?php 

namespace App\Traits;

use Hashids\Hashids;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasHashid\HashidUtils;

trait HasHashidAndCreatedBy
{
    use HashidUtils;

    protected static ?Hashids $encoder = null;

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
            if (empty($model->hashid) && ! $model->isDirty('hashid')) {
                $model->hashid = $model->encodeHashid($model->{$model->getKeyName()});
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
    }
}
