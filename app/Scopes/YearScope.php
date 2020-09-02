<?php


namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class YearScope implements Scope
{
    private $year;

    /**
     * YearScope constructor.
     * @param $year
     */
    public function __construct($year)
    {
        $this->year = $year;
    }

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->select("{$model->getTable()}.*")
            ->join('calendar_years', 'calendar_years.id', '=', "{$model->getTable()}.calendar_year_id")
            ->where('calendar_years.name', $this->year);
    }
}
