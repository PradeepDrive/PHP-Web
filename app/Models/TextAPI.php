<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TextAPI extends Model
{
    protected $table = "text_api";

    public $fillable = [
        'text_url',
        'token',
        'from',
        'message',
    ];

}
