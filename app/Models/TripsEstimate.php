<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripsEstimate extends Model
{
    use HasFactory;

    protected $table = 'trips_estimate';

    public $timestamps = true;
}
