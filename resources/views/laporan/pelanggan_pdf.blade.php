<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pelanggan</title>
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
    <h2>Laporan Pelanggan {{ config('app.name') }}</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Tipe</th>
                <th>Kontak</th>
                <th>Total Pesanan</th>
                <th>Terdaftar Pada</th>
            </tr>
        </thead>
        <tbody>
        @foreach($pelanggans as $pelanggan)
            <tr>
                <td>{{ $pelanggan->nomor }}</td>
                <td>{{ $pelanggan->nama }}</td>
                <td>{{ $pelanggan->tipe }}</td>
                <td>{{ $pelanggan->kontak }}</td>
                <td>{{ $pelanggan->total_pesanan }}</td>
                <td>{{ $pelanggan->terdaftar }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
