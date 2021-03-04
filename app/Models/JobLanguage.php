<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobLanguage extends Model
{

    protected $fillable = [
        'language',
        'is_selected',
        'read',
        'write',
        'speak',
    ];
}
