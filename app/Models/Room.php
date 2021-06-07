<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $table = 'room';
    protected $fillable = ['services_procedure_id', 'name', 'status', 'created_at', 'updated_at'];

    public function services_procedure()
    {
        return $this->belongsTo(ServicesProcedure::class);
    }
    public function booking()
    {
        return $this->hasMany(Booking::class);
    }
}
