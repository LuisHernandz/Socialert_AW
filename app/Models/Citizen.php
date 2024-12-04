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
        'fcm_token',
        'user_id'
    ];

    public function user(){ //Recuperar informacion del usuario que corresponde al ciudadano.
        return $this->belongsTo('App\Models\User');
    }

    public function reports()
    {
        return $this->hasMany('App\Models\Reports');
    }

    public function alerts()
    {
        return $this->hasMany('App\Models\Alert');
    }

    public function contacts(){
        return $this->belongsToMany('App\Models\Contact');
    }
}
