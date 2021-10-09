<?php

namespace App\Models;

use App\Enums\EventStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Event
 *
 * @property string      $name   Event Name
 * @property Item        $items  HasManyRelationship with Items
 * @property EventStatus $status Event status
 *
 * @author Ahmed Saleh <a.s.alsalali@gmail.com>
 * @package App\Models
 */
class Event extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name',
        'items',
        'status'
    ];


    public function items()
    {
        return $this->belongsToMany(Item::class)
            ->withPivot('event_id', 'item_id', 'vote_count')
            ->orderBy('vote_count','desc');
    }
}
