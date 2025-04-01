<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

trait HasCreatedBy {
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
    }
}