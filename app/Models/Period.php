<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    use HasFactory;

    protected $fillable = [
        'begin_date',
        'end_date',
        'rate_rub',
        'date'
    ];

    static function makeNewPeriods($amount)
    {
        $period = Period::all()->last();



        for ($i = 1; $i <= $amount; $i++) {
            $date = new DateTime();
            $date->setTimestamp($period->begin_date);
            $date->modify("+$i months");
            Period::create([
                'begin_date' => $date->modify('first day of this month')->getTimestamp(),
                'end_date' => $date->modify('last day of this month')->getTimestamp(),
                'date' => $date->format('Y-m')
            ]);
        }
    }
}
