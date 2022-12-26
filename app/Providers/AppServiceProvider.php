<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //使用するページネーションのデザインCSSの設定
        //app/resources/views/vendor/pagination/のどれかまたはカスタムファイル
        Paginator::defaultView('pagination::bootstrap-4');
    }
}
