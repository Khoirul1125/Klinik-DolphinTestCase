<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kasir</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; font-size: 18px; font-weight: bold; }
        .sub-header { text-align: center; font-size: 14px; }
        .total { font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">Laporan Detail Kasir</div>
    <div class="sub-header">Klinik Omega</div>
    <p>Dicetak pada : {{ now()->format('d-m-Y / H:i:s') }}</p>
    <p>Laporan Detail Kasir [{{ $username }}]</p>
    <p>Periode : {{ $startDate }} sampai {{ $endDate }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No Faktur</th>
                <th>Tanggal</th>
                <th>No RM</th>
                <th>Nama</th>
                <th>Rawat</th>
                <th>Jenis</th>
                <th>Penjamin</th>
                <th>Item</th>
                <th>Harga Satuan</th>
                <th>Qty</th>
                <th>Subtotal</th>
                <th>Total</th>
                <th>Dokter</th>
                <th>Petugas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $row)
                <tr>
                    <td>{{ $row[0] }}</td>
                    <td>{{ $row[1] }}</td>
                    <td>{{ $row[2] }}</td>
                    <td>{{ $row[3] }}</td>
                    <td>{{ $row[4] }}</td>
                    <td>{{ $row[5] }}</td>
                    <td>{{ $row[6] }}</td>
                    <td>{{ $row[7] }}</td>
                    <td>{{ $row[8] }}</td>
                    <td>{{ $row[9] }}</td>
                    <td>{{ $row[10] }}</td>
                    <td>{{ $row[11] }}</td>
                    <td>{{ $row[12] }}</td>
                    <td>{{ $row[13] }}</td>
                    <td>{{ $row[14] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p class="total">Jumlah Invoice: {{ count($data) }} lembar</p>
    <p class="total">Pendapatan: Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>

    <br>
    <p>Paraf Petugas</p>
    <br><br>
    <p>{{ $username }}</p>
</body>
</html>
