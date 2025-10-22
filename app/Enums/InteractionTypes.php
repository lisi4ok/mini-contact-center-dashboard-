<?php

namespace App\Enums;

enum InteractionTypes: string
{
    case CLICK = 'click';
    case HOVER = 'hover';
    case SCROLL = 'scroll';
    case KEYBOARD = 'keyboard';
    case DRAG_AND_DROP = 'drag and drop';
    case SWIPE  = 'swipe';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
