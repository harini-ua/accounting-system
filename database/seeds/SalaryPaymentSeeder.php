<?php

use App\Enums\Position;
use App\Enums\SalaryType;
use App\Enums\VacationPaymentType;
use App\Models\AccountType;
use App\Models\CalendarMonth;
use App\Models\Person;
use App\Models\SalaryPayment;
use App\Services\SalaryPaymentService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;

class SalaryPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        $people = Person::with('vacations')->get();
        $accountTypes = AccountType::with('accounts')
            ->where('name', '!=', 'Deposit UAH')
            ->get();

        $months = array_map(function ($month) {
            return $month->monthName;
        }, CarbonPeriod::create(Carbon::now()->startOfYear(), '1 month', Carbon::now())->toArray());
        $calendarMonths = CalendarMonth::with('calendarYear')
            ->whereIn('name', $months)
            ->get();

        $salaryPayments = [];

        foreach ($people as $person) {
            foreach ($calendarMonths as $calendarMonth) {
                $paymentDate = Carbon::parse($calendarMonth->name);
                $accountType = $accountTypes
                    ->where('name', $person->currency)
                    ->first();
                $vacations = $person
                    ->vacations
                    ->where('calendar_month_id', $calendarMonth->id)
                    ->where('payment_type', VacationPaymentType::Paid)
                    ->count();

                $salaryPayments[] = factory(SalaryPayment::class)->make([
                    'person_id' => $person->id,
                    'calendar_month_id' => $calendarMonth->id,
                    'account_id' => $accountType->accounts->random()->id,
                    'worked_days' => function () use ($calendarMonth, $vacations) {
                        return $calendarMonth->workingDays - $vacations;
                    },
                    'earned' => function ($salaryPayment) use ($person, $calendarMonth, $vacations) {
                        if (SalaryType::isHourly($person->salary_type)) {
                            return round($person->rate * $salaryPayment['worked_hours'], 2);
                        }
                        return round($person->salary / $calendarMonth->getWorkingHours($person->salary_type) * ($salaryPayment['worked_hours'] - $vacations), 2);
                    },
                    'vacations' => $vacations ?: null,
                    'vacation_compensation' => $vacations ? SalaryPaymentService::calcHours($vacations, $person->salary_type) * $person->rate : null,
                    'bonuses' => function () use ($person) {
                        if ($person->position_id == Position::SalesManager || $person->position_id == Position::Recruiter) {
                            return json_encode([
                                'USD' => random_int(10, 200),
                                'UAH' => random_int(300, 6000),
                                'EUR' => random_int(10, 200),
                            ]);
                        }
                    },
                    'currency' => $accountType->currency,
                    'payment_date' => random_int(0, 3) ? $paymentDate : null,
                ])->toArray();
            }
        }

        SalaryPayment::insert($salaryPayments);
    }
}
