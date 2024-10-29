<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TransactionMail extends Model
{
    use HasFactory;
    protected $fillable = [
        'number',
        'regarding',
        'date',
        'sender',
        'sender_phone_number',
        'file_attachment',
        'status',
        'date_in',
        'agenda_id',
        'priority_id',
        'type_id',
        'user_id',
        'creator_id',
        'sincerely',
        'reply_note',
        'reply_file_attachment',
        'note',
    ];

    public function admin(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function agenda(): HasOne
    {
        return $this->hasOne(MailAgenda::class, 'id', 'agenda_id');
    }
    public function priority(): HasOne
    {
        return $this->hasOne(MailPriority::class, 'id', 'priority_id');
    }
    public function type(): HasOne
    {
        return $this->hasOne(MailType::class, 'id', 'type_id');
    }
}
