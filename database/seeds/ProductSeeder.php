<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 5 ; $i++) {
            DB::table('products')->insert([
                'name' => Str::random(10),
                'product_num' => random_int(50, 200),
                'callorie_num' => random_int(300, 500),
                'counting_type' => true,
                'callorie_total' => random_int(300, 500),
                'user_id' => random_int(1, 25)
            ]);
        }
    }
}
