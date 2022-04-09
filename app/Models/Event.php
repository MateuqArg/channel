<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Visitor;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['custid', 'title', 'date', 'inscription', 'approve'];

    public function visitors()
    {
        return $this->hasMany(Visitor::class);
    }
}
