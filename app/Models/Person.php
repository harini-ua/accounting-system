<?php

namespace App\Models;

use App\Casts\Date;
use App\Enums\Position;
use App\User;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Person extends Model
{
    use SoftDeletes;

    public const TABLE_NAME = 'people';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => Date::class,
        'contract_type_changed_at' => Date::class,
        'salary_type_changed_at' => Date::class,
        'salary_changed_at' => Date::class,
        'tech_lead' => 'boolean',
        'team_lead' => 'boolean',
        'bonuses' => 'boolean',
        'long_vacation_started_at' => Date::class,
        'long_vacation_plan_finished_at' => Date::class,
        'long_vacation_finished_at' => Date::class,
        'quited_at' => Date::class,
        'compensated_at' => Date::class,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account_number', 'agreement', 'available_vacations', 'bonuses', 'bonuses_reward', 'certifications', 'code',
        'compensate', 'compensated_at', 'compensated_days', 'department', 'end_trial_period_date', 'growth_plan',
        'last_salary', 'name', 'note_salary_pay', 'position_id', 'quited_at', 'quit_reason', 'rate', 'recipient_bank',
        'recruiter_id', 'salary', 'salary_changed_at', 'salary_change_reason', 'salary_type', 'salary_type_changed_at',
        'skills', 'start_date', 'team_lead', 'team_lead_reward', 'tech_lead', 'tech_lead_reward', 'trial_period',
        'updated_at', 'contract_type', 'contract_type_changed_at', 'created_at', 'currency', 'deleted_at', 'user_id'
    ];

    /**
     * The array of booted models.
     *
     * @var array
     */
    protected static function booted()
    {
        static::creating(function ($person) {
            $startDate = Carbon::parse($person->start_date);
            if (!$startDate->isCurrentYear()) {
                $startCurrentYear = Carbon::now()->startOfYear();
                $person->available_vacations = $startCurrentYear
                        ->diffInMonths(Carbon::createFromDate($startCurrentYear->year, $startDate->month, $startDate->day)) * 1.25;
            }
        });

        static::saving(function ($person) {
            $hoursInWeek = (int)filter_var($person->salary_type, FILTER_SANITIZE_NUMBER_INT);

            if (empty($hoursInWeek)) {
                $hoursInWeek = 40;
            }
            $hoursInMonth = $hoursInWeek * 4;
            $newRate = $person->salary / $hoursInMonth;
            $person->rate = $newRate;

            if ($person->isDirty(['start_date', 'trial_period'])) {
                $trialPeriod = ($person->trial_period) ?? config('people.trial_period.value');
                $person->end_trial_period_date = \Carbon\Carbon::parse($person->start_date)->addMonths($trialPeriod);
            }
        });
    }

    /*
     * ***********************************
     * Relations
     * ***********************************
     */

    /**
     * Get the user that owns the person.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function position()
    {
        return $this->belongsTo(\App\Models\Position::class);
    }

    /**
     * Get the recruiter that owns the person.
     *
     * @return BelongsTo
     */
    public function recruiter()
    {
        return $this->belongsTo(Person::class)->where('position_id', Position::Recruiter);
    }

    /**
     * Get the hired people by the person.
     *
     * @return HasMany
     */
    public function candidates()
    {
        return $this->hasMany(Person::class, 'recruiter_id', 'id');
    }

    /**
     * Get the certifications that owns the person.
     *
     * @return HasMany
     */
    public function certifications()
    {
        return $this->hasMany(Certification::class);
    }

    /**
     * Scope a query to only include people with bonuses.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeIsBonuses($query)
    {
        return $query->where('bonuses', true);
    }

    /**
     * Scope a query to only include former people.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeFormer($query)
    {
        return $query->whereNotNull('quited_at');
    }

    /**
     * Scope a query user by position.
     *
     * @param Builder $query
     * @param integer $positionId
     *
     * @return Builder
     */
    public function scopeByPosition($query, $positionId)
    {
        return $query->where('position_id', $positionId);
    }

    /**
     * @return HasMany
     */
    public function vacations()
    {
        return $this->hasMany(Vacation::class);
    }

    /**
     * @return HasMany
     */
    public function longVacations()
    {
        return $this->hasMany(LongVacation::class);
    }

    /**
     * @return HasMany
     */
    public function latestVacations()
    {
        return $this->longVacations()
            ->whereNull('long_vacation_finished_at')
            ->latest();
    }

    /**
     * Get the offer that owns the person.
     *
     * @return HasOne
     */
    public function offer()
    {
        return $this->hasOne(Offer::class, 'employee_id', 'id');
    }

    /**
     * Get the final payslip that owns the person.
     *
     * @return HasOne
     */
    public function finalPayslip()
    {
        return $this->hasOne(FinalPayslip::class, 'person_id', 'id');
    }

    /**
     * Get the salary reviews that owns the person.
     *
     * @return HasMany
     */
    public function salaryReviews()
    {
        return $this->hasMany(SalaryReview::class, 'person_id', 'id');
    }

    /**
     * Get the salary payment that owns the person.
     *
     * @return HasMany
     */
    public function salary()
    {
        return $this->hasMany(SalaryPayment::class, 'person_id', 'id');
    }

    /*
     * ***********************************
     * Methods
     * ***********************************
     */

    /**
     * @return Model|HasMany|object|null
     */
    public function lastLongVacation()
    {
        if (!array_key_exists('latestVacations', $this->relations)) {
            $this->load('latestVacations');
        }

        return $this->latestVacations->first();
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function lastLongVacationOrNew(array $attributes)
    {
        return $this->latestVacations()->firstOrNew($attributes);
    }

    /**
     * @param int $month
     *
     * @return \Carbon\Carbon
     * @throws InvalidFormatException
     */
    public function getCompensationDate(int $month): \Carbon\Carbon
    {
        $date = Carbon::now()->setMonth($month)->startOfMonth();

        $holidays = Holiday::ofYear($date->year)
            ->whereMonth('date', $month)
            ->get(['date', 'name', 'moved_date'])
            ->map(function ($holiday) {
                return Carbon::parse($holiday->moved_date ?: $holiday->date)->day;
            })->toArray();

        $vacations = $this->vacations()
            ->whereYear('date', $date->year)
            ->whereMonth('date', $month)
            ->get()
            ->map(function ($vacation) {
                return Carbon::parse($vacation->date)->day;
            })->toArray();

        $busyDays = array_merge($holidays, $vacations);

        while ($date->isWeekend() || in_array($date->day, $busyDays)) {
            $date->addDay();
        }

        return $date;
    }

    /**
     * @param Carbon|null $date
     * @return Collection|null
     */
    public function getBonuses(Carbon $date = null)
    {
        $date = $date ?? Carbon::now();
        $from = $date->sub('1 month')->startOfMonth();
        $to = $from->copy()->endOfMonth();

        if ($this->position_id == Position::SalesManager) {
            $result = DB::table('payments')
                ->selectRaw('sum(payments.received_sum) as value, account_types.currency_type as currency')
                ->join('invoices', 'invoices.id', '=', 'payments.invoice_id')
                ->join('people', 'people.id', '=', 'invoices.sales_manager_id')
                ->join('accounts', 'accounts.id', '=', 'invoices.account_id')
                ->join('account_types', 'account_types.id', '=', 'accounts.account_type_id')
                ->where('people.id', $this->id)
                ->whereBetween('payments.date', [$from, $to])
                ->groupBy('account_types.id')
                ->get();

            return $result->mapToGroups(function ($bonus) {
                return [$bonus->currency => $bonus];
            })->map(function ($bonuses, $currency) {
                return (object)[
                    'currency' => $currency,
                    'value' => $bonuses->sum('value') / 100 * $this->bonuses_reward,
                ];
            });
        }

        if ($this->position_id == Position::Recruiter) {
            $result = DB::table('people')
                ->selectRaw('sum(salary) as value, currency')
                ->where('recruiter_id', $this->id)
                ->where(function ($query) use ($from, $to) {
                    $query->whereBetween('start_date', [$from, $to])
                        ->orWhere(function ($query) use ($from) {
                            $from = $from->copy()->sub('2 months');
                            $to = $from->copy()->endOfMonth();
                            $query->whereBetween('start_date', [$from, $to])
                                ->where(function ($query) {
                                    $query->whereNull('quited_at')
                                        ->orWhereRaw('quited_at > date_add(start_date, interval 2 month)');
                                });
                        });
                })
                ->groupBy('currency')
                ->get();

            return $result->map(function ($bonus) {
                return (object)[
                    'currency' => $bonus->currency,
                    'value' => $bonus->value / 100 * $this->bonuses_reward,
                ];
            });
        }

        return null;
    }
}
