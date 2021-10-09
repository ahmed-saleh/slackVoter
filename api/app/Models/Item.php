<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Item
 *
 * @property string $name      item name
 * @property string $publisher item publisher name
 * @property string $year      the year the item was published
 * @property string $img_url   item image url
 *
 * @author Ahmed Saleh <a.s.alsalali@gmail.com>
 * @package App\Models
 */
class Item extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

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
