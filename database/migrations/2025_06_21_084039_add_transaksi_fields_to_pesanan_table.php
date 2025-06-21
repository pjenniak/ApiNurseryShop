<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->string('metode_pembayaran')->default('Cash')->after('status');
            $table->string('status_pembayaran')->default('Pending')->after('metode_pembayaran');
            $table->json('detail_transaksi')->nullable()->after('status_pembayaran');
            $table->string('midtrans_snap_token')->nullable()->after('detail_transaksi');
            $table->string('midtrans_url_redirect')->nullable()->after('midtrans_snap_token');
        });
    }

    public function down()
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->dropColumn('metode_pembayaran');
            $table->dropColumn('status_pembayaran');
            $table->dropColumn('detail_transaksi');
            $table->dropColumn('midtrans_snap_token');
            $table->dropColumn('midtrans_url_redirect');
        });
    }
};
