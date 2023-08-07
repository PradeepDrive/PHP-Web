<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliatedTo extends Model
{
    protected $table = "AffiliatedTo";

    public $fillable = [
        'Name'
    ];

}
