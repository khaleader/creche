<?php

namespace App\Listeners;

use App\Events\ReglerBillEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReglerBillEventListener implements ShouldQueue
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
     * @param  ReglerBillEvent  $event
     * @return void
     */
    public function handle(ReglerBillEvent $event)
    {
      $this->release(10);
    }
}
