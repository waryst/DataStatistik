<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataStatistikDefaultModel extends Model
{
    //
    protected $table  ="data_statistik_default";
    protected $primaryKey = 'data_statistik_id';
    public $timestamps  = false;
    protected $guarded  = [];

    public function data_statistik() {
         return $this->belongsTo('App\DataStatistikModel');
    }

    public function data_statistik_file() {
         return $this->belongsTo('App\DataStatistikFileModel');
    }
}
