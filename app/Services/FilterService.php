<?php


namespace App\Services;


use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class FilterService
{
    /**
     * @var array
     */
    private $filters = [];

    /**
     * FilterService constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->filters['start_date'] = $request->has('start_date')
            ? Carbon::parse($request->input('start_date'))->startOfMonth()
            : Carbon::now()->startOfMonth();

        $this->filters['end_date'] = $request->has('end_date')
            ? Carbon::parse($request->input('end_date'))->endOfMonth()
            : Carbon::now();

        if ($request->has('client_filter')) {
            $this->filters['client'] = $request->input('client_filter');
        }

        if ($request->has('wallet_filter')) {
            $this->filters['wallet'] = $request->input('wallet_filter');
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

}
