<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'file',
        'calification',
        'latitude',
        'longitude',
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
}
