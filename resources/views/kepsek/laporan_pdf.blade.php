<!DOCTYPE html>
<html>
<head>
    <title>Laporan Aspirasi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width:100%; border-collapse: collapse; }
        th, td { border:1px solid #000; padding:5px; text-align: center; }
        th { background:#f2f2f2; }
    </style>
</head>
<body>
<h3 style="text-align:center;">Laporan Data Aspirasi</h3>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>NISN</th>
            <th>Nama</th>
            <th>Kategori</th>
            <th>Lokasi</th>
            <th>Tanggal</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
    @foreach($aspirasi as $key => $item)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $item->inputAspirasi->nisn ?? '-' }}</td>
            <td>{{ $item->inputAspirasi->siswa->nama ?? '-' }}</td>
            <td>{{ $item->inputAspirasi->kategori->nama_kategori ?? '-' }}</td>
            <td>{{ $item->inputAspirasi->lokasi ?? '-' }}</td>
            <td>{{ $item->tgl_aspirasi }}</td>
            <td>{{ ucfirst($item->status) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
