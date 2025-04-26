<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Resep</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 5px; }
        th, td { border: 1px solid #000; padding: 3px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; font-size: 14px; font-weight: bold; }
        .sub-header { text-align: center; font-size: 12px; }
        .total { font-weight: bold; }
        .page-break { page-break-before: always; }

        .signature-container {
    margin-top: 30px; /* Beri jarak antara tabel dan tanda tangan */
}

        .notes {margin-top: 15px; font-size: 11px; }
    </style>
</head>
<body>
    @foreach ($kelompokData as $index => $group)
        {{-- @if ($index > 0)
            <div class="page-break"></div>
        @endif --}}
        @if (!$loop->first)
            <div class="page-break"></div>
        @endif


        <div class="header">Laporan Resep</div>
        <div class="sub-header">Klinik Omega</div>
        <p>Dicetak pada: {{ now()->translatedFormat('d F Y, H:i') }}</p>
        <p>Resep untuk Pasien: <strong>{{ $nama_pasien }}</strong></p>
        <p>Dokter: {{ $namaDokter ?? '-' }}</p>

        @php
            $jenisResep = preg_replace('/^R:\s*\/\s*/', '', $group['header']) ?: 'Revisi Resep Dokter';
        @endphp

        @if ($group['header'] === 'R/')
            <p><strong>Jenis Resep: </strong> Resep Obat Dokter</p>
        @else
            <p><strong>Jenis Resep: </strong> {{ $jenisResep }}</p>
        @endif


        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Obat</th>
                    <th>Jumlah</th>
                    <th>Aturan Pakai</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($group['items'] as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item['nama_obat'] ?? '-' }}</td>
                        <td>{{ $item['jumlah'] ?? '-' }}</td>
                        <td>{{ $item['aturan_pakai'] ?? '-' }}</td>
                        <td>{{ $item['keterangan'] ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="notes">
            <table style="width: 100%; border-collapse: collapse; border: 1px solid black;">
                <tr>
                    <td style="width: 10%; vertical-align: top; border: none;">
                        <p><strong>Catatan:</strong></p>
                    </td>
                    <td style="width: 90%; vertical-align: middle; border: none;">
                        <p> {{ $notes ?? ' ' }} </p>
                    </td>
                </tr>
            </table>
        </div>
        {{-- <div class="notes">
            <p><strong>Catatan:</strong> ............................................................................................................................................................................................................................................................................</p>
        </div> --}}

        <div class="signature-container">
            <table style="width: 100%; text-align: center; border: none;">
                <tr>
                    <td style="width: 50%; text-align: center; border: none;">
                        <p><strong>Paraf Petugas</strong></p>
                        <br><br><br> <!-- Ruang kosong untuk tanda tangan -->
                        <p>____________________</p>
                        <p>( {{ $username ?? '-' }} )</p>
                    </td>
                    <td style="width: 50%; text-align: center; border: none;">
                        <p><strong>Penerima (Pasien)</strong></p>
                        <br><br><br> <!-- Ruang kosong untuk tanda tangan -->
                        <p>____________________</p>
                        <p>( {{ $nama_pasien ?? 'Pasien' }} )</p>
                    </td>
                </tr>
            </table>
        </div>

    @endforeach
</body>
</html>
