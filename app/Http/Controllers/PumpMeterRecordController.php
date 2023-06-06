<?php

namespace App\Http\Controllers;

use App\Models\PumpMeterRecord;
use Illuminate\Http\Request;

class PumpMeterRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PumpMeterRecord::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'period_id' => 'required',
            'amount_volume' => 'required'
        ]);
        PumpMeterRecord::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(PumpMeterRecord $pumpMeterRecord)
    {
        return $pumpMeterRecord;
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateByPeriodId(Request $request)
    {
        $request->validate([
            'period_id' => 'required',
            'amount_volume' => 'required'
        ]);

        PumpMeterRecord::where('period_id', $request['period_id'])->update(['amount_volume' => $request['amount_volume']]);
    }
}
