<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Island extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    
    protected $fillable = [
        'f_code',
        'atoll_id',
        'name',
        'area_sqm',
        'island_category_id',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    public function atoll(): BelongsTo
    {
        return $this->belongsTo(Atoll::class);
    }

    public function islandCategory(): BelongsTo
    {
        return $this->belongsTo(IslandCategory::class);
    }
}
