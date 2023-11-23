<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_name', 'event_title', 'start_date', 'end_date', 'event_url',
        'status', 'user_name', 'password', 'viewer_instructions', 'presentation_url',
        'number_of_breakouts', 'logo',
    ];

    public function breakouts()
    {
        return $this->hasMany(Breakout::class);
    }
}
