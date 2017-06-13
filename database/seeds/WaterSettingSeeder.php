<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WaterSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $water = [
            'id'          => 1,
            'name'        => '紧贴右下角',
            'width'       => 10.00,
            'height'      => 10.00,
            'bottom_top'  => 0.00,
            'bottom_left' => 0.00,
            'water_path'  => '/Users/jiuji/Desktop/test1.jpg'];

        if (!DB::table('water_setting')->count()) {
            DB::table('water_setting')->insert($water);
        }
    }
}
