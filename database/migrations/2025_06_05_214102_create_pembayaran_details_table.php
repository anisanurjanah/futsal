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
        Schema::create('pembayaran_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembayaran_id')
                ->constrained('pembayarans')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->date('tanggal_pembayaran');
            $table->decimal('jumlah_pembayaran');
            $table->string('metode_pembayaran');
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
        Schema::dropIfExists('pembayaran_details');
    }
};
