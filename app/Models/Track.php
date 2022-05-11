<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Visitor, Talk};

class Track extends Model
{
    use HasFactory;

    protected $fillable = ['visitor_id', 'talk_id', 'extra'];

    public function visitor()
    {
        return $this->belongsTo(Visitor::class);
    }

    public function talk()
    {
        return $this->belongsTo(Talk::class);
    }
}
