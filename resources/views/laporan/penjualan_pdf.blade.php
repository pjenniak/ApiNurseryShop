<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #111;
            padding: 5px;
            text-align: left;
        }
        th {
            background: #eee;
        }
    </style>
</head>
<body>
    <h2>Laporan Penjualan {{ config('app.name') }}</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Pesanan</th>
                <th>Pelanggan</th>
                <th>Metode Pembayaran</th>
                <th>Produk</th>
                <th>Subtotal</th>
                <th>Diskon</th>
                <th>Pajak</th>
                <th>Total</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
        @foreach($pesanans as $pesanan)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $pesanan->pesanan_id }}</td>
                <td>
                    @if($pesanan->pelanggan)
                        {{ $pesanan->pelanggan->nama_pelanggan }} ({{ $pesanan->pelanggan->kode_pelanggan }})
                    @else
                        -
                    @endif
                </td>
                <td>{{ $pesanan->transaksi ? $pesanan->transaksi->metode_pembayaran : '-' }}</td>
                <td>{!! $pesanan->produk_data !!}</td>
                <td>Rp {{ $pesanan->total_harga_barang }}</td>
                <td>Rp {{ $pesanan->diskon_dikenakan }} ({{ $pesanan->persentase_diskon }}%)</td>
                <td>Rp {{ $pesanan->pajak_dikenakan }} ({{ $pesanan->persentase_pajak }}%)</td>
                <td>Rp {{ $pesanan->total_akhir }}</td>
                <td>{{ \Carbon\Carbon::parse($pesanan->created_at)->format('d-m-Y H:i:s') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
