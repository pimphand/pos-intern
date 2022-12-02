<?php

namespace App\Providers;

use App\Models\Role;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // akses untuk admin
        Gate::before(function($user,$ability){
            return $user->hasRole('admin') ? true : null;
        });

        // akses untuk cashier
        Gate::define('isCashier', function($user){
            return $user->hasRole('cashier');
        });


        // akses dashboard index
        Gate::define('dashboard.index', function ($user) {
            return $user->hasPermission('dashboard.index');
        });

        // akses permission
        Gate::define('permission.index', function ($user) {
            return $user->hasPermissionTo('permission.index');
        });

        // akses role
        Gate::define('role', function($user) {
            return $user->hasAnyPermission([
                'roles.index',
                'roles.store',
                'roles.update',
                'roles.destroy'
            ]);
        });

        // akses kategori produk
        Gate::define('categories-product', function($user){
            return $user->hasAnyPermission([
                'categories-product.index',
                'categories-product.store',
                'categories-product.update',
                'categories-product.destroy'
            ]);
        });

        // akses produk
        Gate::define('product', function($user){
            return $user->hasAnyPermission([
                'product.index',
                'product.store',
                'product.update',
                'product.destroy'
            ]);
        });

        // akses user
        Gate::define('user', function($user){
            return $user->hasAnyPermission([
                'users.index',
                'users.store',
                'users.update',
                'users.destroy'
            ]);
        });

        // akses stok
        Gate::define('stock', function($user){
            return $user->hasAnyPermission([
                'stocks.index',
                'stocks.store',
                'stocks.update',
                'stocks.destroy'
            ]);
        });

        // akses penjualan
        Gate::define('selling', function($user){
            return $user->hasPermissionTo([
                'selling.index'
            ]);
        });

        // akses pembelian
        Gate::define('purchase', function($user){
            return $user->hasAnyPermission([
                'purchase.index',
                'purchase.store',
                'purchase.update',
                'purchase.destroy'
            ]);
        });

        // akses shop atau toko
        Gate::define('shop', function($user){
            return $user->hasAnyPermission([
                'shop.index',
                'shop.update'
            ]);
        });

        // akses kas
        Gate::define('kas', function($user){
            return $user->hasPermissionTo([
                'kas.index'
            ]);
        });

        // akses laporan
        Gate::define('report', function($user){
            return $user->hasPermissionTo('report.index');
        });


    }
}
