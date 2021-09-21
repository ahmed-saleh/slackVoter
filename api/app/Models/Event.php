<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'vote_count',
        'items',
        'status'
    ];


    public function items()
    {
        return $this->belongsToMany(Item::class)->withPivot('event_id', 'item_id');
    }
}
