<?php

namespace App\Traits\DataTable;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

trait HasRelationsTrait
{
    protected array $relationship = [];

    protected function relations(): EloquentBuilder|QueryBuilder
    {
        $query = $this->query;

        if (!empty($this->relationship)) {
            $query->with($this->relationship);
        }

        return $query;
    }
}
