<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'publisher',
        'year',
        'img_url',
    ];

    public function events()
    {
        return $this->belongsToMany(Event::class)->withPivot('item_id', 'event_id');
    }
}
