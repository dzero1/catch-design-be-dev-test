<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerIpAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'ip_address',
    ];

    // hide unwanted fields
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
