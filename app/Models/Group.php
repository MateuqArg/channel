<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Visitor;

class Group extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'exhibitor_id'];

    public function visitors()
    {
        return $this->belongsToMany(Visitor::class, 'group_visitor');
    }
}
