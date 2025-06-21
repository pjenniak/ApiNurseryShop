<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Migrasikan data dari table transaksi ke kolom baru di pesanan
        DB::statement("
            UPDATE pesanan p
            SET
                metode_pembayaran = COALESCE(t.metode_pembayaran, 'Cash'),
                status_pembayaran = COALESCE(t.status_pembayaran, 'Pending'),
                detail_transaksi = t.detail_transaksi,
                midtrans_snap_token = t.midtrans_snap_token,
                midtrans_url_redirect = t.midtrans_url_redirect
            FROM transaksi t
            WHERE t.pesanan_id = p.pesanan_id
        ");
    }

    public function down()
    {
        // Kosongkan data hasil migrasi (jika rollback)
        DB::statement("
            UPDATE pesanan
            SET
                metode_pembayaran = 'Cash',
                status_pembayaran = 'Pending',
                detail_transaksi = NULL,
                midtrans_snap_token = NULL,
                midtrans_url_redirect = NULL
        ");
    }
};
