<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriveSettings extends Model
{
    protected $guarded = [];

    protected $casts = [
        'google_client_id'     => 'string',
        'google_client_secret' => 'string',
        'google_refresh_token' => 'string',
        'folder_id'            => 'string',
    ];
}
