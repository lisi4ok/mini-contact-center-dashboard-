<?php

namespace App\Enums;

use App\Traits\ArrayableEnumeration;

enum Sort: string
{
    use ArrayableEnumeration;

    case ASC = 'asc';
    case DESC = 'desc';
}
