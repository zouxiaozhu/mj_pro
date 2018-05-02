<?php
/**
 * Created by PhpStorm.
 * User: jiuji
 * Date: 2017/9/8
 * Time: 上午9:56
 */
namespace Zfile\Console;
use Illuminate\Console\Command;

class Get extends Command{
    protected $signature = 'get {param}';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get';
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function handle()
    {
    $arg = $this->argument('param');
    $this->line('get over'.$arg);
    }
}