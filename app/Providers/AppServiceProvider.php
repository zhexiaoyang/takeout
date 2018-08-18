<?php

namespace App\Providers;

use App\Models\Order;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Auth;

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
		\App\Models\ShopDetail::observe(\App\Observers\ShopDetailObserver::class);
		\App\Models\MtLog::observe(\App\Observers\MtLogObserver::class);
		\App\Models\OrderDetail::observe(\App\Observers\OrderDetailObserver::class);
		\App\Models\Order::observe(\App\Observers\OrderObserver::class);
		\App\Models\Good::observe(\App\Observers\GoodObserver::class);
		\App\Models\Category::observe(\App\Observers\CategoryObserver::class);
		\App\Models\Shop::observe(\App\Observers\ShopObserver::class);
		\App\Models\Deopt::observe(\App\Observers\DeoptObserver::class);

        view()->composer('*', function ($view) {
            if (Auth::id()) {
                $print_orders = Order::allowShops()->select(['id', 'order_id'])->where('is_print', 0)->where('status', '<', 20)->orderBy('id', 'desc')->get()->toArray();
                $apply_cancels = Order::allowShops()->select(['id', 'order_id'])->where('apply_cancel', '=', 1)->where('cancel_at', '>', date('Y-m-d H:i:s', (strtotime(time() + 1800))))->orderBy('id', 'desc')->get()->toArray();
                $refunds = Order::allowShops()->select(['id', 'order_id'])->where('apply_refund', '=', 1)->where('refund_at', '>', date('Y-m-d H:i:s', (strtotime(time() + 1800))))->orderBy('id', 'desc')->get()->toArray();
                $view->with(compact(['print_orders', 'apply_cancels', 'refunds']));
            }
        });
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
