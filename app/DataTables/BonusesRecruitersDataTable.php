<?php

namespace App\DataTables;

use App\Enums\Currency;
use App\Enums\Position;
use App\Models\Person;
use Illuminate\Support\Facades\DB;

class BonusesRecruitersDataTable extends BonusesDataTableAbstract
{
    public const COLUMNS = [
        'recruiter',
        'bonus',
        'total',
    ];

    /**
     * BonusesDataTable constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->positionId = Position::Recruiter;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Person $model
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Person $model)
    {
        $query = $model->newQuery();

        $query->select('people.id', 'people.name', 'people.bonuses_reward');

        $this->addMonthsSelect($query);
        $this->addTotalSelect($query);

        $monthsQuery = DB::table('people');
        $monthsQuery->select('recruiter_id');

        $this->addMonthsSubSelect($monthsQuery);
        $this->addTotalSubSelect($monthsQuery);

        $monthsQuery->groupBy('recruiter_id');

        $query->leftJoinSub($monthsQuery, 'hired', static function($join) {
            $join->on('hired.recruiter_id', '=', 'people.id');
        });

        $query->isBonuses();
        $query->where('people.position_id', Position::Recruiter);
        $query->whereNull('people.deleted_at');
        $query->where(function ($query) {
            $query->whereNull('people.quited_at');
            $query->orWhereYear('quited_at', $this->year);
        });
        $query->whereYear('people.start_date', '<=', $this->year);

        $query->groupBy('people.name');
        $query->orderBy('people.name');

        return $query;
    }

    /**
     * Add months select
     *
     * @param $query
     *
     * @throws \Carbon\Exceptions\InvalidFormatException
     */
    protected function addMonthsSelect($query): void
    {
        foreach($this->period() as $month) {
            $monthName = strtolower($month->monthName);

            $monthQuery = [];
            foreach (Currency::asArray() as $currency) {
                $monthQuery[$currency] = [
                    "',IFNULL(hired.{$monthName}_first_{$currency}/100*(people.bonuses_reward/2),0),'",
                    "',IFNULL(hired.{$monthName}_second_{$currency}/100*(people.bonuses_reward/2),0),'"
                ];
            }
            $concatJson = json_encode($monthQuery, JSON_UNESCAPED_SLASHES);
            $query->selectRaw("group_concat(concat('{$concatJson}')) as {$monthName}");
        }
    }

    /**
     * Add months sub select
     *
     * @param $query
     *
     * @throws \Carbon\Exceptions\InvalidFormatException
     */
    protected function addMonthsSubSelect($query): void
    {
        foreach($this->period() as $month) {
            $monthName = strtolower($month->monthName);

            foreach (Currency::asArray() as $currency) {
                $query->selectRaw("sum(case when month(start_date)={$month->month} and
                                                year(start_date)='{$this->year}' and
                                                currency='{$currency}' then salary end) as {$monthName}_first_{$currency}");

                $query->selectRaw("sum(case when
                                     month(date_add(date_add(start_date, interval 2 month), interval 1 day))={$month->month} and
                                     year(date_add(date_add(start_date, interval 2 month), interval 1 day))='{$this->year}' and
                                     currency='{$currency}' and (TIMESTAMPDIFF(MONTH, start_date, quited_at) >= 2 or quited_at IS NULL) then salary end) as
                                     {$monthName}_second_{$currency}");
            }
        }
    }

    /**
     * Add total select
     *
     * @param $query
     */
    protected function addTotalSelect($query): void
    {
        $totalQuery = [];
        foreach (Currency::asArray() as $currency) {
            $totalQuery[$currency] = [
                "',IFNULL(hired.total_first_{$currency}/100*(people.bonuses_reward/2),0),'",
                "',IFNULL(hired.total_second_{$currency}/100*(people.bonuses_reward/2),0),'"
            ];
        }
        $concatJson = json_encode($totalQuery, JSON_UNESCAPED_SLASHES);
        $query->selectRaw("group_concat(concat('{$concatJson}')) as total");
    }

    /**
     * Add total sub select
     *
     * @param $query
     */
    protected function addTotalSubSelect($query): void
    {
        foreach (Currency::asArray() as $currency) {
            $query->selectRaw("sum(case when
                                    year(start_date)='{$this->year}' and
                                     currency='{$currency}' then salary end) as total_first_{$currency}");
            $query->selectRaw("sum(case when
                                year(date_add(date_add(start_date, interval 2 month), interval 1 day))='{$this->year}' and
                                currency='{$currency}' and
                                (TIMESTAMPDIFF(MONTH, start_date, quited_at) >= 2 or quited_at IS NULL) then salary end) as total_second_{$currency}");
        }
    }
}
