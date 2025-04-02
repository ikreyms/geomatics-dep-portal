<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

trait HasActionByUser {
    protected static function booted(): void
    {
        // Automatically assign 'created_by' during creation
        static::creating(function (Model $model) {
            $model->created_by = Auth::id(); // Auth::id() gets the currently authenticated user's ID
        });

        // Automatically update 'created_by' during updates (you can adjust this behavior as needed)
        static::updating(function ($model) {
            $model->updated_by = Auth::id(); // This assumes you have an `updated_by` field in your table
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