<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name' => 'accrued_interest',
            'is_global' => true,
            'hidden' => true,
            'notifications' => false
        ]);

        DB::table('categories')->insert([
            'name' => 'Uncategorized',
            'is_global' => true,
            'force_subscribe' => true
        ]);
        
        DB::table('categories')->insert([
            'name' => 'Savings',
            'is_global' => true,
            'force_subscribe' => true
        ]);
    }
}
