<?php

namespace App\Enums;

use App\Traits\ArrayableEnumeration;

enum InteractionTypes: string
{
    use ArrayableEnumeration;

    case CLICK = 'click';
    case HOVER = 'hover';
    case SCROLL = 'scroll';
    case KEYBOARD = 'keyboard';
    case SWIPE  = 'swipe';
}
