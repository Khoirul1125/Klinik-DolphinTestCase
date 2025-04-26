<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi Pembayaran</title>
    <style>
        @page {
            size: A5 portrait;
            margin: 10mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
        }

        h1, h2, h3, h4, h5, h6, p {
            margin: 0;
        }

        .header, .footer, .lunas {
            text-align: center;
        }

        .header h1 {
            margin-bottom: 10px;
            font-size: 18px;
        }

        .content {
            margin-top: 20px;
        }

        .content p {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            text-align: left;
            padding: 8px;
        }

        .footer {
            position: absolute;
            bottom: 20mm;
            width: 100%;
            font-size: 10px;
            padding-top: 20px;
        }

        .judul {
            font-weight: bold;
            font-size: 14px;
        }

        .text {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
        }

        .signature {
            display: inline-block;
            width: 40%;
            text-align: center;
            margin-top: 20px;
        }

        .footer p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Kwitansi Pembayaran</h1>
        <p>No. Faktur: {{ $data['no_faktur'] }}</p>
        <p>{{ $data['tanggal'] }}</p>
    </div>

    <div class="content">
        <!-- Paragraph for displaying No. RM -->
        <p><strong>No. RM:</strong> {{ $data['no_rm'] }}</p>

        <!-- Paragraph for displaying Nama Pasien -->
        <p><strong>Nama Pasien:</strong> {{ $data['nama'] }} ({{ $data['perawatan'] }})</p>

        <!-- Paragraph for displaying Tagihan -->
        <p><strong>Tagihan:</strong> Rp{{ number_format($data['tagihan'], 0, ',', '.') }}</p>

        <!-- Paragraph for displaying Dibayar -->
        <p><strong>Dibayar:</strong> Rp{{ number_format($data['dibayar'], 0, ',', '.') }}</p>

        <div class="lunas">
            <br>
            <p><strong>LUNAS.</strong></p>
            <br>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Tindakan / Obat</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalTagihan = 0; // Variabel untuk menyimpan total tagihan
            @endphp

            @foreach ($data['data_faktur'] as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item['nama_tambahan'] ?? $item['nama_obat'] }}</td>
                    <td>Rp{{ number_format($item['harga'], 0, ',', '.') }}</td>
                    <td>{{ $item['kuantitas'] }}</td>
                    <td>Rp{{ number_format($item['total_harga'], 0, ',', '.') }}</td>
                </tr>

                @php
                    $totalTagihan += $item['total_harga']; // Menambahkan total harga ke variabel totalTagihan
                @endphp
            @endforeach

            <!-- Row untuk Total Keseluruhan -->
            <tr>
                <td colspan="3" style="text-align: right; font-weight: bold;">Total Keseluruhan</td>
                <td colspan="2">Rp{{ number_format($totalTagihan, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
    <div class="footer">
        <!-- Signature placeholders -->
        <div style="display: flex; justify-content: space-between; width: 100%;">
            <div class="signature" style="text-align: center; width: 45%;">
                <p><strong>Operator</strong></p>
                <div style="border-top: 1px solid #000; width: 60%; margin: 60px auto 0;"></div>
                <p>{{ $data['username'] }}</p>

            </div>
            <div class="signature" style="text-align: center; width: 45%;">
                <p><strong>Penanggung Jawab</strong></p>
                <div style="border-top: 1px solid #000; width: 60%; margin: 60px auto 0;"></div>
                <p>(Nama Penerima)</p>
            </div>
        </div>
    </div>


</body>
</html>
