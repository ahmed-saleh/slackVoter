<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Active()
 * @method static static Inactive()
 */
final class EventStatus extends Enum
{
    const Active   =   1;
    const Inactive =   0;

}

