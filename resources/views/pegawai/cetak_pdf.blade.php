<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Distribusi Kepegawaian</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px double #000;
            padding-bottom: 8px;
        }
        .header h2 {
            margin: 0;
            font-size: 16px;
            text-transform: uppercase;
        }
        .header p {
            margin: 4px 0 0 0;
            color: #555;
            font-size: 11px;
        }
        .title {
            text-align: center;
            font-weight: bold;
            font-size: 13px;
            margin-bottom: 15px;
            text-transform: uppercase;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #444;
            padding: 8px;
        }
        table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .chart-section {
            text-align: center;
            margin-top: 15px;
        }
        .chart-image {
            width: 100%;
            max-height: 240px;
        }
        .footer-nota {
            margin-top: 40px;
            float: right;
            width: 250px;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Pemerintah Kota / Kabupaten</h2>
        <h2>Badan Kepegawaian dan Pengembangan SDM</h2>
        <p>Jl. Raya Protokol No. 45, Gedung Pusat Pemerintahan Telp: (021) 123456</p>
    </div>

    <div class="title">Laporan Rekapitulasi Distribusi Pegawai Per SKPD</div>

    <table>
        <thead>
            <tr>
                <th class="text-center" width="10%">No</th>
                <th width="65%">Satuan Kerja Perangkat Daerah (SKPD)</th>
                <th class="text-center" width="25%">Jumlah Pegawai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rekapSkpd as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->skpd }}</td>
                    <td class="text-center">{{ $item->total }} Orang</td>
                </tr>
            @endforeach
            <tr style="background-color: #fafafa; font-weight: bold;">
                <td colspan="2" style="text-align: right; padding-right: 15px;">TOTAL PEGAWAI KESELURUHAN:</td>
                <td class="text-center">{{ $totalPegawaiSemesta }} Orang</td>
            </tr>
        </tbody>
    </table>

    @if($chartImage)
        <div class="chart-section">
            <div style="font-weight: bold; margin-bottom: 5px; text-align: left;">Visualisasi Grafik Batang:</div>
            <img src="{{ $chartImage }}" class="chart-image">
        </div>
    @endif

    <div class="footer-nota">
        <p>Dicetak pada: {{ date('d F Y') }}</p>
        <br><br><br>
        <p><strong>Kepala Bagian Kepegawaian</strong></p>
    </div>

</body>
</html>