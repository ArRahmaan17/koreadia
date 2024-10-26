<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappQueue extends Model
{
    use HasFactory;
    protected $fillable = [
        'transaction_mail_id',
        'current_status',
        'last_status',
        'notified',
        'user_id',
        'request_notified',
        'request_notified_at'
    ];
}
