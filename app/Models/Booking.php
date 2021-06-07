<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $table = 'booking';
    protected $fillable = ['customer_info_id', 'room_id', 'time', 'classify', 'payment', 'status', 'created_at', 'updated_at'];
}
