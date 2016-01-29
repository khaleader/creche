<?php

namespace App\Listeners;

use App\Events\EssaiOfficielEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EssaiOfficielEventListener
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
     * @param  EssaiOfficielEvent  $event
     * @return void
     */
    public function handle(EssaiOfficielEvent $event)
    {
        //
    }
}
