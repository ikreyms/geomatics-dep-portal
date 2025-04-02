<?php

namespace App\Models;

use App\Traits\HasHashid\HasHashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeatureCodeFormat extends Model
{
    use HasFactory, HasHashid;
    
    protected $fillable = [
        'name',
        'format',
    ];
}
