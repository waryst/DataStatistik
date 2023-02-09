<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataStatistikFileModel extends Model
{
     //
     protected $table  = "data_statistik_file";
     protected $primaryKey = "id";
     protected $guarded  = [];

     public function data_statistik()
     {
          return $this->belongsTo('App\models\DataStatistik');
     }


     public function data_statistik_default()
     {
          return $this->hasOne('App\DataStatistikDefaultModel', 'data_statistik_file_id');
     }
}
