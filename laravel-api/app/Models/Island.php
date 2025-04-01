<?php

namespace App\Models;

use App\Traits\HasHashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Island extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'f_code',
        'atoll_id',
        'name',
        'area_sqm',
        'island_category_id',
    ];
}
