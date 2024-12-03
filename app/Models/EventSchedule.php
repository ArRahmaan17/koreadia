<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventSchedule extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'date', 'recipient', 'file_attachment', 'user_id'];

    public function agendas(): HasMany
    {
        return $this->hasMany(DetailEventSchedule::class, 'event_schedule_id', 'id');
    }
}
