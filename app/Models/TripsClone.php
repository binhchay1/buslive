<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripsClone extends Model
{
    use HasFactory;

    protected $table = 'trips_clone';

    public $timestamps = true;
}
