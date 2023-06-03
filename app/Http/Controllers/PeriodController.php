<?php

namespace App\Http\Controllers;

use App\Models\Period;
use Illuminate\Http\Request;

class PeriodController extends Controller
{
    public function index()
    {
        return Period::all();
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
