<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\Journal;
use Ramsey\Uuid\Uuid;

class JournalObserver
{
    public function creating(Journal $journal)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (Journal::where('uuid', $uuid)->exists());
        if (! $journal->uuid) {
            $journal->uuid = $uuid;
        }
    }

    /**
     * Handle the agent "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\Journal  $journal
     * @return void
     */
    public function created(Journal $journal)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @param  \Gmedia\IspSystem\Models\Journal  $journal
     * @return void
     */
    public function updated(Journal $journal)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\Journal  $journal
     * @return void
     */
    public function deleted(Journal $journal)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @param  \Gmedia\IspSystem\Models\Journal  $journal
     * @return void
     */
    public function restored(Journal $journal)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\Journal  $journal
     * @return void
     */
    public function forceDeleted(Journal $journal)
    {
        //
    }
}
