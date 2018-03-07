<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        if (App::environment() == 'local') {
            // 本地开发环境增加local日志记录
            DB::listen(function ($query) {
                Log::info('db select', [
                    'sql'          => $query->sql,
                    'sql_bindings' => $query->bindings,
                    'sql_time'     => $query->time
                ]);
            });

        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
