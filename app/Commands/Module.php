<?php

namespace App\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\SelfHandling;

class Module extends Command implements SelfHandling
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module {module-name} {--queue=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'make a new module';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $module_name = ucfirst(trim($this->argument('module-name')));
        if($module_name){

        }

        $bool = $this->confirm('你要开始创建新的模块吗[y|N]');
        if(!$bool){
            $this->line('关闭创建新模块');
        }
        $app_path = app_path();
        exec(" cd $app_path && mkdir $module_name && cd {$module_name} && mkdir Console Events Exceptions Jobs Listeners Models Controllers Presenters Providers Repositories Transformers Validators && touch {$module_name}.php");
        $this->info('创建新模块'.$module_name.'完成');
    }


}
