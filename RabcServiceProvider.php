<?php
namespace Wang\Rabc;

use Illuminate\Support\ServiceProvider;
use Wang\Rabc\Command\Migration;

class RabcServiceProvider extends ServiceProvider {
    
    public function boot()
    {
        // 发布配置
        $this->publishes([
            __DIR__.'/config/rabc.php'=>config_path('rabc.php')
        ]);
        // 注册安装migration命令
        $this->commands('command.rabc.migration');
    }

    public function register()
    {
            $this->app->singleton('command.rabc.migration',function($app){
                return new Migration();
            });
    }
}