<?php

namespace App\Facades;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\Facade;
use App\DataTable\Builder;

/**
 * @method static EloquentBuilder|QueryBuilder make()
 * @method static \App\DataTable\Builder query(EloquentBuilder|QueryBuilder $query)
 * @method static \App\DataTable\Builder with(array $relationship)
 * @method static \App\DataTable\Builder searchable(array $searchable)
 * @method static \App\DataTable\Builder applyFilters(array $filters)
 * @method static \App\DataTable\Builder allowedFilters(array $allowedFilters)
 * @method static \App\DataTable\Builder applySort(string $sort)
 * @method static \App\DataTable\Builder allowedSorts(array $allowedSorts)
 * @method static \App\DataTable\Builder type(string $type)
 * @method static \App\DataTable\Builder orderBy(string $column = 'created_at', string $direction = 'asc')
 * @method static \App\DataTable\Builder perPage(int $limit)
 *
 * @see \App\DataTable\Builder
 */
class DataTable extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Builder::class;
    }
}
