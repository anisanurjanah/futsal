<?php

use App\Models\Lapangan;
use App\Models\Pelanggan;
use App\Models\Pembayaran;
use App\Models\PembayaranDetail;
use App\Models\Reservasi;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(2)->create();
        Pelanggan::factory(10)->create();
        Lapangan::factory(3)->create();
        Reservasi::factory(5)->create();
        Pembayaran::factory(5)->create();
        PembayaranDetail::factory(8)->create();
    }
}
