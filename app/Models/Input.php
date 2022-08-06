<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event;

class Input extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'name', 'label', 'options'];

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }

    // public function responses()
    // {
    //     return $this->belongsTo(Event::class);
    // }
}
