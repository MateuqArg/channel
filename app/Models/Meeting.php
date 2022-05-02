<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event;
use App\Models\Visitor;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = ['custid', 'event_id', 'visitor_id', 'exhibitor', 'approved', 'requested'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function visitor()
    {
        return $this->belongsTo(Visitor::class);
    }
}
