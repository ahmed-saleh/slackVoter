<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Add()
 * @method static static Remove()
 */
final class EventActions extends Enum
{
    const Add    =   'add';
    const Remove =   'remove';
}
