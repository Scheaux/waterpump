<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\PumpMeterRecord;
use DateTime;
use Illuminate\Http\Request;

class PeriodController extends Controller
{
    public function index()
    {
        // отправлять ближайшие 10 периодов, начиная с прошлого месяца
        $date = new DateTime();
        $date->modify('-1 months');
        $startPeriod = Period::where('date', $date->format('Y-m'))->first();
        $records = [];

        $count = Period::where('id', '>=', $startPeriod->id)->count();
        if ($count < 10) {
            Period::makeNewPeriods(10 - $count);
        }

        $periods = Period::where('id', '>=', $startPeriod->id)->get();

        for ($i = 0; $i < count($periods); $i++) {
            $record = PumpMeterRecord::where('period_id', $periods[$i]->id)->first();
            if ($record) $records[] = $record;
        }

        return ['periods' => $periods, 'records' => $records];
    }

    public function show(string $id)
    {
        return Period::find($id);
    }

    public function update(Request $request, string $id)
    {
        $request->validate(['rate_rub' => 'required']);
        Period::find($id)->update(['rate_rub' => $request['rate_rub']]);
    }
}
