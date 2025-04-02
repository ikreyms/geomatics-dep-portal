<?php

namespace App\Models;

use App\Traits\HasHashidAndCreatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IslandCategory extends Model
{
    use HasFactory, HasHashidAndCreatedBy;
    
    protected $fillable = [
        'name'
    ];
}
