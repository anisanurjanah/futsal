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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservasi_id')
                ->constrained('reservasis')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->date('tanggal_pembayaran');
            $table->decimal('total_pembayaran');
            $table->decimal('sisa_pembayaran');
            $table->string('status_pembayaran')->default('Ditunda');
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
        Schema::dropIfExists('pembayarans');
    }
};
