<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event;
use App\Models\Talk;

class Talk extends Model
{
    use HasFactory;

    protected $fillable = ['custid', 'event_id', 'exhibitor_id', 'title'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function exhibitor()
    {
        return $this->belongsTo(User::class);
    }
}
