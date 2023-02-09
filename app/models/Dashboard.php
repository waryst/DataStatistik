<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
    protected $table  = "instansi";
    public function datastatistik (){
        return $this->hasmany(DataStatistik::class, 'instansi_id');
    } 
}
