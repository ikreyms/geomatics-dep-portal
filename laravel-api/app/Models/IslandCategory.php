<?php

namespace App\Models;

use App\Traits\HasHashidAndActionByUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class IslandCategory extends Model
{
    use HasFactory, HasHashidAndActionByUser, SoftDeletes;

    protected $fillable = [
        'name'
    ];

    public function islands(): HasMany
    {
        return $this->hasMany(Island::class);
    }
}
