<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event;

class Inscription extends Model
{
    use HasFactory;

    protected $fillable = ['custid', 'event_id', 'approved', 'name', 'surname', 'email', 'phone', 'charge', 'company', 'city', 'state', 'country'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
