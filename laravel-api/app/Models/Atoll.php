<?php

namespace App\Models;

use App\Traits\HasHashidAndCreatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Atoll extends Model
{
    use HasFactory, HasHashidAndCreatedBy;
    
    protected $fillable = [
        'abbreviation',
        'short_name',
    ];

    public function islands(): HasMany 
    {
        return $this->hasMany(Island::class);
    }
}
