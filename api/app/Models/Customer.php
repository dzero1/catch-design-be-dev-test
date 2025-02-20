<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address'
    ];
    
    // hide unwanted fields
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    // link ip address to customer
    public function ip_addresses()
    {
        return $this->hasMany(CustomerIpAddress::class, 'customer_id', 'id');
    }

    // link company details to customer
    public function companies()
    {
        return $this->hasMany(CustomerCompany::class, 'customer_id', 'id');
    }
}
