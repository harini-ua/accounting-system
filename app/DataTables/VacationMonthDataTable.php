<?php

namespace App\DataTables;

use App\Enums\VacationPaymentType;
use App\Models\Holiday;
use App\Models\Person;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class VacationMonthDataTable extends DataTable
{
    private $year;
    private $month;

    /**
     * VacationMonthDataTable constructor.
     * @param $year
     * @param $month
     */
    public function __construct($year, $month)
    {
        $this->year = $year;
        $this->month = $month;
    }

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query);
    }

    /**
     * Get query source of dataTable.
     *
     * @param Person $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Person $model)
    {
        $paidVacations = DB::table('vacations')
            ->select('person_id')
            ->selectRaw('count(id) as total')
            ->where('payment_type',VacationPaymentType::Paid)
            ->groupBy('person_id');
        $this->addDaysQuery($paidVacations);

        $unpaidVacations = DB::table('vacations')
            ->select('person_id')
            ->selectRaw('count(id) as total')
            ->where('payment_type',VacationPaymentType::Unpaid)
            ->groupBy('person_id');
        $this->addDaysQuery($unpaidVacations);

        $paidQuery = $model->newQuery()
            ->select(array_merge(['people.*', 'paid_vacations.total'], $this->dayKeys('paid_vacations.')))
            ->selectRaw("'".VacationPaymentType::Paid."' as payment")
            ->leftJoinSub($paidVacations, 'paid_vacations', function($join) {
                $join->on('paid_vacations.person_id', '=', 'people.id');
            })
        ;
//        $this->addLongVacationMonthQuery($paidQuery);
//        $this->addFilterQuery($paidQuery);

        $unpaidQuery = $model->newQuery()
            ->select(array_merge(['people.*', 'unpaid_vacations.total'], $this->dayKeys('unpaid_vacations.')))
            ->selectRaw("'".VacationPaymentType::Unpaid."' as payment")
            ->leftJoinSub($unpaidVacations, 'unpaid_vacations', function($join) {
                $join->on('unpaid_vacations.person_id', '=', 'people.id');
            })
        ;
//        $this->addLongVacationMonthQuery($unpaidQuery);
//        $this->addFilterQuery($unpaidQuery);

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
        $holidays = Holiday::ofYear($this->year)
            ->whereMonth('date', $this->month)
            ->get(['date', 'name', 'moved_date'])
            ->map(function($holiday) {
                return [
                    'day' => Carbon::parse($holiday->moved_date ?: $holiday->date)->day,
                    'name' => $holiday->name
                ];
            })
            ->toArray();
        return array_map(function($item) use ($holidays) {
            return [
                'day' => "{$this->shortMonthName($item)}_{$item->day}",
                'name' => "{$item->shortMonthName} {$item->day}",
                'holiday' => $item->isWeekend() || in_array($item->day, array_column($holidays, 'day')),
                'tooltip' => in_array($item->day, array_column($holidays, 'day')) ? $holidays[array_search($item->day, $holidays)]['name'] : '',
            ];
        }, $this->period()->toArray());
    }

    /**
     * @param string $prefix
     * @return string[]
     */
    private function dayKeys($prefix = '')
    {
        return array_map(function($item) use ($prefix) {
            return "$prefix{$this->shortMonthName($item)}_{$item->day}";
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
     */
    private function period()
    {
        return CarbonPeriod::create(Carbon::createFromDate($this->year, $this->month)->startOfMonth(), '1 day', Carbon::createFromDate($this->year, $this->month)->endOfMonth());
    }

    /**
     * @param $query
     */
    private function addDaysQuery($query)
    {
        foreach($this->period() as $day) {
            $query->selectRaw("count(case when day(date)='{$day->day}' then id end) as '{$this->shortMonthName($day)}_{$day->day}'");
        }
    }
}
