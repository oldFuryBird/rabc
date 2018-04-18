<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/18 0018
 * Time: 下午 3:52
 */

namespace Rabc\Command;


use Illuminate\Console\Command;
use Rabc\RabcServiceProvider;
class Migration extends Command
{
    protected $signature = "rabc:install";

    protected $description=" migrate the database";

    public function handle()
    {

        $migratePath = substr(__DIR__,strlen(base_path().DIRECTORY_SEPARATOR)).'/../database/migrations';
        $this->info('run vendor:publish');
        // Wang\Rabc\RabcServiceProvider::class not work
        // \Wang\Rabc\RabcServiceProvider::class
        $this->call('vendor:publish', ['--provider' => RabcServiceProvider::class]);
        $this->info('migrate tables');
        $this->call('migrate',['--path'=>$migratePath]);
        $this->info('sucess installed');
    }
}