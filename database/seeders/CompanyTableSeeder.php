<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'company_name' => 'アサヒ',
            'street_address' => 'Hokkaido',
            'representative_name' => 'yasumoto',
        ];
        DB::table('companies')->insert($param);

        $param = [
            'company_name' => 'コカコーラ',
            'street_address' => 'Hokkaido',
            'representative_name' => 'yasumoto',
        ];
        DB::table('companies')->insert($param);

        $param = [
            'company_name' => 'キリン',
            'street_address' => 'Hokkaido',
            'representative_name' => 'yasumoto',
        ];
        DB::table('companies')->insert($param);

        $param = [
            'company_name' => 'DyDo',
            'street_address' => 'Hokkaido',
            'representative_name' => 'yasumoto',
        ];
        DB::table('companies')->insert($param);
    }
}
