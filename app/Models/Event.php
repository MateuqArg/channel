<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Visitor;
use App\Models\User;
use App\Models\Talk;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['custid', 'title', 'date', 'inscription', 'approve'];

    public function visitors()
    {
        return $this->hasMany(Visitor::class);
    }

    public function talks()
    {
        return $this->hasMany(Talk::class);
    }
}
