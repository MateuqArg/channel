<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event;
use App\Models\Meeting;

class Visitor extends Model
{
    use HasFactory;

    protected $fillable = ['custid', 'event_id', 'form_id', 'approved', 'vip'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'visitor_id');
    }

    public function meetings()
    {
        return $this->hasMany(Meeting::class);
    }
}
