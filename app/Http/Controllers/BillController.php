<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $requst)
    {
        $requst->validate(['period_id' => 'required']);
        return Bill::with('resident')->where('period_id', $requst['period_id'])->paginate(5);
    }
}
