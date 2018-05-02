<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
		 \App\Models\OrderDetail::class => \App\Policies\OrderDetailPolicy::class,
		 \App\Models\Order::class => \App\Policies\OrderPolicy::class,
		 \App\Models\Good::class => \App\Policies\GoodPolicy::class,
		 \App\Models\Category::class => \App\Policies\CategoryPolicy::class,
		 \App\Models\Shop::class => \App\Policies\ShopPolicy::class,
		 \App\Models\Deopt::class => \App\Policies\DeoptPolicy::class,
        'App\Model' => 'App\Policies\ModelPolicy',
        \App\Models\User::class  => \App\Policies\UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
