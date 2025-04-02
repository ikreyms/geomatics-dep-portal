<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasHashidAndActionByUser;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Atoll extends Model
{
    use HasFactory, HasHashidAndActionByUser, SoftDeletes, LogsActivity;
    
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
