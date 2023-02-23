<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\AgentCashWithdrawal;
use Ramsey\Uuid\Uuid;

class AgentCashWithdrawalObserver
{
    public function creating(AgentCashWithdrawal $agentCashWithdrawal)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (AgentCashWithdrawal::where('uuid', $uuid)->exists());
        if (! $agentCashWithdrawal->uuid) {
            $agentCashWithdrawal->uuid = $uuid;
        }
    }

    /**
     * Handle the agent "created" event.
     *
     * @return void
     */
    public function created(AgentCashWithdrawal $agentCashWithdrawal)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @return void
     */
    public function updated(AgentCashWithdrawal $agentCashWithdrawal)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @return void
     */
    public function deleted(AgentCashWithdrawal $agentCashWithdrawal)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @return void
     */
    public function restored(AgentCashWithdrawal $agentCashWithdrawal)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(AgentCashWithdrawal $agentCashWithdrawal)
    {
        //
    }
}
