<?php

namespace App\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\SelfHandling;

class Apimodule extends Command implements SelfHandling
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:api-module {module-name}';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'make a new api-module';
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
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
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        $module_name = ucfirst(trim($this->argument('module-name')));
        if(!$module_name){
            return $this->line('缺少模块名 失败');
        }
    
        $bool = $this->confirm('你要开始创建新的对外模块吗[y|N]');
        if(!$bool){
            return $this->line('关闭创建新对外模块');
        }
        $app_path = app_path();
        $api_module_path = $app_path.'/Http/Controllers/Api';
        exec(" cd $api_module_path && mkdir $module_name && cd {$module_name} && mkdir Console Events Jobs Listeners  Controllers Providers Repositories && touch {$module_name}.php");
        $this->info('创建新模块'.$module_name.'完成');
    }
}
