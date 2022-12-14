<?php

namespace App\Models;

use App\Traits\Addressable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Client extends Model
{
    use SoftDeletes, Addressable, Notifiable;

    public const TABLE_NAME = 'clients';

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
    protected $fillable = ['name', 'company_name', 'email', 'phone'];

    /**
     * Get the contracts for the client.
     */
    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    /**
     * Get only the billing address
     *
     * @return MorphOne
     */
    public function billingAddress()
    {
        return $this->morphOne(Address::class, 'addressable')
            ->where('addressable_type', self::class)
            ->whereNull('deleted_at')
            ->where('is_billing', true);
    }

    /**
     * @return HasOne
     */
    public function bank()
    {
        return $this->hasOne(Bank::class);
    }
}
