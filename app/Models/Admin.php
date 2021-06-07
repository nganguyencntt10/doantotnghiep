<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    protected $table = 'admin';
    protected $fillable = ['secret_key', 'email', 'username', 'password', 'verify_code', 'status', 'middleware', 'created_at', 'updated_at'];

    public function admin_info()
    {
        return $this->hasOne(AdminInfo::class, 'admin_id');
    }
}
