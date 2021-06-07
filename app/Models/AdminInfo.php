<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminInfo extends Model
{
    use HasFactory;
    protected $table = 'admin_info';
    protected $fillable = ['admin_id', 'name', 'avatar', 'code', 'address', 'dob', 'telephone', 'created_at', 'updated_at'];
}
