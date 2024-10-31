<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone_number'
    ];

    public $timestamps = false;

    public function citizens(){
        return $this->belongsToMany('App\Models\Citizen');
    }
}
