<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Produk</title>
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
    <h2>Laporan Produk {{ config('app.name') }}</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Harga Rata-Rata Pembelian</th>
                <th>Stok</th>
                <th>Terjual</th>
                <th>Pembelian</th>
                <th>Kerusakan</th>
                <th>Deskripsi</th>
                <th>Terdaftar Pada</th>
            </tr>
        </thead>
        <tbody>
        @foreach($produks as $produk)
            <tr>
                <td>{{ $produk->nomor }}</td>
                <td>{{ $produk->nama_produk }}</td>
                <td>{{ $produk->kategori }}</td>
                <td>{{ $produk->harga }}</td>
                <td>{{ $produk->hpp }}</td>
                <td>{{ $produk->stok }}</td>
                <td>{{ $produk->terjual }}</td>
                <td>{{ $produk->pembelian }}</td>
                <td>{{ $produk->kerusakan }}</td>
                <td>{{ $produk->deskripsi }}</td>
                <td>{{ $produk->tanggal }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
