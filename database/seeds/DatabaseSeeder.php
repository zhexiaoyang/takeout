<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UsersTableSeeder::class);
		$this->call(OrderDetailsTableSeeder::class);
		$this->call(OrdersTableSeeder::class);
		$this->call(GoodsTableSeeder::class);
		$this->call(CategorysTableSeeder::class);
		$this->call(ShopsTableSeeder::class);
		$this->call(DeoptsTableSeeder::class);
    }
}
