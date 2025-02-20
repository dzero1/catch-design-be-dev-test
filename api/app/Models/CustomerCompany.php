<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerCompany extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'company',
        'city',
        'title',
        'website',
    ];

    // hide unwanted fields
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
