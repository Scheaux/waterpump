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
        'rate_rub'
    ];

    static function makeNewPeriod()
    {
        $period = Period::latest()->first();
        $begin = new DateTime(date('Y-m-1'));
        $end = new DateTime(date('Y-m-t'));
        $end->setTime(23, 59, 59);
        if (isset($period)) {
            $id = $period->id;
            Period::create([
                'begin_date' => $begin->modify("+$id months")->getTimestamp(),
                'end_date' => $end->modify("+$id months")->getTimestamp()
            ]);
        } else {
            Period::create([
                'begin_date' => $begin->getTimestamp(),
                'end_date' => $end->getTimestamp()
            ]);
        }
    }
}
