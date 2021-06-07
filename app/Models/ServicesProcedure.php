<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicesProcedure extends Model
{
    use HasFactory;
    protected $table = 'services_procedure';
    protected $fillable = ['service_id', 'name', 'time', 'prices', 'created_at', 'updated_at'];

    public function services()
    {
        return $this->belongsTo(Services::class);
    }
}
