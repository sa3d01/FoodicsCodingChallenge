<?php

namespace App\Listeners;

use App\Events\SendMail;

class SendMailFired
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\SendMail $event
     * @return void
     */
    public function handle(SendMail $event)
    {
        //todo : notify admin about updating stock
    }
}
