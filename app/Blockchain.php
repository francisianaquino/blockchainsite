<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blockchain extends Model
{
    protected $table = 'blockchains';

    protected $fillable = ['cryptocurrency'];
}
