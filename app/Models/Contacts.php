<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    protected $table = "contacts";

    public $fillable = [
        'name',
        'phone_number',
        'email'
    ];

}
