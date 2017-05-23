<?php

namespace App\Listeners;

use App\Events\Timeall;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class Timealls
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
     * @param  Timeall  $event
     * @return void
     */
    public function handle(Timeall $event)
    {
      // dd($event->user->name);
    }
}
