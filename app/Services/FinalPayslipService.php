<?php

namespace App\Services;

use App\Enums\Currency;
use App\Enums\SalaryType;
use App\Enums\VacationPaymentType;
use App\Models\AccountType;
use App\Models\CalendarMonth;
use App\Models\FinalPayslip;
use App\Models\Holiday;
use App\Models\Person;
use App\Models\SalaryPayment;
use App\Models\Vacation;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class FinalPayslipService
{
    public $calendarMonth;
    public $finalPayslip;
    public $person;
    public $symbol;
    public $currencies;
    public $fields;

    private $date;

    /**
     * FinalPayslipService constructor.
     *
     * @param CalendarMonth $calendarMonth
     * @param Collection $people
     * @param Request $request
     * @param Carbon $date
     */
    public function __construct(CalendarMonth $calendarMonth, Collection $people, Request $request, Carbon $date)
    {
        $this->date = $date;

        $this->finalPayslip = new FinalPayslip;
        $this->setCalendarMonth($calendarMonth);
        $this->setPerson($people, $request);

        if ($this->person) {
            $this->setLastWorkingDay();
            $this->setSymbol();
            $this->setFields();
            $this->setFinalPayslip($request);
            $this->setCurrencies();
            $this->setVacations();
            $this->fillCalendarMonth();
            $this->fillSalaryPayment();
            $this->setBonuses();
            $this->setTotals();
        }
    }

    /**
     * @return array
     */
    public function data()
    {
        return [
            $this->calendarMonth,
            $this->finalPayslip,
            $this->person,
            $this->symbol,
            $this->currencies,
            $this->fields,
        ];
    }

    /**
     * @return array
     */
    private function setFields()
    {
        $this->fields = [
            'earned' => $this->person->currency,
            'bonuses' => $this->person->currency,
            'vacation' => $this->person->currency,
            'vacation_compensation' => $this->person->currency,
            'leads' => $this->person->currency,
            'monthly_bonus' => $this->person->currency,
            'fines' => $this->person->currency,
            'tax_compensation' => Currency::UAH,
            'other_compensation' => Currency::UAH,
        ];
    }

    /**
     * @param CalendarMonth $calendarMonth
     */
    private function setCalendarMonth(CalendarMonth $calendarMonth): void
    {
        $this->calendarMonth = $calendarMonth;
    }

    /**
     * Set person
     *
     * @param Collection $people
     * @param $request
     */
    private function setPerson(Collection $people, Request $request): void
    {
        $this->person = $request->has('person_id') ? $people->where('id', $request->input('person_id'))->first() : null;
    }

    /**
     * Set last working day
     */
    private function setLastWorkingDay(): void
    {
        $this->finalPayslip->last_working_day = $this->date->format('d-m-Y');
    }

    /**
     * Set currency symbol
     */
    private function setSymbol(): void
    {
        $this->symbol = $this->person ? Currency::symbol($this->person->currency) : '';
    }

    /**
     * Set currency
     */
    private function setCurrencies(): void
    {
        $this->currencies = AccountType::all(['currency_type', 'currency'])
            ->mapWithKeys(function ($accountType) {
                return [$accountType->currency_type => $accountType->currency];
            });

        $this->finalPayslip->currency = $this->currencies[Currency::USD];
    }

    /**
     * Set vacations
     */
    private function setVacations(): void
    {
        $vacations = $this->person ? Vacation::where('calendar_month_id', $this->calendarMonth->id)
            ->where('person_id', $this->person->id)
            ->where('payment_type', VacationPaymentType::Paid)
            ->whereDate('date', '<=', $this->date)
            ->sum('days') : null;

        $this->finalPayslip->vacations = $vacations;
        $this->finalPayslip->vacation_compensation = $this->person ?
            self::calcVacationCompensation($this->person, $vacations, $this->date) : null;
    }

    /**
     *
     */
    private function fillCalendarMonth(): void
    {
        $this->calendarMonth->working_hours = $this->person ? $this->calendarMonth->getWorkingHours($this->person->salary_type) : null;
    }

    /**
     *
     */
    private function fillSalaryPayment(): void
    {
        $start = Carbon::parse($this->calendarMonth->date);
        $end = Carbon::parse($this->finalPayslip->last_working_day)->addDay();

        $days = $start->diffInDaysFiltered(function (Carbon $date) {
            return $date->isWeekday();
        }, $end);

        $this->finalPayslip->worked_days = $days - $this->finalPayslip->vacations - self::calcHolidays($this->finalPayslip, $this->person, $this->calendarMonth);
        $this->finalPayslip->worked_hours = self::calcHours($this->finalPayslip->worked_days, $this->person->salary_type);
        $this->finalPayslip->earned = $this->person ? self::calcEarned($this->finalPayslip, $this->person, $this->calendarMonth) : null;
        $this->finalPayslip->leads = $this->person ? self::calcLeads($this->finalPayslip, $this->person) : null;
    }

    private function setBonuses(): void
    {
        $this->person->actualBonuses = $this->person->getBonuses($this->date);
        $this->person->totalBonusesUSD = self::totalBonusesUSD($this->person, $this->currencies);
    }

    private function setTotals(): void
    {
        $this->finalPayslip->total_usd = self::calcTotalUSD($this->finalPayslip, $this->person, $this->currencies, $this->fields);
        $this->finalPayslip->total_uah = self::convert($this->currencies, Currency::USD, Currency::UAH, $this->finalPayslip->total_usd);
    }

    /**
     * Calculate total USD
     *
     * @param FinalPayslip $finalPayslip
     * @param Person $person
     * @param $currencies
     * @param array $fields
     *
     * @return float
     */
    private static function calcTotalUSD(FinalPayslip $finalPayslip, Person $person, $currencies, array $fields): float
    {
        $total = 0;
        foreach ($fields as $field => $currency) {
            $total += self::convertToUSD($currencies, $currency, $finalPayslip->$field);
        }

        $bonuses = self::totalBonusesUSD($person, $currencies);

        return round($total + $bonuses, 2);
    }

    /**
     * Convert to USD
     *
     * @param $currencies
     * @param $currency
     * @param $value
     *
     * @return float|int
     */
    private static function convertToUSD($currencies, $currency, $value)
    {
        return self::convert($currencies, $currency, Currency::USD, $value);
    }

    /**
     * Convert currency
     *
     * @param $currencies
     * @param $from
     * @param $to
     * @param $value
     *
     * @return float|int
     */
    private static function convert($currencies, $from, $to, $value)
    {
        return round($value * $currencies[$from] / $currencies[$to], 2);
    }

    /**
     * Get total bonuses USD
     *
     * @param Person $person
     * @param $currencies
     *
     * @return float|null
     */
    private static function totalBonusesUSD(Person $person, $currencies): ?float
    {
        if ($person->actualBonuses) {
            return round($person->actualBonuses->reduce(function ($carry, $bonus) use ($currencies) {
                    return $carry + $currencies[$bonus->currency] * $bonus->value;
                }, 0) / $currencies[Currency::USD], 2);
        }

        return null;
    }

    /**
     * Calculate holidays
     *
     * @param FinalPayslip $finalPayslip
     * @param Person $person
     * @param CalendarMonth $calendarMonth
     *
     * @return int
     */
    private static function calcHolidays(FinalPayslip $finalPayslip, Person $person, CalendarMonth $calendarMonth)
    {
        $dateTo = Carbon::parse($calendarMonth->date)->format('Y-m-d');
        $dateFrom = Carbon::parse($finalPayslip->last_working_day)->format('Y-m-d');

        return $person ? Holiday::whereBetween('date', [$dateTo, $dateFrom])->count() : 0;
    }

    /**
     * Calculate leads
     *
     * @param FinalPayslip $finalPayslip
     * @param Person $person
     *
     * @return float|int
     */
    private static function calcLeads(FinalPayslip $finalPayslip, Person $person)
    {
        return $finalPayslip->worked_days ? round(($person->tech_lead_reward + $person->team_lead_reward) / $finalPayslip->worked_days, 2) : 0;
    }

    /**
     * Calculate how much earned
     *
     * @param FinalPayslip $finalPayslip
     * @param Person $person
     * @param CalendarMonth $calendarMonth
     *
     * @return float|int
     */
    private static function calcEarned(FinalPayslip $finalPayslip, Person $person, CalendarMonth $calendarMonth)
    {
        if (SalaryType::isHourly($person->salary_type)) {
            return round($person->rate * $finalPayslip->worked_hours, 2);
        }
        return $calendarMonth->working_hours ? round($person->salary / $calendarMonth->working_days * $finalPayslip->worked_days, 2) : 0;
    }

    /**
     * @param int $days
     * @param string $salaryType
     * @return float|int|null
     */
    public static function calcHours(int $days, string $salaryType)
    {
        return SalaryType::hours($salaryType) ? $days * SalaryType::hours($salaryType) : null;
    }

    /**
     * Calculate vacation compensation
     *
     * @param Person $person
     * @param int $vacations
     * @param Carbon $date
     *
     * @return float|int
     * @throws InvalidFormatException
     */
    private static function calcVacationCompensation(Person $person, int $vacations, Carbon $date)
    {
//        $date = $date ?? Carbon::now();
        $dateFrom = $date->copy()->sub('1 year');
        $personStartDate = Carbon::parse($person->start_date);
        if ($personStartDate > $dateFrom) {
            $dateFrom = $personStartDate;
        }

        $sumEarned = SalaryPayment::whereBetween('payment_date', [$dateFrom, $date])
            ->where('person_id', $person->id)
            ->sum('earned');

        $allWorkedDays = CalendarMonth::whereBetween('date', [$dateFrom, $date])
            ->selectRaw('sum(calendar_days - holidays - weekends) as sum')
            ->first()
            ->sum;

        $allVacations = Vacation::whereBetween('date', [$dateFrom, $date])
            ->where('person_id', $person->id)
            ->sum('days');

        $days = $allWorkedDays - $allVacations;

        return $days ? round($sumEarned / $days * $vacations, 2) : null;
    }

    /**
     * Set default final payslip data
     *
     * @param Request $request
     */
    private function setFinalPayslip(Request $request): void
    {
        $this->finalPayslip->person_id = $this->person->id;
        $this->finalPayslip->basic_salary = $this->person->salary;
    }
}
