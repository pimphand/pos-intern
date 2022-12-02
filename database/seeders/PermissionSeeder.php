<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // membuat seeder permission
            Permission::create([
                "name"          => "dashboard.index",
                "guard_name"    => "api",
            ]);

            Permission::create([
                "name"          => "dashboard.chart_pembelian",
                "guard_name"    => "api",
            ]);

            Permission::create([
                "name"          => "dashboard.chart_penjualan",
                "guard_name"    => "api",
            ]);

            Permission::create([
                "name"          => "dashboard.total_penjualan",
                "guard_name"    => "api",
            ]);

            Permission::create([
                "name"          => "dashboard.stock_product",
                "guard_name"    => "api",
            ]);

            Permission::create([
                "name"          => "permission.index",
                "guard_name"    => "api",
            ]);

            Permission::create([
                "name"          => "roles.index",
                "guard_name"    => "api",
            ]);

            Permission::create([
                "name"          => "roles.store",
                "guard_name"    => "api",
            ]);

            Permission::create([
                "name"          => "roles.update",
                "guard_name"    => "api",
            ]);

            Permission::create([
                "name"          => "roles.destroy",
                "guard_name"    => "api",
            ]);

            Permission::create([
                "name"          => "categories-product.index",
                "guard_name"    => "api",
            ]);

            Permission::create([
                "name"          => "categories-product.store",
                "guard_name"    => "api",
            ]);

            Permission::create([
                "name"          => "categories-product.update",
                "guard_name"    => "api",
            ]);

            Permission::create([
                "name"          => "categories_product.destroy",
                "guard_name"    => "api",
            ]);

            Permission::create([
                "name"          => "categories-message.index",
                "guard_name"    => "api",
            ]);

            Permission::create([
                "name"          => "categories-message.store",
                "guard_name"    => "api",
            ]);

            Permission::create([
                "name"          => "categories-message.update",
                "guard_name"    => "api",
            ]);

            Permission::create([
                "name"          => "categories-message.destroy",
                "guard_name"    => "api",
            ]);

            Permission::create([
                "name"          => "products.index",
                "guard_name"    => "api",
            ]);

            Permission::create([
                "name"          => "products.store",
                "guard_name"    => "api",
            ]);

            Permission::create([
                "name"          => "products.update",
                "guard_name"    => "api",
            ]);

            Permission::create([
                "name"          => "products.destroy",
                "guard_name"    => "api",
            ]);

            Permission::create([
                "name"          => "users.index",
                "guard_name"    => "api",
            ]);

            Permission::create([
                "name"          => "users.store",
                "guard_name"    => "api",
            ]);

            Permission::create([
                "name"          => "users.update",
                "guard_name"    => "api",
            ]);

            Permission::create([
                "name"          => "users.destroy",
                "guard_name"    => "api",
            ]);

            Permission::create([
                "name"          => "stocks.index",
                "guard_name"    => "api",
            ]);

            Permission::create([
                "name"          => "stocks.store",
                "guard_name"    => "api",
            ]);

            Permission::create([
                "name"          => "stocks.update",
                "guard_name"    => "api",
            ]);

            Permission::create([
                "name"          => "stocks.destroy",
                "guard_name"    => "api",
            ]);

            Permission::create([
                "name"          => "selling.index",
                "guard_name"    => "api",
            ]);

            Permission::create([
                "name"          => "setting-printer.index",
                "guard_name"    => "api",
            ]);

            Permission::create([
                "name"          => "shop.index",
                "guard_name"    => "api",
            ]);

            Permission::create([
                "name"          => "shop.update",
                "guard_name"    => "api",
            ]);

            Permission::create([
                "name"          => "purchase.index",
                "guard_name"    => "api",
            ]);

            Permission::create([
                "name"          => "purchase.store",
                "guard_name"    => "api",
            ]);

            Permission::create([
                "name"          => "purchase.update",
                "guard_name"    => "api",
            ]);

            Permission::create([
                "name"          => "purchase.destroy",
                "guard_name"    => "api",
            ]);

            Permission::create([
                "name"          => "kas.index",
                "guard_name"    => "api",
            ]);

            Permission::create([
                "name"          => "report.index",
                "guard_name"    => "api",
            ]);
    }
}
