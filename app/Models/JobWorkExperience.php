<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobWorkExperience extends Model
{
    protected $fillable = [
        'company',
        'designation',
        'start_date',
        'end_date',
        
    ];

    protected $table = 'job_work_experiences';
    
}
