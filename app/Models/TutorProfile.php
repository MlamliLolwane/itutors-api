<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TutorProfile extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'tutor_id';

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
