<?php

use Carbon\Carbon;
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

        Pelanggan::factory(10)->create()->each(function ($pelanggan) {
            $lapangan = Lapangan::inRandomOrder()->first();

            // Buat reservasi
            $reservasi = Reservasi::factory()->create([
                'pelanggan_id' => $pelanggan->id,
                'lapangan_id' => $lapangan->id,
                'tanggal' => Carbon::now()->addDays(rand(1, 7)),
                'waktu_mulai' => '10:00:00',
                'waktu_selesai' => '11:00:00',
                'status' => 'Dipesan',
            ]);

            // Hitung total
            $durasiJam = 1;
            $totalBayar = $lapangan->price * $durasiJam;

            // Random DP atau Lunas
            $isLunas = rand(0, 1) === 1;
            $jumlahBayar = $isLunas ? $totalBayar : intval($totalBayar * 0.3);
            $status = $isLunas ? 'Lunas' : 'DP';

            // Buat pembayaran
            $pembayaran = Pembayaran::create([
                'reservasi_id' => $reservasi->id,
                'tanggal_pembayaran' => now(),
                'total_pembayaran' => $jumlahBayar,
                'status_pembayaran' => $status,
            ]);

            // Buat detail pembayaran
            PembayaranDetail::create([
                'pembayaran_id' => $pembayaran->id,
                'tanggal_pembayaran' => now(),
                'jumlah_pembayaran' => $jumlahBayar,
                'metode_pembayaran' => ['Bank Transfer', 'Gopay', 'QRIS'][array_rand(['Bank Transfer', 'Gopay', 'QRIS'])],
            ]);
        });
    }
}
