<?php

namespace App\Models;

use App\Traits\HasHashidAndCreatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Atoll extends Model
{
    use HasFactory, HasHashidAndCreatedBy;
    
    protected $fillable = [
        'abbreviation',
        'short_name',
    ];
}
