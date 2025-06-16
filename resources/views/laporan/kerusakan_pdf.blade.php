<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kerusakan</title>
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
    <h2>Laporan Kerusakan Produk {{ config('app.name') }}</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Kerusakan</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Alasan</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
        @foreach($cacatProduks as $item)
            <tr>
                <td>{{ $item->nomor }}</td>
                <td>{{ $item->id_kerusakan }}</td>
                <td>{{ $item->produk_nama }}</td>
                <td>{{ $item->jumlah }}</td>
                <td>{{ $item->alasan }}</td>
                <td>{{ $item->tanggal }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
