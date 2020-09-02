<?php

namespace App\Models;

use App\Casts\Date;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\Position;
use Illuminate\Support\Carbon;

class Person extends Model
{
    use SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];

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
    ];

    /**
     * @var int|mixed
     */
    private $growth_plan;
    /**
     * @var int|mixed
     */
    private $team_lead;
    /**
     * @var int|mixed
     */
    private $team_lead_reward;
    /**
     * @var int|mixed
     */
    private $tech_lead;
    /**
     * @var int|mixed
     */
    private $bonuses;
    /**
     * @var int|mixed
     */
    private $tech_lead_reward;
    /**
     * @var int|mixed
     */
    private $bonuses_reward;
    /**
     * @var mixed
     */
    private $currency;
    /**
     * @var mixed|null
     */
    private $quited_at;
    /**
     * @var mixed|null
     */
    private $quit_reason;

    protected static function booted()
    {
        static::creating(function ($person) {
            $startDate = Carbon::parse($person->start_date);
            if (!$startDate->isCurrentYear()) {
                $startCurrentYear = Carbon::now()->startOfYear();
                $person->available_vacations = $startCurrentYear
                    ->diffInMonths(Carbon::createFromDate($startCurrentYear->year, $startDate->month, $startDate->day))  * 1.25;
            }
        });
        static::saving(function ($person) {
            $person->rate = round($person->salary / 160, 2);
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function position()
    {
        return $this->belongsTo(\App\Models\Position::class);
    }

    /**
     * Get the recruiter that owns the person.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recruiter()
    {
        return $this->belongsTo(User::class)->where('position_id', Position::Recruiter());
    }

    /**
     * Get the certifications that owns the person.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function certifications()
    {
        return $this->hasMany(Certification::class);
    }

    /**
     * Get the bonuses that owns the person.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function bonus()
    {
        return $this->hasOne(Bonus::class);
    }

    /**
     * Scope a query to only include people with bonuses.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsBonuses($query)
    {
        return $query->where('bonuses', true);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vacations()
    {
        return $this->hasMany(Vacation::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function longVacations()
    {
        return $this->hasMany(LongVacation::class);
    }

    public function latestVacations()
    {
        return $this->longVacations()
            ->whereNull('long_vacation_finished_at')
            ->latest();
    }

    /*
     * ***********************************
     * Methods
     * ***********************************
     */

    /**
     * @return Model|\Illuminate\Database\Eloquent\Relations\HasMany|object|null
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

}
