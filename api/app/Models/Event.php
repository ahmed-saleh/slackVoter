<?php

namespace App\Models;

use App\Enums\EventStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Event
 *
 * @property string $name
 * @property int vote_count
 * @property Item items
 * @property EventStatus status
 *
 * @package App\Models
 */
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
