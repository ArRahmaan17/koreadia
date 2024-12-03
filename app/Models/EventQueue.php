<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventQueue extends Model
{
    use HasFactory;

    protected $fillable = ['event_schedule_id', 'employee_id', 'request_broadcast', 'request_broadcasted_at', 'broadcast', 'broadcasted_at'];
}
