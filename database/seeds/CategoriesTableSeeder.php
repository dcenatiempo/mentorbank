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
            'standard' => true,
            'hidden' => true,
            'notifications' => false
        ]);

        DB::table('categories')->insert([
            'name' => 'Uncategorized',
            'standard' => true
        ]);
        
        DB::table('categories')->insert([
            'name' => 'General',
            'standard' => true
        ]);
    }
}
