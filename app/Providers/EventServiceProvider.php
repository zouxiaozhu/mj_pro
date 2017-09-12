<?php

namespace App\Providers;

use App\Http\Controllers\Api\Member\Event\CreditsEvent;
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
        'App\Events\SomeEvent' => [
            'App\Listeners\EventListener',
        ],
        'App\Events\Mail'=>[
            'App\Listeners\SendMail'
        ],
        'App\Events\Trs'=>[
            'App\Listeners\Trs'
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        app('events')->listen('addCredit', CreditsEvent::class);
      //  app('events')->listen('addTrace',);
        parent::boot($events);

        //
    }
}
