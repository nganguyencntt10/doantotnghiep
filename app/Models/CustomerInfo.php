<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerInfo extends Model
{
    use HasFactory;
    protected $table = 'customer_info';
    protected $fillable = ['customer_id', 'name', 'code', 'address', 'dob', 'telephone', 'created_at', 'updated_at'];
}
