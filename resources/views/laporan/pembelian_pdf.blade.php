<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pembelian</title>
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
    <h2>Laporan Pembelian {{ config('app.name') }}</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Pemasok</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total</th>
                <th>Deskripsi</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
        @foreach($pembelianProduks as $item)
            <tr>
                <td>{{ $item->nomor }}</td>
                <td>{{ $item->produk_nama }}</td>
                <td>{{ $item->pemasok_nama }}</td>
                <td>{{ $item->jumlah }}</td>
                <td>{{ $item->harga }}</td>
                <td>{{ $item->total }}</td>
                <td>{{ $item->deskripsi }}</td>
                <td>{{ $item->tanggal }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
