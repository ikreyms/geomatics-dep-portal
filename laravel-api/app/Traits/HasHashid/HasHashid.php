<?php

namespace App\Traits\HasHashid;

use App\Services\IdEncoder;
use App\Traits\HasHashid\HashidUtils;
use Illuminate\Database\Eloquent\Model;

trait HasHashid
{
    use HashidUtils;

    /**
     * Boot the trait to listen for the saved event on the model.
     * This ensures the `hashid` is generated when the model is saved.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::saved(function (Model $model) {
            if (empty($model->hashid) && ! $model->isDirty('hashid')) {
                $model->hashid = IdEncoder::encodeHashid($model->{$model->getKeyName()});
                $model->save();
            }
        });
    }
}
