<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $region = DB::table('regions')->insert([
            'code' => 'NAM',
            'name' => 'North America & Canada',
            'display_order' => 1
        ]);

        $region = DB::table('regions')->insert([
            'code' => 'EMEA',
            'name' => 'Europe, Middle East and Africa',
            'display_order' => 2
        ]);

        $region = DB::table('regions')->insert([
            'code' => 'LAC',
            'name' => 'Latin America & the Caribbean',
            'display_order' => 3
        ]);

        $region = DB::table('regions')->insert([
            'code' => 'APAC',
            'name' => 'Asia Pacific',
            'display_order' => 4
        ]);
    }
}
