<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'location',
        'jobType',
        'contact',
        'description',
        'salary_min',
        'salary_max',
        'user_id',
    ];
}