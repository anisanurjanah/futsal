<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function lapangan()
    {
        return $this->belongsTo(Lapangan::class);
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function getRouteKeyName()
    {
        return 'id';
    }

    const STATUS = [
        'Selesai' => 'Selesai',
        'Ditunda' => 'Ditunda',
        'Dibatalkan' => 'Dibatalkan',
        'Berlangsung' => 'Berlangsung',
    ];
}
