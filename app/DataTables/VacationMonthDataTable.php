<?php

namespace App\DataTables;

use App\Enums\DayType;
use App\Enums\VacationPaymentType;
use App\Enums\VacationType;
use App\Models\Holiday;
use App\Models\Person;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Services\DataTable;

class VacationMonthDataTable extends DataTable
{
    private $year;
    private $month;
    private $holidays;

    /**
     * VacationMonthDataTable constructor.
     *
     * @param $year
     * @param $month
     *
     * @throws \Carbon\Exceptions\InvalidFormatException
     */
    public function __construct($year, $month)
    {
        $this->year = $year;
        $this->month = $month;
        $this->holidays = $this->fetchHolidays();
    }

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     *
     * @return \Yajra\DataTables\DataTableAbstract
     * @throws \Carbon\Exceptions\InvalidFormatException
     */
    public function dataTable($query)
    {
        $eloquent = datatables()
            ->eloquent($query)
            ->addColumn('name', function(Person $model) {
                return $model->payment === VacationPaymentType::Paid ? view('partials.view-link', ['model' => $model]) : '';
            })
            ->addColumn('compensate', function(Person $model) {
                $date = Carbon::createFromDate($this->year, $this->month)->startOfMonth();
                $startedDate = Carbon::parse($model->start_date)->setYear($this->year)->startOfMonth();
                if ($date < $startedDate || $startedDate->diffInMonths($date) > 2) {
                    return false;
                }

                return $model->compensate;
            });

        $this->addDayColumns($eloquent);

        return $eloquent;
    }

    /**
     * Get query source of dataTable.
     *
     * @param Person $model
     *
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws \Carbon\Exceptions\InvalidFormatException
     */
    public function query(Person $model)
    {
        $paidVacations = DB::table('vacations')
            ->select('person_id')
            ->where('payment_type',VacationPaymentType::Paid)
            ->whereYear('date', $this->year)
            ->whereMonth('date', $this->month)
            ->groupBy('person_id')
        ;
        $this->addDaysQuery($paidVacations);

        $unpaidVacations = DB::table('vacations')
            ->select('person_id')
            ->where('payment_type',VacationPaymentType::Unpaid)
            ->whereYear('date', $this->year)
            ->whereMonth('date', $this->month)
            ->groupBy('person_id')
        ;
        $this->addDaysQuery($unpaidVacations);

        $paidQuery = $model->newQuery()
            ->select(array_merge(['people.*', 'long_vacations.*'], $this->dayKeys('paid_vacations.', '_planned'), $this->dayKeys('paid_vacations.', '_actual'), $this->dayKeys('paid_vacations.', '_sick')))
            ->selectRaw("'".VacationPaymentType::Paid."' as payment")
            ->leftJoinSub($paidVacations, 'paid_vacations', function($join) {
                $join->on('paid_vacations.person_id', '=', 'people.id');
            })
        ;
        $this->addLongVacationMonthQuery($paidQuery);
        $this->addFilterQuery($paidQuery);

        $unpaidQuery = $model->newQuery()
            ->select(array_merge(['people.*', 'long_vacations.*'], $this->dayKeys('unpaid_vacations.', '_planned'), $this->dayKeys('unpaid_vacations.', '_actual'), $this->dayKeys('unpaid_vacations.', '_sick')))
            ->selectRaw("'".VacationPaymentType::Unpaid."' as payment")
            ->leftJoinSub($unpaidVacations, 'unpaid_vacations', function($join) {
                $join->on('unpaid_vacations.person_id', '=', 'people.id');
            })
        ;
        $this->addLongVacationMonthQuery($unpaidQuery);
        $this->addFilterQuery($unpaidQuery);

        return $unpaidQuery
            ->unionAll($paidQuery)
            ->orderBy('name')
            ->orderBy('payment');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('vacation-month-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(0);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            //
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'VacationMonth_' . date('YmdHis');
    }

    /**
     * @return array[]
     */
    public function days()
    {
        return array_map(function($item) {
            return [
                'day' => "{$this->shortMonthName($item)}_{$item->day}",
                'name' => "{$item->shortMonthName} {$item->day}",
                'holiday' => $item->isWeekend() || in_array($item->day, array_column($this->holidays, 'day'), true),
                'tooltip' => in_array($item->day, array_column($this->holidays, 'day'), true) ? $this->holidays[array_search($item->day, $this->holidays, true)]['name'] : '',
                'date' => $item->format('d-m-Y'),
            ];
        }, $this->period()->toArray());
    }

    /**
     * @return mixed
     * @throws \Carbon\Exceptions\InvalidFormatException
     */
    private function fetchHolidays()
    {
        return Holiday::ofYear($this->year)
            ->whereMonth('date', $this->month)
            ->get(['date', 'name', 'moved_date'])
            ->map(function($holiday) {
                return [
                    'day' => Carbon::parse($holiday->moved_date ?: $holiday->date)->day,
                    'name' => $holiday->name
                ];
            })
            ->toArray();
    }

    /**
     * @param string $prefix
     * @param string $postfix
     * @return string[]
     */
    private function dayKeys($prefix = '', $postfix = '')
    {
        return array_map(function($item) use ($prefix, $postfix) {
            return "$prefix{$this->shortMonthName($item)}_{$item->day}$postfix";
        }, $this->period()->toArray());
    }

    /**
     * @param $date
     * @return string
     */
    private function shortMonthName($date)
    {
        return strtolower($date->shortMonthName);
    }

    /**
     * @return CarbonPeriod
     * @throws \Carbon\Exceptions\InvalidFormatException
     */
    private function period()
    {
        return CarbonPeriod::create(
            Carbon::createFromDate($this->year, $this->month)->startOfMonth(),
            '1 day',
            Carbon::createFromDate($this->year, $this->month)->endOfMonth()
        );
    }

    /**
     * @param $query
     */
    private function addDaysQuery($query)
    {
        foreach($this->period() as $day) {
            $query
                ->selectRaw("sum(case when day(date)='{$day->day}' and type='planned' then days end) as '{$this->dayFieldName($day, VacationType::Planned)}'")
                ->selectRaw("sum(case when day(date)='{$day->day}' and type='actual' then days end) as '{$this->dayFieldName($day, VacationType::Actual)}'")
                ->selectRaw("sum(case when day(date)='{$day->day}' and type='sick' then days end) as '{$this->dayFieldName($day, VacationType::Sick)}'")
            ;
        }
    }

    /**
     * @param $day
     * @param $postfix
     * @return string
     */
    private function dayFieldName($day, $postfix = '')
    {
        return "{$this->shortMonthName($day)}_{$day->day}" . ($postfix ? "_$postfix" : '');
    }

    /**
     * @param $eloquent
     *
     * @throws \Carbon\Exceptions\InvalidFormatException
     */
    private function addDayColumns($eloquent)
    {
        foreach($this->period() as $day) {
            $eloquent->addColumn($this->dayFieldName($day), function(Person $model) use ($day) {
                if ($model->quited_at) {
                    $quitedAt = Carbon::parse($model->quited_at);
                    if ($day > $quitedAt) {
                        return [
                            'type' => DayType::Quited,
                            'days' => 0,
                        ];
                    }
                }
                $startDate = Carbon::parse($model->start_date);
                if ($day < $startDate) {
                    return [
                        'type' => DayType::NotStarted,
                        'days' => 0,
                    ];
                }
                if ($model->{"long_vacation_".$this->dayFieldName($day)}) {
                    return [
                        'type' => DayType::LongVacation,
                        'days' => 0,
                    ];
                }
                if ($day->isWeekend() || in_array($day->day, array_column($this->holidays, 'day'))) {
                    return [
                        'type' => DayType::Holiday,
                        'days' => 0,
                    ];
                }
                if ($model->{$this->dayFieldName($day, VacationType::Planned)}) {
                    return [
                        'type' => DayType::Planned,
                        'days' => 0,
                    ];
                }
                if ($model->{$this->dayFieldName($day, VacationType::Actual)}) {
                    return [
                        'type' => DayType::Actual,
                        'days' => $model->{$this->dayFieldName($day, VacationType::Actual)},
                    ];
                }
                if ($model->{$this->dayFieldName($day, VacationType::Sick)}) {
                    return [
                        'type' => DayType::Sick,
                        'days' => $model->{$this->dayFieldName($day, VacationType::Sick)},
                    ];
                }
                return [
                    'type' => DayType::Weekday,
                    'days' => 0,
                ];
            });
        }
    }

    /**
     * @param $query
     *
     * @throws \Carbon\Exceptions\InvalidFormatException
     */
    private function addLongVacationMonthQuery($query)
    {
        $longVacationsQuery = DB::table('long_vacations')
            ->select('person_id')
            ->groupBy('person_id');
        foreach($this->period() as $day) {
            $longVacationsQuery->selectRaw("
                sum(case
                    when (
                        year(long_vacation_started_at)='{$day->year}'
                        or year(long_vacation_finished_at)='{$day->year}'
                    )
                    and long_vacation_started_at <= '{$day->startOfDay()}'
                    and (
                        long_vacation_finished_at is null
                        or long_vacation_finished_at >= '{$day->endOfDay()}'
                    )
                then 1 else 0 end) as long_vacation_{$this->dayFieldName($day)}
            ");
        }
        $query->leftJoinSub($longVacationsQuery, 'long_vacations', function($join) {
            $join->on('long_vacations.person_id', '=', 'people.id');
        });
    }

    /**
     * @param $query
     */
    private function addFilterQuery($query)
    {
        $query->when($this->request()->input('search'), function($query, $search) {
            $query->where('people.name', 'like', "%$search%");
        });
        if (!$this->request()->filled('show_all')) {
            $query->whereNull('people.quited_at');
        }
    }
}
