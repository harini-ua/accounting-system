<?php

namespace App\DataTables;

use App\Enums\Currency;
use App\Models\Person;
use App\Services\Formatter;
use Carbon\Carbon;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BonusesByRecruitDataTable extends DataTable
{
    public const COLUMNS = [
        'name',
        'start_data',
        'salary',
        'bonus',
        'first_part_bonus',
        'first_part_paid',
        'end_trial_data',
        'second_part_bonus',
        'second_part_paid',
    ];

    /** @var Person $recruiter */
    public $recruiter;

    /** @var array $query */
    public $query;

    /** @var string $firstPart */
    public $firstPart;

    /** @var string $secondPart */
    public $secondPart;

    /**
     * ContractsDataTable constructor.
     *
     * @param Person $recruiter
     * @param array  $query
     */
    public function __construct(Person $recruiter, array $query)
    {
        $this->recruiter = $recruiter;
        $this->query = $query;

        $fraction = config('people.bonuses.recruit.fraction');
        $this->firstPart = $this->recruiter->bonuses_reward * fraction_to_decimal($fraction);
        $this->secondPart = $this->recruiter->bonuses_reward - $this->firstPart;
    }

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = datatables()->eloquent($query);

        $dataTable->addColumn('name', static function(Person $model) {
            return view('partials.view-link', ['model' => $model]);
        });

        $dataTable->addColumn('start_data', static function(Person $model) {
            return Carbon::parse($model->start_date)->format(config('general.date.format'));
        });

        $dataTable->addColumn('salary', static function(Person $model) {
            return Formatter::currency($model->salary, Currency::symbol($model->currency));
        });

        $dataTable->addColumn('bonus', static function(Person $model) {
            $bonus = $model->salary / 100 * $model->recruiter->bonuses_reward;
            return Formatter::currency($bonus, Currency::symbol($model->currency));
        });

        $dataTable->addColumn('first_part_bonus', function(Person $model) {
            return Formatter::currency($model->salary / 100 * $this->firstPart, Currency::symbol($model->currency));
        });

        $dataTable->addColumn('first_part_paid', static function(Person $model) {
            return '-';
        });

        $dataTable->addColumn('end_trial_data', static function(Person $model) {
            return Carbon::parse($model->start_date)
                ->add(\DateInterval::createFromDateString(config('people.trial_period')))
                ->format(config('general.date.format'));
        });

        $dataTable->addColumn('second_part_bonus', function(Person $model) {
            return Formatter::currency($model->salary / 100 * $this->secondPart, Currency::symbol($model->currency));
        });

        $dataTable->addColumn('second_part_paid', static function(Person $model) {
            return '-';
        });

        $dataTable->rawColumns(self::COLUMNS);

        return $dataTable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param Person $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Person $model)
    {
        $query = $model->newQuery();
        $query->select('people.*');
        $query->with(['recruiter']);
        $query->where('recruiter_id', $this->recruiter->id);

        return $query;
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
            Column::make('id')->hidden(),
            Column::make('name')->searchable(),
            Column::make('start_data')->title('Date of the work beginning'),
            Column::make('salary'),
            Column::make('bonus')->title('Bonuses'),
            Column::make('first_part_bonus')->title('1-st part of the bonus'),
            Column::make('first_part_paid')->title('1-st part paid'),
            Column::make('end_trial_data')->title('Date of the trial period ended'),
            Column::make('second_part_bonus')->title('2-st part of the bonus'),
            Column::make('second_part_paid')->title('2-st part paid'),
        ];
    }
}