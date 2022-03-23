<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roads extends Model
{
    use HasFactory;

    protected $table = 'roads';

    public $timestamps = true;

    protected $fillable = [
        'status'
    ];
}
