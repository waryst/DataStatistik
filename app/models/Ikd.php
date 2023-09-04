<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Ikd extends Model
{
    protected $table  = "master_ikd";
    protected $guarded  = ['id'];
    public $timestamps = false;
}
