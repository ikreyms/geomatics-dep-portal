<?php

namespace App\Models;

use App\Traits\HasActionByUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Island extends Model
{
    use HasFactory, HasActionByUser, SoftDeletes;
    
    protected $fillable = [
        'f_code',
        'atoll_id',
        'name',
        'area_sqm',
        'island_category_id',
    ];

    public function atoll(): BelongsTo
    {
        return $this->belongsTo(Atoll::class);
    }

    public function islandCategory(): BelongsTo
    {
        return $this->belongsTo(IslandCategory::class);
    }
}
