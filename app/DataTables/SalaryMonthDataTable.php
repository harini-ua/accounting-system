<?php

namespace App\DataTables;

use App\Enums\Currency;
use App\Enums\SalaryType;
use App\Models\Account;
use App\Models\CalendarMonth;
use App\Models\Person;
use App\Services\Formatter;
use App\Services\SalaryPaymentService;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SalaryMonthDataTable extends DataTable
{

    private $year;
    private $month;
    private $calendarMonth;

    /**
     * SalaryMonthDataTable constructor.
     * @param $year
     * @param $month
     */
    public function __construct($year, $month)
    {
        $this->year = $year;
        $this->month = $month;
        $this->calendarMonth = CalendarMonth::with('calendarYear')->whereYear('date', $year)->whereMonth('date', $month)->first();
        $this->accounts = Account::with('wallet', 'accountType')->get();
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
            ->eloquent($query)
            // definitions
            ->addColumn('name', function(Person $model) {
                return view('partials.view-link', ['model' => $model]);
            })
//            ->addColumn('salary_type', function(Person $model) {
//                return SalaryType::getDescription($model->salary_type);
//            })
//            ->addColumn('contract_type', function(Person $model) {
//                return PersonContractType::getDescription($model->contract_type);
//            })
            ->addColumn('salary', function(Person $model) {
                return $this->moneyFormat($model, 'salary');
            })
            ->addColumn('rate', function(Person $model) {
                return $this->moneyFormat($model, 'rate');
            })
            ->addColumn('delta_hours', function(Person $model) {
                if (SalaryType::isHourly($model->salary_type) || is_null($model->salary_payments_id)) {
                    return null;
                }
                $deltaHours = $this->calendarMonth->getWorkingHours($model->salary_type)
                    - $model->worked_hours - SalaryPaymentService::calcHours((int)$model->vacations, $model->salary_type);
                return round($deltaHours, 2);
            })
            ->addColumn('earned', function(Person $model) {
                if (is_null($model->salary_payments_id)) {
                    return null;
                }
                return $this->moneyFormat($model, 'earned');
            })
            ->addColumn('overtime_pay', function(Person $model) {
                if (is_null($model->salary_payments_id)) {
                    return null;
                }
                return $model->overtime_hours ? Formatter::currency($model->overtime_hours * $model->rate, Currency::symbol($model->people_currency)) : null;
            })
            ->addColumn('salary_payments_bonuses', function(Person $model) {
                if (!$model->salary_payments_bonuses || is_null($model->salary_payments_id)) {
                    return null;
                }
                return view('pages.salary.partials.table._month', ['bonuses' => json_decode($model->salary_payments_bonuses, true)]);
            })
            ->addColumn('vacations', function(Person $model) {
                if (is_null($model->salary_payments_id)) {
                    return null;
                }
                return $model->vacations ?: null;
            })
            ->addColumn('vacation_compensation', function(Person $model) {
                if (is_null($model->salary_payments_id)) {
                    return null;
                }
                return $this->moneyFormat($model, 'vacation_compensation');
            })
            ->addColumn('leads', function(Person $model) {
                if (is_null($model->salary_payments_id)) {
                    return null;
                }
                $leads = $model->tech_lead_reward + $model->team_lead_reward;
                return $leads
                    ? Formatter::currency($leads, Currency::symbol(Currency::UAH))
                    : null;
            })
            ->addColumn('monthly_bonus', function(Person $model) {
                if (is_null($model->salary_payments_id)) {
                    return null;
                }
                return $this->moneyFormat($model, 'monthly_bonus');
            })
            ->addColumn('fines', function(Person $model) {
                if (is_null($model->salary_payments_id)) {
                    return null;
                }
                return $this->moneyFormat($model, 'fines');
            })
            ->addColumn('tax_compensation', function(Person $model) {
                if (is_null($model->salary_payments_id)) {
                    return null;
                }
                return $this->moneyFormat($model, 'tax_compensation');
            })
            ->addColumn('total_usd', function(Person $model) {
                if (is_null($model->salary_payments_id)) {
                    return null;
                }
                return $this->moneyFormat($model, 'total_usd', Currency::USD);
            })
            ->addColumn('total_uah', function(Person $model) {
                if (is_null($model->salary_payments_id)) {
                    return null;
                }
                return $model->total_usd
                    ? Formatter::currency($model->total_usd * $model->currency, Currency::symbol(Currency::UAH))
                    : null;
            })
            ->addColumn('payment_method', function(Person $model) {
                if (is_null($model->salary_payments_id)) {
                    return null;
                }
                $account = $this->accounts->find($model->account_id);
                return $account->wallet->name . ', ' . $account->accountType->name;
            })
            // filters
            ->filterColumn('name', function($query, $keyword) {
                $query->where('name', 'like', "%$keyword%");
            })
            // orders
            ->orderColumn('name', function($query, $order) {
                $query->orderBy('name', $order);
            })
            // other
            ->addColumn('action', function(Person $model) {
                $url = route('salary-payments.create', [
                    'year' => $this->calendarMonth->calendarYear->id,
                    'month' => $this->calendarMonth->id,
                    'person_id' => $model->id
                ]);
                if (!is_null($model->salary_payments_id)) {
                    return '<a class="mr-4" href="'.$url.'"><i class="material-icons">edit</i></a>';
                }
                return '<a href="'.$url.'" class="waves-effect waves-light  btn">+Add</a>';
            })
            ;
    }

    /**
     * Get query source of dataTable.
     *
     * @param Person $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Person $model)
    {
        return $model
            ->select([
                'people.id',
                'people.name',
                'people.salary_type',
//                'people.contract_type',
                'people.rate',
                'people.salary',
                'people.position_id',
                'people.tech_lead_reward',
                'people.team_lead_reward',
                'people.currency as people_currency',
                'salary_payments.id as salary_payments_id',
                'salary_payments.worked_days',
                'salary_payments.worked_hours',
                'salary_payments.earned',
                'salary_payments.overtime_hours',
                'salary_payments.vacations',
                'salary_payments.vacation_compensation',
                'salary_payments.monthly_bonus',
                'salary_payments.fines',
                'salary_payments.tax_compensation',
                'salary_payments.payment_date',
                'salary_payments.bonuses as salary_payments_bonuses',
                'salary_payments.total_usd',
                'salary_payments.currency',
                'salary_payments.account_id',
            ])
//            ->leftJoin('salary_payments', 'salary_payments.person_id', '=', 'people.id')
            ->leftJoin('salary_payments', function($join) {
                $join->on('salary_payments.person_id', '=', 'people.id')
                    ->where('salary_payments.calendar_month_id', $this->calendarMonth->id);
            })
            ->whereNull('people.quited_at')
            ->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('salary-month-table')
            ->addTableClass('subscription-table responsive-table highlight')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->language([ 'processing' => view('partials.preloader-circular')->render() ])
//            ->ordering(false)
            ;
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('name')->searchable(true)->orderable(true),
//            Column::make('salary_type')->searchable(false),
//            Column::make('contract_type')->searchable(false),
            Column::make('salary')->searchable(false)->orderable(false),
            Column::make('rate')->searchable(false)->orderable(false),
            Column::make('worked_days')->searchable(false)->orderable(false),
            Column::make('worked_hours')->searchable(false)->orderable(false),
            Column::make('delta_hours')->searchable(false)->orderable(false),
            Column::make('earned')->searchable(false)->orderable(false),
            Column::make('overtime_hours')->searchable(false)->orderable(false),
            Column::make('overtime_pay')->searchable(false)->orderable(false),
            Column::make('salary_payments_bonuses')->title(__('Bonuses'))->searchable(false)->orderable(false),
            Column::make('vacations')->searchable(false)->orderable(false),
            Column::make('vacation_compensation')->searchable(false)->orderable(false),
            Column::make('leads')->searchable(false)->orderable(false),
            Column::make('monthly_bonus')->searchable(false)->orderable(false),
            Column::make('fines')->searchable(false)->orderable(false),
            Column::make('tax_compensation')->searchable(false)->orderable(false),
            Column::make('total_usd')->searchable(false)->orderable(false),
            Column::make('total_uah')->searchable(false)->orderable(false),
            Column::make('payment_method')->searchable(false)->orderable(false),
            Column::make('payment_date')->searchable(false)->orderable(false),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'SalaryMonth_' . date('YmdHis');
    }

    /**
     * @param Person $model
     * @param string $field
     * @param string $symbol
     * @return string|null
     */
    private function moneyFormat(Person $model, string $field, $symbol = '')
    {
        return $model->$field ? Formatter::currency($model->$field, Currency::symbol($symbol ?: $model->people_currency)) : null;
    }
}
