<?php


namespace App\Services;


use App\Models\CalendarYear;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CalendarPaginator
{
    private $year;
    private $prev;
    private $next;

    /**
     * CalendarPaginator constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->year = $this->getYear($request);
        $this->initLinks(Route::currentRouteName());
    }

    /**
     * @param Request $request
     * @return int|mixed
     */
    private function getYear(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'year' => 'sometimes|exists:calendar_years,name',
        ]);
        if ($validator->fails()) {
            throw new NotFoundHttpException();
        }
        return $request->has('year') ? $request->input('year') : Carbon::now()->year;
    }

    /**
     * @param string $routeName
     */
    private function initLinks(string $routeName)
    {
        $prevYear = $this->year - 1;
        $nextYear = $this->year + 1;

        $years = CalendarYear::whereIn('name', [$prevYear, $nextYear])->get();

        $this->prev = $this->getLink($years, $prevYear, $routeName);
        $this->next = $this->getLink($years, $nextYear, $routeName);
    }

    /**
     * @param Collection $years
     * @param int $year
     * @param string $routeName
     * @return string|null
     */
    private function getLink(Collection $years, int $year, string $routeName): ?string
    {
        $calendarYear = $years->where('name', $year)->first();
        $params = Carbon::now()->year != $year ? ['year' => $year] : [];
        return $calendarYear ? route($routeName, $params) : null;
    }

    /**
     * @return int|mixed
     */
    public function year()
    {
        return $this->year;
    }

    /**
     * @return mixed
     */
    public function prev()
    {
        return $this->prev;
    }

    /**
     * @return mixed
     */
    public function next()
    {
        return $this->next;
    }

}
