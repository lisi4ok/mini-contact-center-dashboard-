<?php

namespace App\Traits;

trait ArrayableEnumeration
{
    public static function keys() : array
    {
        return array_column(self::cases(), 'name');
    }

    public static function values() : array
    {
        return array_column(self::cases(), 'value');
    }

    public static function array() : array
    {
        return array_combine(self::keys(), self::values());
    }

    public static function exists($case) : bool
    {
        return array_search($case, self::cases()) !== false;
    }

    public static function get($case)
    {
        $identifier = null;

        foreach (self::cases() as $key => $item) {
            if ($case === $item) {
                $identifier = $key;
            }
        }

        return self::values()[$identifier];
    }

}
