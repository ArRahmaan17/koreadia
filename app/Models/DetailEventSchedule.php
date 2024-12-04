<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailEventSchedule extends Model
{
    protected $fillable = [
        'event_schedule_id',
        'name',
        'speaker',
        'location',
        'time',
        'online',
        'meeting',
    ];
    use HasFactory;
}
