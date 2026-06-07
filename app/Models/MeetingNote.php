<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetingNote extends Model
{
    protected $fillable = [
        'meeting_title',
        'content',
    ];
}
