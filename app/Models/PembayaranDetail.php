<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class);
    }

    public function getRouteKeyName()
    {
        return 'id';
    }
}
