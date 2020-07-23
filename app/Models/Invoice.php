<?php

namespace App\Models;

use App\Casts\Date;
use App\Casts\InvoiceNumber;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    public const TABLE_NAME = 'invoices';

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
    protected $fillable = ['number', 'client_id', 'contract_id', 'wallet_id', 'date', 'plan_income_date', 'status', 'type'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'number' => InvoiceNumber::class,
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'date' => Date::class,
        'plan_income_date' => Date::class,
    ];

    /**
     * Invoice constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->casts['date'] = Date::class.':'.config('invoices.date.format');

        parent::__construct($attributes);
    }

    /**
     * Get the client that owns the invoice.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the contract that owns the invoice.
     */
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    /**
     * Get the account that owns the contract.
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the items for the blog invoice.
     */
    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    /**
     * Get the sales manager for invoice.
     */
    public function salesManager()
    {
        return $this->belongsTo(User::class, 'sales_manager_id');
    }
}
