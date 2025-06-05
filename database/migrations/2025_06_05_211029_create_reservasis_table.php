<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')
                ->constrained('pelanggans')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('lapangan_id')
                ->constrained('lapangans')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->date('tanggal');
            $table->timestamp('waktu_mulai');
            $table->timestamp('waktu_selesai');
            $table->string('status')->default('Ditunda');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservasis');
    }
};
