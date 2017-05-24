<?php

namespace App\Listeners;

use App\Events\Mail;
use App\Http\Controllers\SendMailController;
use App\Jobs\SendReminderEmail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;
class SendMail
{
    use DispatchesJobs;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(SendMailController $sendMail)
    {
        $this->sendMail = $sendMail ;
    }

    /**
     * Handle the event.
     *
     * @param  Mail  $event
     * @return void
     */
    public function handle(Mail $event)
    {

         $user  = $event->user->toArray();
         $this->dispatch(new SendReminderEmail($user));

    }
}
