<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobTechnicalExperiences extends Model
{
    protected $table = 'job_technical_experiences';

    protected $fillable = [
        'technology',
        'type',
    ];
}
