<?php

namespace App\Models;

use App\Traits\HasHashid\HasHashid;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Atoll extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, HasHashid;
    
    protected $fillable = [
        'abbreviation',
        'short_name',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    public function islands(): HasMany 
    {
        return $this->hasMany(Island::class);
    }
}
