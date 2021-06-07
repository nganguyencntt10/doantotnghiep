<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;
    protected $table = 'services';
    protected $fillable = ['name', 'slug', 'image', 'images', 'description', 'detail', 'created_at', 'updated_at'];

    public function services_procedure()
    {
        return $this->hasMany(ServicesProcedure::class, 'service_id');
    }
}
