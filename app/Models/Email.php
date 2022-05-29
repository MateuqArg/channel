<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'subject', 'content', 'date', 'event_id', 'objective'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
