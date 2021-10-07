<?php

namespace App\Services;

use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class FilterService
{
    /**
     * @var array
     */
    private $filters = [];

    /**
     * FilterService constructor.
     *
     * @param Request $request
     *
     * @throws InvalidFormatException
     */
    public function __construct(Request $request)
    {
        $this->filters['start_date'] = $request->has('start_date')
            ? Carbon::parse($request->input('start_date'))
            : Carbon::now()->startOfMonth();

        $this->filters['end_date'] = $request->has('end_date')
            ? Carbon::parse($request->input('end_date'))
            : Carbon::now()->endOfMonth();

        if ($request->has('client_filter')) {
            $this->filters['client'] = $request->input('client_filter');
        }

        if ($request->has('wallet_filter')) {
            $this->filters['wallet'] = $request->input('wallet_filter');
        }

        if ($request->has('received')) {
            $this->filters['received'] = $request->input('received');
        }
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->get('start_date');
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->get('end_date');
    }

    /**
     * @return mixed
     */
    public function getStartOfMonthDate()
    {
        return (clone $this->get('start_date'))->startOfMonth();
    }

    /**
     * @return mixed
     */
    public function getEndOfMonthDate()
    {
        return (clone $this->get('end_date'))->endOfMonth();
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function get(string $key)
    {
        return $this->filters[$key] ?? null;
    }

    /**
     * @param string $key
     * @param $filter
     */
    public function set(string $key, $filter)
    {
        $this->filters[$key] = $filter;
    }

    /**
     * @param $query
     * @return mixed
     */
    public function filterInvoicedSum($query)
    {
        $this->filterClient($query);
        $this->filterWallet($query);
        $this->filterReceived($query);

        return $query;
    }

    /**
     * @param $query
     * @return mixed
     */
    public function filterReceivedSum($query)
    {
        $query->whereBetween('payments.date', [
            $this->getStartOfMonthDate(),
            $this->getEndOfMonthDate()
        ]);
        $this->filterClient($query);
        $this->filterWallet($query);

        return $query;
    }

    /**
     * @param $query
     * @return mixed
     */
    public function filterPlanningSum($query)
    {
        $query->whereBetween('incomes.plan_date', [
            $this->getStartOfMonthDate(),
            $this->getEndOfMonthDate()
        ]);
        $this->filterClient($query, 'incomes');

        return $query;
    }

    /**
     * @param $query
     * @return mixed
     */
    public function filterExpensesSum($query)
    {
        $query->whereBetween('expenses.plan_date', [
            $this->getStartDate(),
            $this->getEndDate()
        ]);

        return $query;
    }

    /**
     * @param $query
     * @return mixed
     */
    public function filterAccountsSum($query)
    {
        $this->filterWallet($query);

        return $query;
    }

    /**
     * @param $query
     * @param string $table
     */
    private function filterClient($query, string $table = 'invoices')
    {
        $clientId = $this->get('client');
        $query->when($clientId, function ($query, $clientId) use ($table) {
            return $query->join('contracts', 'contracts.id', '=', "$table.contract_id")
                ->where('contracts.client_id', $clientId);
        });
    }

    /**
     * @param $query
     */
    private function filterWallet($query)
    {
        $walletId = $this->get('wallet');
        $query->when($walletId, function ($query, $walletId) {
            return $query->where('accounts.wallet_id', $walletId);
        });
    }

    /**
     * @param $query
     */
    private function filterReceived($query)
    {
        $received = $this->get('received');
        $query->when($received, function ($query) {
            $query->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('payments')
                    ->whereRaw('payments.invoice_id = invoices.id');
            });
        });
    }
}
