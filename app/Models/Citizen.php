<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citizen extends Model
{
    use HasFactory;

    public function user(){ //Recuperar informacion del usuario que corresponde al ciudadano. 
        return $this->belongsTo('App\Models\User');
    }
}
