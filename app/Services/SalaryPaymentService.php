<?php

namespace App\Services;

use App\Enums\Currency;
use App\Enums\SalaryType;
use App\Models\AccountType;
use App\Models\CalendarMonth;
use App\Models\Person;
use App\Models\SalaryPayment;
use App\Models\Vacation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SalaryPaymentService
{
    public $salaryPayment;
    public $calendarMonth;
    public $person;
    public $currencies;
    public $fields;
    public $symbol;

    private $date;

    /**
     * SalaryPaymentService constructor.
     *
     * @param CalendarMonth $calendarMonth
     * @param Collection $people
     * @param Request $request
     * @param Carbon $date
     */
    public function __construct(CalendarMonth $calendarMonth, Collection $people, Request $request, Carbon $date)
    {
        $this->date = $date;
        $this->salaryPayment = new SalaryPayment;
        $this->setCalendarMonth($calendarMonth);
        $this->setPerson($people, $request);

        if ($this->person) {
            $this->setSymbol();
            $this->setFields();
            $this->setCurrencies();
            $this->setVacations();
            $this->fillCalendarMonth();
            $this->fillSalaryPayment();
            $this->setBonuses();
            $this->setTotals();
        }
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
     * @return array
     */
    public function data()
    {
        return [
            $this->calendarMonth,
            $this->salaryPayment,
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
            'overtime_pay' => $this->person->currency,
            'vacation_compensation' => $this->person->currency,
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
        $this->salaryPayment->calendar_month_id = $calendarMonth->id;
        $this->salaryPayment->load('calendarMonth');
    }

    /**
     * @param Collection $people
     * @param $request
     */
    private function setPerson(Collection $people, Request $request): void
    {
        $this->person = $request->has('person_id') ? $people->where('id', $request->input('person_id'))->first() : null;
        if ($this->person) {
            $this->salaryPayment->person_id = $this->person->id;
        }
    }

    private function setSymbol(): void
    {
        $this->symbol = $this->person ? Currency::symbol($this->person->currency) : '';
    }

    private function setVacations(): void
    {
        $vacations = $this->person ? Vacation::where('calendar_month_id', $this->calendarMonth->id)
            ->where('person_id', $this->person->id)
            ->where('payment_type', \App\Enums\VacationPaymentType::Paid)
            ->sum('days') : null;
        $this->salaryPayment->vacations = $vacations;
    }

    private function setCurrencies(): void
    {
        $this->currencies =  AccountType::all(['currency_type', 'currency'])
            ->mapWithKeys(function($accountType) {
                return [$accountType->currency_type => $accountType->currency];
            });
        $this->salaryPayment->currency = $this->currencies[Currency::USD];
    }

    private function fillSalaryPayment(): void
    {
        $this->salaryPayment->vacations_hours = $this->person ? self::calcHours($this->salaryPayment->vacations, $this->person->salary_type) : null;
        $this->salaryPayment->vacation_compensation = $this->person ? self::calcVacationCompensation($this->person, $this->salaryPayment->vacations, $this->date) : null;
        $this->salaryPayment->worked_days = $this->calendarMonth->working_days - $this->salaryPayment->vacations;
        $this->salaryPayment->earned = $this->person ? self::calcEarned($this->salaryPayment, $this->person, $this->calendarMonth) : null;
        $this->salaryPayment->leads = $this->person ? self::calcLeads($this->salaryPayment, $this->person) : null;
    }

    private function fillCalendarMonth(): void
    {
        $this->calendarMonth->working_hours = $this->person ? $this->calendarMonth->getWorkingHours($this->person->salary_type) : null;
    }

    private function setBonuses(): void
    {
        $this->person->actualBonuses = $this->person->getBonuses($this->date);
        $this->person->totalBonusesUSD = self::totalBonusesUSD($this->person, $this->currencies);
    }

    private function setTotals(): void
    {
        $this->salaryPayment->total_usd = self::calcTotalUSD($this->salaryPayment, $this->person, $this->currencies, $this->fields);
        $this->salaryPayment->total_uah = self::convert($this->currencies, Currency::USD, Currency::UAH, $this->salaryPayment->total_usd);
    }

    /**
     * Calculate vacation compensation
     *
     * @param Person      $person
     * @param int         $vacations
     * @param Carbon|null $date
     *
     * @return float|int
     * @throws \Carbon\Exceptions\InvalidFormatException
     */
    private static function calcVacationCompensation(Person $person, int $vacations, Carbon $date = null)
    {
        $date = $date ?? Carbon::now();
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
     * Calculate how much earned
     *
     * @param SalaryPayment $salaryPayment
     * @param Person $person
     * @param CalendarMonth $calendarMonth
     *
     * @return float|int
     */
    private static function calcEarned(SalaryPayment $salaryPayment, Person $person, CalendarMonth $calendarMonth)
    {
        if (SalaryType::isHourly($person->salary_type)) {
            return round($person->rate * $salaryPayment->worked_hours, 2);
        }
        return $calendarMonth->working_hours ? round($person->salary / $calendarMonth->working_days * $salaryPayment->worked_days, 2) : 0;
    }

    /**
     * Calculate leads
     *
     * @param SalaryPayment $salaryPayment
     * @param Person $person
     *
     * @return float|int
     */
    private static function calcLeads(SalaryPayment $salaryPayment, Person $person)
    {
        return $salaryPayment->worked_days ? round(($person->tech_lead_reward + $person->team_lead_reward) / $salaryPayment->worked_days, 2) : 0;
    }

    /**
     * Calculate total USD
     *
     * @param SalaryPayment $salaryPayment
     * @param Person $person
     * @param $currencies
     * @param array $fields
     *
     * @return float
     */
    private static function calcTotalUSD(SalaryPayment $salaryPayment, Person $person, $currencies, array $fields): float
    {
        $total = 0;
        foreach($fields as $field => $currency) {
            $total += self::convertToUSD($currencies, $currency, $salaryPayment->$field);
        }

        $bonuses = self::totalBonusesUSD($person, $currencies);

        return round($total + $bonuses, 2);
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
            return round($person->actualBonuses->reduce(function($carry, $bonus) use ($currencies) {
                    return $carry + $currencies[$bonus->currency] * $bonus->value;
                }, 0) / $currencies[Currency::USD], 2);
        }

        return null;
    }
}
