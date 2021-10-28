<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Garages extends Model
{
    use HasFactory;

    protected $table = 'garages';

    public $timestamps = true;
}
