<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobLanguage extends Model
{

    protected $fillable = [
        'language',
        'read',
        'write',
        'speak',
    ];
}
