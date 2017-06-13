<?php

namespace App\Jobs;

use App\Http\Controllers\SendMailController;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendReminderEmail extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $user)
    {
       $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(SendMailController $mail)
    {
        //$mail->mail();
    }
}
