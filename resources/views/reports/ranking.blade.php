<!DOCTYPE html>
<html>
<head>
    <title>Laporan Hasil Ranking</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { bg-color: #f2f2f2; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Laporan Hasil Perankingan Kandidat (SAW)</h2>
    <p>Tanggal Cetak: {{ date('d-m-Y') }}</p>
    <table>
        <thead>
            <tr>
                <th>Peringkat</th>
                <th>Nama Kandidat</th>
                <th>Skor Akhir</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ranks as $index => $rank)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $rank->name }}</td>
                <td>{{ number_format($rank->value, 3) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>