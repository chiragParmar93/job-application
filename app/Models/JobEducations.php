<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobEducations extends Model
{
    protected $table = 'job_educations';

    protected $fillable = [
        'type',
        'board',
        'year',
        'percentage',
    ];
}
