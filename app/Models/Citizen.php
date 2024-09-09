<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citizen extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone',
        'gender',
        'curp',
        'user_id'
    ];

    public function user(){ //Recuperar informacion del usuario que corresponde al ciudadano.
        return $this->belongsTo('App\Models\User');
    }
}
