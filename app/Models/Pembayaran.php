<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function reservasi()
    {
        return $this->belongsTo(Reservasi::class);
    }

    public function pembayaranDetail()
    {
        return $this->hasMany(PembayaranDetail::class);
    }

    public function getRouteKeyName()
    {
        return 'id';
    }

    const METODE_PEMBAYARAN = [
        'Tunai' => 'Tunai', 
        'Bank Transfer' => 'Bank Transfer', 
        'QRIS' => 'QRIS',
    ];

    const STATUS_PEMBAYARAN = [
        'Lunas' => 'Lunas',
        'Belum Lunas' => 'Belum Lunas',
        'Ditunda' => 'Ditunda',
        'Gagal' => 'Gagal',
    ];
}
