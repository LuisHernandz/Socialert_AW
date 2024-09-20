<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reports extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'file',
        'calification',
        'type_id',
        'status_id',
        'citizen_id'
    ];

    public function citizen()
    {
        return $this->belongsTo('App\Models\Citizen');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function alerts()
    {
        return $this->hasMany('App\Models\Alert');
    }
}
