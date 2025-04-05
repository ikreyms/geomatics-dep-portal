<?php

namespace App\Models;

use App\Traits\HasHashidAndActionByUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class StaffProfile extends Model
{
    use HasFactory, HasHashidAndActionByUser, SoftDeletes, LogsActivity;

    protected $fillable = [
        // Add fillable attributes here
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    public function user()
    {
        return $this->morphOne(User::class, 'profile');
    }
}
