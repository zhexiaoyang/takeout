<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
		\App\Models\User::observe(\App\Observers\UserObserver::class);
		\App\Models\Good::observe(\App\Observers\GoodObserver::class);
		\App\Models\Category::observe(\App\Observers\CategoryObserver::class);
		\App\Models\Shop::observe(\App\Observers\ShopObserver::class);
		\App\Models\Deopt::observe(\App\Observers\DeoptObserver::class);

        //
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
