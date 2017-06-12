<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

class Inspire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inspire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display an inspiring quote';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $preg = '/^\d{0,1}\+[a-z]{0,}./is';
        $matc = preg_match($preg,'0+a');
        $this->info(11111);
        //$this->comment(PHP_EOL.Inspiring::quote().PHP_EOL);
    }
}
