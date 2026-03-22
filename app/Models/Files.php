<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    protected $guarded = [''];


    protected $casts = [
        'user_id'   => 'string',
        'file_name' => 'string',
    ];


    public function scopeAuth($query){
        return $this->where('user_id',auth()->user()->id);
    }
}
