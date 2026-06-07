<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetingSchedule extends Model
{
    protected $fillable = [
        'title',
        'agenda',
        'location',
        'meeting_date',
    ];

    protected $casts = [
        'meeting_date' => 'datetime',
    ];
}
