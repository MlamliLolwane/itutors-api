<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TutorSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'tutor_id',
        'day_id',
        'schedule'
    ];

    // public function tutorProfile()
    // {
    //     return $this->belongsTo(Day::class, 'day_id');
    // }
}
