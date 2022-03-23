<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'ticket';

    public $timestamps = true;

    protected $fillable = [
        'name_customer',
        'phone_customer',
        'pay_status',
        'note',
        'users_id'
    ];
}
