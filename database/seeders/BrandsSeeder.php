<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BrandsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brand = DB::table('brands')->insert([
            'name' => 'Avis',
            'display_order' => 1,
            'active' => 1
        ]);

        $brand = DB::table('brands')->insert([
            'name' => 'Budget',
            'display_order' => 2,
            'active' => 1
        ]);

        $brand = DB::table('brands')->insert([
            'name' => 'Payless',
            'display_order' => 3,
            'active' => 1
        ]);
    }
}
