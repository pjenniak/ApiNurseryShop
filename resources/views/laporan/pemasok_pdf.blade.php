<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pemasok</title>
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
    <h2>Laporan Pemasok {{ config('app.name') }}</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kontak</th>
                <th>Total Pesanan</th>
                <th>Terdaftar Pada</th>
            </tr>
        </thead>
        <tbody>
        @foreach($pemasoks as $pemasok)
            <tr>
                <td>{{ $pemasok->nomor }}</td>
                <td>{{ $pemasok->nama }}</td>
                <td>{{ $pemasok->kontak }}</td>
                <td>{{ $pemasok->total_pesanan }}</td>
                <td>{{ $pemasok->terdaftar }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
