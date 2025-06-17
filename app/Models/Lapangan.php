<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lapangan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function reservasi()
    {
        return $this->hasMany(Reservasi::class);
    }

    public function getRouteKeyName()
    {
        return 'id';
    }
}
