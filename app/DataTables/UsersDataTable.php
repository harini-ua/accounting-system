<?php

namespace App\DataTables;

use App\Models\Position;
use App\User;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
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
            ->addColumn('name', function(User $user) {
                return $user->name;
            })
            ->addColumn('email', function(User $user) {
                return $user->email;
            })
            ->addColumn('position', function(User $user) {
                return $user->position->name;
            })
            ->addColumn('action', function(User $user) {
                return view("partials.actions", ['actions'=>['edit','delete'], 'model' => $user]);
            })
            ->filterColumn('name', function($query, $keyword) {
                $query->where('users.name', 'like', "%$keyword%");
            })
            ->filterColumn('position', function($query, $keyword) {
                $walletTypes = Position::where('name', 'like', "%$keyword%")->pluck('id')->toArray();
                $query->whereIn('position_id', $walletTypes);
            })
            ->orderColumn('name', function($query, $order) {
                $query->orderBy('users.name', $order);
            })
            ->orderColumn('position', function($query, $order) {
                $query->join('positions', 'positions.id', '=', 'users.position_id')
                    ->orderBy('positions.name', $order);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model->newQuery()
            ->select('users.*')
            ->with('position');
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
            ->setTableId('users-list-datatable')
            ->addTableClass('subscription-table responsive-table highlight')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->pageLength(16)
            ->dom('Bfrtip')
            ->language([ 'processing' => view('partials.preloader-circular')->render() ])
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
            Column::make('id'),
            Column::make('name'),
            Column::make('email')->orderable(false),
            Column::make('position'),
            Column::computed('action')
                ->orderable(false)
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
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
        return 'Users_' . date('YmdHis');
    }
}
