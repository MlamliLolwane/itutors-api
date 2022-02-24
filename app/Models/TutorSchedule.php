<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TutorSchedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tutor_id',
        'day_id',
        'schedule'
    ];
}
