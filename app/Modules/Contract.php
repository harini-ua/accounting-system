<?php

namespace App\Modules;

use App\Enums\ContractStatus;
use App\User;
use BenSampo\Enum\Traits\CastsEnums;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use SoftDeletes, CastsEnums;

    public const TABLE_NAME = 'contracts';

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
    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'client_id', 'comment', 'sales_manager_id', 'status', 'closed_at'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'closed_at',
    ];

//    /**
//     * The attributes that are enum casting.
//     *
//     * @var array
//     */
//    protected $enumCasts = [
//        'status' => ContractStatus::class,
//    ];

    /**
     * Get the client that owns the contract.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the client that owns the contract.
     */
    public function manager()
    {
        return $this->belongsTo(User::class, 'sales_manager_id', 'id');
    }

    /**
     * Scope a query by status contract.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string                                status
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
