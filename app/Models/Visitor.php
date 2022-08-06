<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Evento, Meeting, Track, Group, Response};

class Visitor extends Model
{
    use HasFactory;

    protected $fillable = ['custid', 'event_id', 'approved', 'vip', 'name', 'email', 'phone', 'company', 'charge', 'state', 'city'];

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

    public function tracks()
    {
        return $this->hasMany(Track::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_visitor');
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }
}
