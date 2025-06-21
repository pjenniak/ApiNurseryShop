<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::dropIfExists('transaksi');
    }

    public function down()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->uuid('transaksi_id')->primary();
            $table->float('jumlah_pembayaran');
            $table->string('metode_pembayaran');
            $table->string('status_pembayaran');
            $table->json('detail_transaksi')->nullable();

            $table->string('midtrans_snap_token')->nullable();
            $table->string('midtrans_url_redirect')->nullable();

            $table->uuid('pesanan_id')->unique();
            $table->foreign('pesanan_id')->references('pesanan_id')->on('pesanan')->onDelete('cascade');

            $table->boolean('is_deleted')->default(false);
            $table->timestamps(0);
        });
    }
};
