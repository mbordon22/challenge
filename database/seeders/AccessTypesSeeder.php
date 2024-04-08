<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AccessTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $access_type = DB::table('access_types')->insert([
            'code' => 'A',
            'name' => 'Cliente Final',
            'display_order' => 1
        ]);

        $access_type = DB::table('access_types')->insert([
            'code' => 'B',
            'name' => 'Agencia',
            'display_order' => 2
        ]);

        $access_type = DB::table('access_types')->insert([
            'code' => 'C',
            'name' => 'Corporativo',
            'display_order' => 3
        ]);
    }
}
