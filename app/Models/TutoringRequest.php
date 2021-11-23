<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TutoringRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'student_id',
        'tutor_id', 
        'advertisement_id',
        'request_status',
        'requested_date', 
        'requested_time', 
        'tutorial_joining_url',
        'comment'
    ];
}
