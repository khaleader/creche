<?php

namespace App\Listeners;

use App\Events\SchoolSendEmailEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SchoolSendEmailListener implements ShouldQueue
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
     * @param  SchoolSendEmailEvent  $event
     * @return void
     */
    public function handle(SchoolSendEmailEvent $event)
    {
        //
    }
}
