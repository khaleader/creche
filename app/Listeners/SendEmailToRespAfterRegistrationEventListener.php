<?php

namespace App\Listeners;

use App\Events\SendEmailToRespAfterRegistrationEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailToRespAfterRegistrationEventListener implements ShouldQueue
{

    use InteractsWithQueue;
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
     * @param  SendEmailToRespAfterRegistrationEvent  $event
     * @return void
     */
    public function handle(SendEmailToRespAfterRegistrationEvent $event)
    {
        $this->release(10);
         $this->delete();



    }
}
