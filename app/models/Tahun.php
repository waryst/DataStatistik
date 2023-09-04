<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Tahun extends Model
{
    protected $table  = "tahun";
    protected $guarded  = ['id'];
    public $timestamps = false;

}
