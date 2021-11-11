<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'tutor_id',
        'first_name',
        'last_name',
        'job_title',
        'description',
        'file_name',
        'file_path'
    ];
}
