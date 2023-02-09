<?php

namespace App\models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class DataStatistik extends Model
{
    protected $table  = "data_statistik";
    protected $guarded  = [];
    public function instansi (){
        return $this->belongsTo(Dashboard::class);
    } 
    public function user (){
        return $this->belongsTo(User::class);
    } 
    public $incrementing=false;


    public function scopeVerifiedData($q, $id_instansi){
        $q->where([['instansi_id', $id_instansi],['validasi',1],['verifikator',1]]);
    }
    public function scopeUnverifiedData($q, $id_instansi){
        $q->where('instansi_id', $id_instansi)->whereNotIn('verifikator',[1]);
    }
}
