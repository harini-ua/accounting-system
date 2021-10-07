<?php

namespace App\Models;

use App\Casts\Date;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FinalPayslip extends Model
{
    public const TABLE_NAME = 'final_payslip';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'person_id',
        'last_working_day',
        'working_days',
        'worked_days',
        'working_hours',
        'worked_hours',
        'basic_salary',
        'earned',
        'bonuses',
        'vacations',
        'vacation_compensation',
        'leads',
        'monthly_bonus',
        'fines',
        'tax_compensation',
        'other_compensation',
        'total_usd',
        'total',
        'account_id',
        'paid',
        'comments',
    ];

    protected $casts = [
        'last_working_day' => Date::class,
        'bonuses' => 'object',
        'paid' => 'bool'
    ];

    /**
     * Get the employee that owns the final payslip.
     */
    public function employee()
    {
        return $this->belongsTo(Person::class, 'person_id', 'id');
    }

    /**
     * Get the account that owns the final payslip.
     *
     * @return BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
