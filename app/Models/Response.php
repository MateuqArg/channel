<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{Input, Visitor};

class Response extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['input_id', 'visitor_id', 'value'];

    public function input()
    {
        return $this->belongsTo(Input::class);
    }

    public function visitor()
    {
        return $this->belongsTo(Visitor::class);
    }
}
