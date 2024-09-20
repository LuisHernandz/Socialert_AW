<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    use HasFactory;

    public function citizen()
    {
        return $this->belongsTo('App\Models\Citizen');
    }

    public function report()
    {
        return $this->belongsTo('App\Models\Reports');
    }
}
