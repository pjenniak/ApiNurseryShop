<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement('ALTER TABLE transaksi DROP CONSTRAINT IF EXISTS transaksi_status_pembayaran_check;');
    }

    public function down()
    {
        // Kalau ingin mengembalikan constraint, bisa tambahkan lagi di sini
        // DB::statement("ALTER TABLE transaksi ADD CONSTRAINT transaksi_status_pembayaran_check CHECK (status_pembayaran IN ('Pending','Success'));");
    }
};
