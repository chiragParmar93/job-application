<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'name',
        'email',
        'address',
        'gender',
        'phone',
        'location_id',
        'expected_ctc',
        'current_ctc',
        'notice_period',
    ];

    public function educations()
    {
        return $this->hasMany(JobEducations::class);
    }

    public function language()
    {
        //return $this->belongsToMany(JobLanguage::class, 'job_languages', 'job_id', 'id');

        return $this->hasMany(JobLanguage::class, 'job_id', 'id');
    }

    public function technicalExperiences()
    {
        return $this->hasMany(JobTechnicalExperiences::class, 'job_id', 'id');
        //return $this->belongsToMany(JobTechnicalExperiences::class, 'job_technical_experiences', 'job_id', 'id');
    }

    public function workExperience()
    {
        return $this->hasMany(JobWorkExperience::class, 'job_id', 'id');
        //return $this->belongsToMany(JobWorkExperience::class, 'job_work_experiences', 'job_id', 'id');
    }
}
