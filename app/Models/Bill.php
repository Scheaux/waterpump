<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'resident_id',
        'period_id',
        'amount_rub',
    ];

    function resident()
    {
        return $this->belongsTo(Resident::class, 'resident_id');
    }
}
