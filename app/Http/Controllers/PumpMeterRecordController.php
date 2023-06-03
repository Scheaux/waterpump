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
            'amount_value' => 'required'
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
    public function update(Request $request, PumpMeterRecord $pumpMeterRecord)
    {
        $pumpMeterRecord->update($request->all());
    }
}
