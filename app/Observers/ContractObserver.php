<?php

namespace App\Observers;

use App\Enums\ContractStatus;
use App\Models\Contract;

class ContractObserver
{
    /**
     * Handle the contract "creating" event.
     *
     * @param Contract $contract
     * @return void
     */
    public function creating(Contract $contract)
    {
        if ($contract->status === ContractStatus::CLOSED) {
            $contract->closed_at = now();
        }
    }

    /**
     * Handle the contract "updating" event.
     *
     * @param Contract $contract
     * @return void
     */
    public function updating(Contract $contract)
    {
        if ($contract->status === ContractStatus::CLOSED && $contract->isDirty('status')) {
            $contract->closed_at = now();
        }
    }
}
