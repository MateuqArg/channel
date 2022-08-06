<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Visitor, User, Talk, Meeting, Email, Input};

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['custid', 'title', 'date', 'inscription', 'approve', 'spread', 'qrfile'];

    public function visitors()
    {
        return $this->hasMany(Visitor::class);
    }

    public function talks()
    {
        return $this->hasMany(Talk::class);
    }

    public function meetings()
    {
        return $this->hasMany(Meeting::class);
    }

    public function emails()
    {
        return $this->hasMany(Email::class);
    }

    public function inputs()
    {
        return $this->belongsToMany(Input::class);
    }

}
