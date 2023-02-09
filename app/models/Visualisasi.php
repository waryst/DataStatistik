<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Visualisasi extends Model
{
    const UPDATED_AT = null;
    protected $guarded = [
        'id'
    ];
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
