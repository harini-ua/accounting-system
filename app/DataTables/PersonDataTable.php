<?php

namespace App\DataTables;

use App\Enums\Currency;
use App\Enums\PersonContractType;
use App\Enums\Position;
use App\Enums\SalaryType;
use App\Models\Person;
use App\Services\Formatter;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PersonDataTable extends DataTable
{
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
            ->addColumn('position', function(Person $model) {
                return Position::getDescription($model->position_id);
            })
            ->addColumn('salary_type', function(Person $model) {
                return SalaryType::getDescription($model->salary_type);
            })
            ->addColumn('contract_type', function(Person $model) {
                return PersonContractType::getDescription($model->contract_type);
            })
            ->addColumn('growth_plan', function(Person $model) {
                return view('partials.boolean', ['model' => $model, 'field' => 'growth_plan']);
            })
            ->addColumn('tech_lead', function(Person $model) {
                return view('partials.boolean', ['model' => $model, 'field' => 'tech_lead']);
            })
            ->addColumn('team_lead', function(Person $model) {
                return view('partials.boolean', ['model' => $model, 'field' => 'team_lead']);
            })
            ->addColumn('salary', function(Person $model) {
                return Formatter::currency($model->salary, Currency::symbol($model->currency));
            })
            // filters
            ->filterColumn('name', function($query, $keyword) {
                $query->where('name', 'like', "%$keyword%");
            })
            // orders
            ->orderColumn('name', function($query, $order) {
                $query->orderBy('name', $order);
            })
            ->orderColumn('position', function($query, $order) {
                $query->orderBy('position_id', $order);
            })
            ->orderColumn('salary_type', function($query, $order) {
                $query->orderBy('salary_type', $order);
            })
            ->orderColumn('contract_type', function($query, $order) {
                $query->orderBy('contract_type', $order);
            })
            ->orderColumn('growth_plan', function($query, $order) {
                $query->orderBy('growth_plan', $order);
            })
            ->orderColumn('tech_lead', function($query, $order) {
                $query->orderBy('tech_lead', $order);
            })
            ->orderColumn('team_lead', function($query, $order) {
                $query->orderBy('team_lead', $order);
            })
            ->orderColumn('salary', function($query, $order) {
                $query->orderBy('salary', $order);
            })

            // other
            ->setRowClass(function (Person $model) {
                if ($model->long_vacation) {
                    return 'red lighten-5 red-text red-link font-weight-700';
                }
                return '';
            })
            ->addColumn('action', function(Person $model) {
                return view("partials.actions", ['actions'=>['edit', 'delete'], 'model' => $model]);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param Person $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Person $model)
    {
        $longVacations = DB::table('long_vacations')
            ->select('person_id')
            ->selectRaw('1 as long_vacation')
            ->where('long_vacations.long_vacation_started_at', '<=', Carbon::now())
            ->where(function($query) {
                $query->where('long_vacations.long_vacation_finished_at', '>=', Carbon::now())
                    ->orWhereNull('long_vacations.long_vacation_finished_at');
            })
            ->groupBy('person_id');


        return $model->newQuery()
            ->select('people.*', 'current_long_vacations.long_vacation')
            ->leftJoinSub($longVacations, 'current_long_vacations', function($join) {
                $join->on('current_long_vacations.person_id', '=', 'people.id');
            })
            ->whereNull('quited_at')
            ->orderBy('current_long_vacations.long_vacation');
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
            ->setTableId('person-table')
            ->addTableClass('subscription-table responsive-table highlight')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->pageLength(15)
            ->dom('Bfrtip')
            ->language([ 'processing' => view('partials.preloader-circular')->render() ])
            ->orderBy(0, 'desc');
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id'),
            Column::make('name')->searchable(),
            Column::make('position'),
            Column::make('start_date')->title('Date of the work beginning'),
            Column::make('salary'),
            Column::make('salary_type'),
            Column::make('contract_type')->title('Type of contract'),
            Column::make('growth_plan')->title('Professional Growth'),
            Column::make('tech_lead'),
            Column::make('team_lead'),
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
        return 'Person_' . date('YmdHis');
    }
}
