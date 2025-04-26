<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Setoran Kasir</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; font-size: 18px; font-weight: bold; }
        .sub-header { text-align: center; font-size: 14px; }
        .total { font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">Laporan Setor Kasir</div>
    <div class="sub-header">Klinik Omega</div>
    <p>Dicetak pada : {{ now()->format('d-m-Y / H:i:s') }}</p>
    <p>Laporan Detail Setoran Kasir [{{ $data[0]['username'] }}]</p>
    <p>Periode : {{ $start_date }} sampai {{ $end_date }}</p>

    <table>
        <thead>
            <tr>
                <th>No RM</th>
                <th>Pasien</th>
                <th>No Invoice</th>
                <th>Cash</th>
                <th>Debit</th>
                <th>C.Card</th>
                <th>Credit</th>
                <th>Transfer</th>
                <th>QRIS</th>
                <th>Kembalian</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
            <tr>
                <td>{{ $row['no_rm'] }}</td>
                <td>{{ $row['nama'] }}</td>
                <td>{{ $row['no_faktur'] }}</td>
                <td>{{ number_format($row['cash'], 0, ',', '.') }}</td>
                <td>{{ number_format($row['debit'], 0, ',', '.') }}</td>
                <td>{{ number_format($row['credit_card'], 0, ',', '.') }}</td>
                <td>{{ number_format($row['credit'], 0, ',', '.') }}</td>
                <td>{{ number_format($row['transfer'], 0, ',', '.') }}</td>
                <td>{{ number_format($row['qr'], 0, ',', '.') }}</td>
                <td>{{ number_format($row['kembalian'], 0, ',', '.') }}</td>
                <td>{{ number_format($row['total'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p class="total">Jumlah Invoice: {{ count($data) }} lembar</p>
    <p class="total">
        Cash: Rp {{ number_format($total_cash, 0, ',', '.') }};
        Debit Card: Rp {{ number_format($total_debit, 0, ',', '.') }};
        Credit Card: Rp {{ number_format($total_credit_card, 0, ',', '.') }};
        Transfer: Rp {{ number_format($total_transfer, 0, ',', '.') }};
        QRIS: Rp {{ number_format($total_qr, 0, ',', '.') }}
    </p>
    <p class="total">Pendapatan: Rp {{ number_format($total_income, 0, ',', '.') }}</p>

    <br>
    <p>Paraf Petugas</p>
    <br><br>
    <p>{{ $data[0]['username'] }}</p>
</body>
</html>
