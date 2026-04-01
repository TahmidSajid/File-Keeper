<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class files extends Model
{

    protected $guarded = [''];

    protected $casts = [
        'user_id'   => 'string',
        'file_name' => 'string',
    ];
}
