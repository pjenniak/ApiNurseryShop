<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFloatColumnsToDouble extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('produk', function (Blueprint $table) {
    $table->double('harga_produk', 65, 30)->change();
});

Schema::table('informasi', function (Blueprint $table) {
    $table->double('persentase_pajak', 65, 30)->change();
    $table->double('persentase_diskon', 65, 30)->change();
});

Schema::table('pesanan', function (Blueprint $table) {
    $table->double('total_akhir', 65, 30)->change();
    $table->double('total_harga_barang', 65, 30)->change();
    $table->double('diskon_dikenakan', 65, 30)->change();
    $table->double('pajak_dikenakan', 65, 30)->change();
});

Schema::table('item_pesanan', function (Blueprint $table) {
    $table->double('harga_per_barang', 65, 30)->change();
    $table->double('total_harga', 65, 30)->change();
});

Schema::table('transaksi', function (Blueprint $table) {
    $table->double('jumlah_pembayaran', 65, 30)->change();
});

Schema::table('pembelian_produk', function (Blueprint $table) {
    $table->double('jumlah_pembelian', 65, 30)->change();
    $table->double('harga_per_barang', 65, 30)->change();
    $table->double('total_harga', 65, 30)->change();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            $table->float('harga_produk')->change();
        });

        Schema::table('informasi', function (Blueprint $table) {
            $table->float('persentase_pajak')->change();
            $table->float('persentase_diskon')->change();
        });

        Schema::table('pesanan', function (Blueprint $table) {
            $table->float('total_akhir')->change();
            $table->float('total_harga_barang')->change();
            $table->float('diskon_dikenakan')->change();
            $table->float('pajak_dikenakan')->change();
        });

        Schema::table('item_pesanan', function (Blueprint $table) {
            $table->float('harga_per_barang')->change();
            $table->float('total_harga')->change();
        });

        Schema::table('transaksi', function (Blueprint $table) {
            $table->float('jumlah_pembayaran')->change();
        });

        Schema::table('pembelian_produk', function (Blueprint $table) {
            $table->float('jumlah_pembelian')->change();
            $table->float('harga_per_barang')->change();
            $table->float('total_harga')->change();
        });
    }
}
