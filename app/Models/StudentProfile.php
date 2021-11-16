<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentProfile extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'student_id';

    protected $fillable = [
        'student_id',
        'first_name',
        'last_name',
        'study_level',
        'description',
        'file_name',
        'file_path'
    ];
}
