<?php

namespace App\Listeners;

use App\Events\BillEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class BillEventListener implements ShouldQueue
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
     * @param  BillEvent  $event
     * @return void
     */
    public function handle(BillEvent $event)
    {
        $this->release(15);
    }
}
