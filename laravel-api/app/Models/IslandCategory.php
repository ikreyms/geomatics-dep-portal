<?php

namespace App\Models;

use App\Traits\HasHashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IslandCategory extends Model
{
    use HasFactory, HasHashid;
    
    protected $fillable = [
        'name'
    ];
}
