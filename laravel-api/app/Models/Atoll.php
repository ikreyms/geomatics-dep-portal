<?php

namespace App\Models;

use App\Traits\HasHashidAndCreatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atoll extends Model
{
    use HasFactory, HasHashidAndCreatedBy;
    
    protected $fillable = [
        'abbreviation',
        'short_name',
    ];
}
