<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PumpMeterRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'period_id',
        'amount_volume'
    ];
}
