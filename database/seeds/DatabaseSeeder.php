<?php

use App\Models\User;
use App\Models\Lapangan;
use App\Models\Pelanggan;
use App\Models\Reservasi;
use App\Models\Pembayaran;
use Illuminate\Database\Seeder;
use App\Models\PembayaranDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(2)->create();
        // Pelanggan::factory(10)->create();
        // Lapangan::factory(3)->create();
        // Reservasi::factory(5)->create();
        // Pembayaran::factory(5)->create();
        // PembayaranDetail::factory(8)->create();

        // User::create([
        //     'name' => 'Pemilik',
        //     'email' => 'pemilik@localhost.com',
        //     'password' => Hash::make('password'),
        //     'role' => 'pemilik',
        // ]);

        // User::create([
        //     'name' => 'Kasir',
        //     'email' => 'kasir@localhost.com',
        //     'password' => Hash::make('password'),
        //     'role' => 'kasir',
        // ]);
        
        // Lapangan::create([
        //     'name' => 'Lapangan Futsal',
        //     'price' => 70000,
        // ]);

        // Lapangan::create([
        //     'name' => 'Lapangan Basket',
        //     'price' => 50000,
        // ]);

        // Lapangan::create([
        //     'name' => 'Lapangan Bulu Tangkis',
        //     'price' => 40000,
        // ]);

        // Reservasi::all()->each(function ($reservasi) {
        //     Pembayaran::factory()->create([
        //         'reservasi_id' => $reservasi->id,
        //     ]);
        // });

        // Pembayaran::all()->each(function ($pembayaran) {
        //     PembayaranDetail::factory()->create([
        //         'pembayaran_id' => $pembayaran->id,
        //     ]);
        // });

        // DB::table('metode_pembayarans')->insert([
        //     ['name' => 'Bank Transfer', 'code' => 'bank_transfer'],
        //     ['name' => 'Gopay', 'code' => 'gopay'],
        //     ['name' => 'QRIS', 'code' => 'qris'],
        // ]);
    }
}
