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
        'long_vacation_started_at' => Date::class,
        'long_vacation_plan_finished_at' => Date::class,
        'long_vacation_finished_at' => Date::class,
        'quited_at' => Date::class,
    ];

    /**
     * @var mixed|null
     */
    private $long_vacation_started_at;
    /**
     * @var mixed|null
     */
    private $long_vacation_reason;
    /**
     * @var mixed|null
     */
    private $long_vacation_compensation;
    /**
     * @var mixed|null
     */
    private $long_vacation_comment;
    /**
     * @var mixed|null
     */
    private $long_vacation_plan_finished_at;
    /**
     * @var mixed|null
     */
    private $long_vacation_finished_at;
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
     * @var mixed|null
     */
    private $long_vacation_compensation_sum;
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vacations()
    {
        return $this->hasMany(Vacation::class);
    }
}
