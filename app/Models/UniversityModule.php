<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UniversityModule extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'module_code';

    protected $fillable = [
        'module_code',
        'module_name',
        'university',
    ];
}
