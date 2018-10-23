<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Auth;
use Cache;

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
                $print_orders = [];
                $apply_cancels = [];
                $refunds = [];

//                $print_orders = Order::allowShops()->select(['id', 'order_id'])->where('is_print', 0)->where('status', '<', 20)->orderBy('id', 'desc')->get()->toArray();
//                $apply_cancels = Order::allowShops()->select(['id', 'order_id'])->where('apply_cancel', '=', 1)->where('cancel_at', '>', date('Y-m-d H:i:s', (time() - 1800)))->orderBy('id', 'desc')->get()->toArray();
//                $refunds = Order::allowShops()->select(['id', 'order_id'])->where('apply_refund', '=', 1)->where('refund_at', '>', date('Y-m-d H:i:s', (time() - 1800)))->orderBy('id', 'desc')->get()->toArray();

                $_print_orders = Cache::remember('is_print', 2, function () {
                    return Order::with('shop')->select(['id', 'order_id', 'shop_id'])->where('is_print', 0)->where('status', '<', 20)->orderBy('id', 'desc')->get()->toArray();
                });

                $_apply_cancels = Cache::remember('apply_cancel', 2, function () {
                    return Order::with('shop')->select(['id', 'order_id', 'shop_id'])->where('apply_cancel', '=', 1)->where('cancel_at', '>', date('Y-m-d H:i:s', (time() - 1800)))->orderBy('id', 'desc')->get()->toArray();
                });

                $_refunds = Cache::remember('apply_refund', 2, function () {
                    return Order::with('shop')->select(['id', 'order_id', 'shop_id'])->where('apply_refund', '=', 1)->where('refund_at', '>', date('Y-m-d H:i:s', (time() - 1800)))->orderBy('id', 'desc')->get()->toArray();
                });

                $user_yids = User::find(Auth::id())->shopIds();

                if (Auth::user()->hasPermissionTo('manage_users'))
                {
                    $print_orders = $_print_orders;
                    $apply_cancels = $_apply_cancels;
                    $refunds = $_refunds;
                }else{

                    if (is_array($user_yids) && !empty($user_yids))
                    {
                        if (is_array($_print_orders) && !empty($_print_orders))
                        {
                            foreach ($_print_orders as $print_order) {
                                if (in_array($print_order['shop_id'], $user_yids))
                                {
                                    $print_orders[] = $print_order;
                                }
                            }
                        }

                        if (is_array($_apply_cancels) && !empty($_apply_cancels))
                        {
                            foreach ($_apply_cancels as $apply_cancel) {
                                if (in_array($apply_cancel['shop_id'], $user_yids))
                                {
                                    $apply_cancels[] = $apply_cancel;
                                }
                            }
                        }

                        if (is_array($_refunds) && !empty($_refunds))
                        {
                            foreach ($_refunds as $refund) {
                                if (in_array($refund['shop_id'], $user_yids))
                                {
                                    $refunds[] = $refund;
                                }
                            }
                        }
                    }
                }

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
