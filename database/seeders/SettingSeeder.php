<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::updateOrCreate([
            'key' => 'activity_monthly'
        ], ['value' => '188461']);

        Setting::updateOrCreate([
            'key' => 'activity_yearly'
        ], ['value' => '5806398']);
    }
}
