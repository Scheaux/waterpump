<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Period;
use App\Models\PumpMeterRecord;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        Period::makeNewPeriod();

        User::create([
            'name' => 'admin',
            'email' => 'admin@test',
            'password' => bcrypt('admin'),
        ]);

        PumpMeterRecord::create([
            'period_id' => 1,
            'amount_volume' => 8721638.55
        ]);
    }
}
