<?php

namespace App\models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class DataPublic extends Model
{
    protected $table  = "data_public";
    protected $guarded  = [];
    public function instansi (){
        return $this->belongsTo(Dashboard::class);
    } 
    public function user (){
        return $this->belongsTo(User::class);
    } 
    public $incrementing=false;

}
