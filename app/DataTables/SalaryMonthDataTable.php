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
    public const COLUMNS = [
        'payment_method',
        'action'
    ];

    /** @var $year */
    private $year;

    /** @var $month */
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
            ->addColumn('compensation', function(Person $model) {
                if (is_null($model->salary_payments_id)) return null;

                $compensation = $model->tax_compensation + $model->other_compensation;

                return $compensation ? Formatter::currency($compensation, Currency::symbol($model->people_currency)) : null;
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

                return '<a href="'.
                    route('wallets.show', $account->wallet->id).'" 
                    title="'.$account->accountType->name.'" 
                    target="_blank">'
                    .$account->wallet->name.'</a>';
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
                $parameters = [
                    'year' => $this->year,
                    'month' => $this->month,
                    'person_id' => $model->id
                ];

                $url = route('salary-payments.create', $parameters);
                $payslip = route('payslip.print', $parameters);

                if (!is_null($model->salary_payments_id)) {
                    $actions = '<a class="mr-4" href="'.$url.'"><i class="material-icons">edit</i></a>';
                    $actions .= '<a class="mr-4" href="'.$payslip.'"><i class="material-icons">print</i></a>';

                    return $actions;
                }

                return '<a href="'.$url.'" class="waves-effect waves-light btn">+Add</a>';
            })
            ->rawColumns(self::COLUMNS)
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
                'salary_payments.other_compensation',
                'salary_payments.payment_date',
                'salary_payments.bonuses as salary_payments_bonuses',
                'salary_payments.total_usd',
                'salary_payments.currency',
                'salary_payments.account_id',
            ])
//            ->leftJoin('salary_payments', 'salary_payments.person_id', '=', 'people.id')
            ->leftJoin('salary_payments', function($join) {
                $join->on('salary_payments.person_id', '=', 'people.id')
                    ->whereNull('salary_payments.deleted_at')
                    ->where('salary_payments.calendar_month_id', $this->calendarMonth->id);
            })
            ->whereNull('people.quited_at')
            ->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     * @throws \Throwable
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('salary-month-list-datatable')
            ->addTableClass('subscription-table responsive-table highlight')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->language([ 'processing' => view('partials.preloader-circular')->render() ])
            ->orderBy(1, 'asc')
            ->parameters([
                 'columnDefs' => [
                     ['targets' => [0], 'className' => 'fixed small-text center-align'],
                     ['targets' => [1], 'className' => 'fixed small-text center-align border-right'],
                     ['targets' => [2, 4, 6, 8, 15, 17, 19], 'className' => 'small-text center-align border-right'],
                     [
                         'targets' => [3, 5, 7, 9, 10, 11, 12, 13, 14, 16, 18, 20],
                         'className' => 'small-text center-align'
                     ],
                 ],
                 'buttons'      => ['reset'],
             ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('name')->title('Person')->searchable(true)->orderable(true),
//            Column::make('salary_type')->searchable(false),
//            Column::make('contract_type')->searchable(false),
            Column::make('salary')->searchable(false)->orderable(false),
            Column::make('rate')->searchable(false)->orderable(false),
            Column::make('worked_days')->title('Days')->searchable(false)->orderable(false),
            Column::make('worked_hours')->title('Hours')->searchable(false)->orderable(false),
            Column::make('delta_hours')->searchable(false)->orderable(false),
            Column::make('earned')->searchable(false)->orderable(false),
            Column::make('overtime_hours')->title('Hours')->searchable(false)->orderable(false),
            Column::make('overtime_pay')->title('Pay')->searchable(false)->orderable(false),
            Column::make('salary_payments_bonuses')->title(__('Bonuses'))->searchable(false)->orderable(false),
            Column::make('vacations')->searchable(false)->orderable(false),
            Column::make('vacation_compensation')->searchable(false)->orderable(false),
            Column::make('leads')->searchable(false)->orderable(false),
            Column::make('monthly_bonus')->searchable(false)->orderable(false),
            Column::make('fines')->searchable(false)->orderable(false),
            Column::make('compensation')->searchable(false)->orderable(false),
            Column::make('total_usd')->title('USD')->searchable(false)->orderable(false),
            Column::make('total_uah')->title('UAH')->searchable(false)->orderable(false),
            Column::make('payment_method')->title('Method')->searchable(false)->orderable(false),
            Column::make('payment_date')->title('Date')->searchable(false)->orderable(false),
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
