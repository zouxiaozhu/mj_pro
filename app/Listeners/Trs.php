<?php

namespace App\Listeners;

use App\Events\Trs;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class Trs
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
     * @param  Trs  $event
     * @return void
     */
    public function handle(Trs $event)
    {
        $user = $event->user;

    }
}
