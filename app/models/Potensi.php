<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Potensi extends Model
{
    protected $table  = "potensi";
    protected $fillable = ['jenis', 'instansi_id', 'judul', 'descripsi', 'foto'];
}
