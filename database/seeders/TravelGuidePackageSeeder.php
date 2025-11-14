<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TravelGuidePackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $packages = 
        [
            ['name' => 'P'],
            ['name' => 'EB'],
            ['name' => 'A'],
            ['name' => 'V'],
            ['name' => 'C'],
            ['name' => 'S'],
            ['name' => 'FB'],
            ['name' => 'GMR'],
            ['name' => 'EM'],
        ];

        DB::table('travel_guide_packages')->insert($packages);
    }
}
