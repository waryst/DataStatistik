<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class IndikatorIku extends Model
{
    protected $table  = "master_iku";
    protected $guarded  = ['id'];
    public $timestamps = false;
}
