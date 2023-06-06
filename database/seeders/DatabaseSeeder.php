<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Bill;
use App\Models\Period;
use App\Models\PumpMeterRecord;
use App\Models\Resident;
use App\Models\User;
use DateTime;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Resident::factory(100)->create();

        $begin = new DateTime(date('Y-m-1'));
        $end = new DateTime(date('Y-m-t'));
        $end->setTime(23, 59, 59);
        $begin->modify('-2 months');
        $end->modify('-2 months');


        for ($i = 0; $i < 6; $i++) {
            $begin->modify('+1 months');
            $end->modify('+1 months');
            Period::create([
                'begin_date' => $begin->getTimestamp(),
                'end_date' => $end->getTimestamp(),
                'date' => $begin->format('Y-m')
            ]);
        }

        User::create([
            'name' => 'admin',
            'email' => 'admin@test',
            'password' => bcrypt('admin'),
        ]);

        PumpMeterRecord::create([
            'period_id' => 1,
            'amount_volume' => 8721638.55
        ]);

        for ($i = 1; $i <= 100; $i++) {
            Bill::create([
                'resident_id' => $i,
                'period_id' => 1,
                'amount_rub' => fake()->randomFloat(2, 250, 1500)
            ]);
        }
    }
}
