<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes, Utility;

    protected $table = 'contact';

    protected $fillable = [
        'name',
        'email',
        'message',
        
        'created_at',
        'deleted_at',
        'updated_at',
    ];

    protected $hidden = [
        'created_at',
        'deleted_at',
        'updated_at',
    ];
}
