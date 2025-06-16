<?php

namespace App\Http\Controllers\Api;

use App\Models\Pesanan;
use App\Models\ItemPesanan;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CacatProduk;
use App\Models\Pemasok;
use App\Models\PembelianProduk;
use App\Models\Produk;
use Barryvdh\DomPDF\Facade\Pdf;


class LaporanController extends Controller
{

    public function laporanPenjualan(Request $request)
    {
        $start = $request->query('start');
        $end = $request->query('end');

        $pesananQuery = Pesanan::query()
            ->where('is_deleted', false)
            ->with(['transaksi', 'item_pesanan.produk', 'pelanggan'])
            ->select('pesanan.*');

        if ($start) {
            $pesananQuery->whereDate('created_at', '>=', $start);
        }

        if ($end) {
            $pesananQuery->whereDate('created_at', '<=', $end);
        }

        $pesanans = $pesananQuery->get();

        foreach ($pesanans as $pesanan) {
            $produkData = [];
            foreach ($pesanan->item_pesanan as $item) {
                $produkData[] =
                    ($item->produk->nama_produk ?? '-') . ' x ' .
                    ($item->jumlah_barang ?? '0') .
                    ' (@' . number_format($item->harga_per_barang ?? 0, 0, ',', '.') . ')';
            }
            $pesanan->produk_data = implode('<br>', $produkData);
        }

        $pdf = Pdf::loadView('laporan.penjualan_pdf', [
            'pesanans' => $pesanans,
        ])->setPaper('A4', 'landscape');

        return $pdf->stream('Laporan Penjualan ' . env('APP_NAME') . '.pdf');
    }

    public function laporanPembelian(Request $request)
    {
        $start = $request->query('start');
        $end = $request->query('end');

        $pembelianQuery = PembelianProduk::query()
            ->where('is_deleted', false)
            ->with(['produk', 'pemasok'])
            ->select('pembelian_produk.*');

        if ($start) {
            $pembelianQuery->whereDate('created_at', '>=', $start);
        }

        if ($end) {
            $pembelianQuery->whereDate('created_at', '<=', $end);
        }

        $pembelianProduks = $pembelianQuery->get();

        $nomor = 1;
        foreach ($pembelianProduks as $item) {
            $item->nomor = $nomor++;
            $item->produk_nama = $item->produk->nama_produk ?? '-';
            $item->pemasok_nama = $item->pemasok->nama_pemasok ?? '-';
            $item->jumlah = $item->jumlah_pembelian ?? 0;
            $item->harga = number_format($item->harga_per_barang ?? 0, 0, ',', '.');
            $item->total = number_format($item->total_harga ?? 0, 0, ',', '.');
            $item->deskripsi = $item->deskripsi_pembelian ?? '-';
            $item->tanggal = \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i:s');
        }

        $pdf = Pdf::loadView('laporan.pembelian_pdf', [
            'pembelianProduks' => $pembelianProduks,
        ])->setPaper('A4', 'landscape');

        return $pdf->stream('Laporan Pembelian ' . env('APP_NAME') . '.pdf');
    }

    public function laporanKerusakan(Request $request)
    {
        $start = $request->query('start');
        $end = $request->query('end');

        $cacatProdukQuery = CacatProduk::query()
            ->where('is_deleted', false)
            ->with(['produk'])
            ->select('cacat_produk.*');

        if ($start) {
            $cacatProdukQuery->whereDate('created_at', '>=', $start);
        }

        if ($end) {
            $cacatProdukQuery->whereDate('created_at', '<=', $end);
        }

        $cacatProduks = $cacatProdukQuery->get();

        $nomor = 1;
        foreach ($cacatProduks as $item) {
            $item->nomor   = $nomor++;
            $item->id_kerusakan = $item->cacat_produk_id ?? '-';
            $item->produk_nama  = $item->produk->nama_produk ?? '-';
            $item->jumlah       = $item->jumlah_produk ?? 0;
            $item->alasan       = $item->alasan_kerusakan ?? '-';
            $item->tanggal      = \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i:s');
        }

        $pdf = Pdf::loadView('laporan.kerusakan_pdf', [
            'cacatProduks' => $cacatProduks,
        ])->setPaper('A4', 'landscape');

        return $pdf->stream('Laporan Kerusakan ' . env('APP_NAME') . '.pdf');
    }

    public function laporanProduk(Request $request)
    {
        $produks = Produk::where('is_deleted', false)->get();
        $items_pesanan = ItemPesanan::where('is_deleted', false)->get();
        $cacats = CacatProduk::where('is_deleted', false)->get();
        $pembelians = PembelianProduk::where('is_deleted', false)->get();

        $nomor = 1;
        foreach ($produks as $produk) {
            $produk->total_terjual = $items_pesanan->where('produk_id', $produk->produk_id)->sum('jumlah_barang');
            $produk->total_cacat = $cacats->where('produk_id', $produk->produk_id)->sum('jumlah_produk');
            $produk->total_pembelian = $pembelians->where('produk_id', $produk->produk_id)->sum('jumlah_pembelian');
            $produk->nomor = $nomor++;

            $produk->kategori = $produk->kategori_produk ?? '-';
            $produk->harga = number_format($produk->harga_produk ?? 0, 0, ',', '.');
            $produk->hpp = number_format($produk->hpp ?? 0, 0, ',', '.');
            $produk->stok = $produk->jumlah_stok ?? 0;
            $produk->terjual = $produk->total_terjual ?? 0;
            $produk->pembelian = $produk->total_pembelian ?? 0;
            $produk->kerusakan = $produk->total_cacat ?? 0;
            $produk->deskripsi = $produk->deskripsi_produk ?: '-';
            $produk->tanggal = \Carbon\Carbon::parse($produk->created_at)->format('d-m-Y H:i:s');
        }

        $pdf = Pdf::loadView('laporan.produk_pdf', [
            'produks' => $produks,
        ])->setPaper('A4', 'landscape');

        return $pdf->stream('Laporan Produk ' . env('APP_NAME') . '.pdf');
    }


    public function laporanPelanggan(Request $request)
    {
        $pelanggans = Pelanggan::withCount(["pesanan"])
            ->where('is_deleted', false)
            ->get();

        $nomor = 1;
        foreach ($pelanggans as $pelanggan) {
            $pelanggan->nomor = $nomor++;
            $pelanggan->id_pelanggan = $pelanggan->pelanggan_id ?? '-';
            $pelanggan->nama = $pelanggan->nama_pelanggan ?? '-';
            $pelanggan->tipe = $pelanggan->jenis_kode ?? '-';
            $pelanggan->kontak = $pelanggan->kode_pelanggan ?? '-';
            $pelanggan->total_pesanan = $pelanggan->pesanan_count ?? 0;
            $pelanggan->terdaftar = \Carbon\Carbon::parse($pelanggan->created_at)->format('d-m-Y H:i:s');
        }

        $pdf = Pdf::loadView('laporan.pelanggan_pdf', [
            'pelanggans' => $pelanggans,
        ])->setPaper('A4', 'landscape');

        return $pdf->stream('Laporan Pelanggan ' . env('APP_NAME') . '.pdf');
    }



    public function laporanPemasok(Request $request)
    {
        $pemasoks = Pemasok::withCount(['pembelian_produk'])
            ->where('is_deleted', false)
            ->get();

        $nomor = 1;
        foreach ($pemasoks as $pemasok) {
            $pemasok->nomor           = $nomor++;
            $pemasok->id_pemasok      = $pemasok->pemasok_id ?? '-';
            $pemasok->nama            = $pemasok->nama_pemasok ?? '-';
            $pemasok->kontak          = $pemasok->telepon_pemasok ?? '-';
            $pemasok->total_pesanan   = $pemasok->pembelian_produk_count ?? 0;
            $pemasok->terdaftar       = \Carbon\Carbon::parse($pemasok->created_at)->format('d-m-Y H:i:s');
        }

        $pdf = Pdf::loadView('laporan.pemasok_pdf', [
            'pemasoks' => $pemasoks,
        ])->setPaper('A4', 'landscape');

        return $pdf->stream('Laporan Pemasok ' . env('APP_NAME') . '.pdf');
    }


    public function index(Request $request)
    {
        $start = $request->query('start');
        $end = $request->query('end');

        $penjualanQuery = Pesanan::query()
            ->where('is_deleted', false);

        $pembelianQuery = PembelianProduk::query()
            ->where('is_deleted', false);

        $cacatProdukQuery = CacatProduk::query()
            ->where('is_deleted', false);

        if ($start) {
            $penjualanQuery->whereDate('created_at', '>=', $start);
            $pembelianQuery->whereDate('created_at', '>=', $start);
            $cacatProdukQuery->whereDate('created_at', '>=', $start);
        }

        if ($end) {
            $penjualanQuery->whereDate('created_at', '<=', $end);
            $pembelianQuery->whereDate('created_at', '<=', $end);
            $cacatProdukQuery->whereDate('created_at', '<=', $end);
        }

        $penjualan = $penjualanQuery->count();
        $pembelian = $pembelianQuery->count();
        $kerusakan = $cacatProdukQuery->count();

        $produk = Produk::where('is_deleted', false)->count();
        $pemasok = Pemasok::where('is_deleted', false)->count();
        $pelanggan = Pelanggan::where('is_deleted', false)->count();


        $data = [
            'penjualan' => $penjualan,
            'pembelian' => $pembelian,
            'kerusakan' => $kerusakan,
            'produk' => $produk,
            'pemasok' => $pemasok,
            'pelanggan' => $pelanggan
        ];

        return response()->json([
            'message' => 'OK',
            'data' => $data
        ]);
    }
}
