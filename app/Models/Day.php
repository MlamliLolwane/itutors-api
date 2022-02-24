<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;

    protected $fillable = [
        'day_name'
    ];

    // public function schedule()
    // {
    //    return $this->belongsTo(Schedule::class);
    // }
}
