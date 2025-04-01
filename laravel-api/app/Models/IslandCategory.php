<?php

namespace App\Models;

use App\Traits\HasHashidAndCreatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IslandCategory extends Model
{
    use HasFactory, HasHashidAndCreatedBy;
    
    protected $fillable = [
        'name'
    ];
}
