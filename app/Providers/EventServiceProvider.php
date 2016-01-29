<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\SendEmailToRespAfterRegistrationEvent' => [
            'App\Listeners\SendEmailToRespAfterRegistrationEventListener',
        ],
        'App\Events\SchoolSendEmailEvent' => [
            'App\Listeners\SchoolSendEmailListener'
        ],
        'App\Events\BillEvent' => [
            'App\Listeners\BillEventListener'
        ],
        'App\Events\ReglerBillEvent' => [
            'App\Listeners\ReglerBillEventListener'
        ],
        'App\Events\EssaiOfficielEvent' => [
            'App\Listeners\EssaiOfficielEventListener'
        ]
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
