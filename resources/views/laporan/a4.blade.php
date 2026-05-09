<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan Kas A4</title>
    <meta name="author" content="Sekar Tanjung Maulidia">
    <meta name="subject" content="Laporan Keuangan IWK RW 04">
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 16px;
            text-transform: uppercase;
        }
        .header p {
            margin: 3px 0 0;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f0f0f0;
            text-align: center;
            font-weight: bold;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .signatures {
            width: 100%;
            margin-top: 40px;
            page-break-inside: avoid;
        }
        .signatures table {
            width: 100%;
            border: none;
        }
        .signatures td {
            border: none;
            text-align: center;
            vertical-align: bottom;
            height: 100px;
            width: 33.33%;
            padding: 0;
        }
        .sign-name {
            font-weight: bold;
            text-decoration: underline;
            font-size: 12px;
        }
        .category-label {
            font-style: italic;
            color: #666;
            font-size: 9px;
            display: block;
            margin-top: 2px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>
            LAPORAN KEUANGAN IWK<br>
            BULAN JANUARI SAMPAI DENGAN {{ $endMonth }} {{ $year }}<br>
            {{ $wilayahFilter == 'Semua RT' ? 'RW.04 KALITANJUNG TIMUR' : 'RT.' . $wilayahFilter . '/RW.04 KALITANJUNG TIMUR' }}
        </h1>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">NO</th>
                <th width="12%">Tanggal</th>
                <th width="35%">Uraian / Kegiatan</th>
                <th width="16%">Debit (Pemasukan)</th>
                <th width="16%">Kredit (Pengeluaran)</th>
                <th width="16%">Sisa Saldo</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="5" class="text-right" style="font-weight: bold;">SALDO AWAL</td>
                <td class="text-right" style="font-weight: bold;">Rp {{ number_format($saldoAwal, 0, ',', '.') }}</td>
            </tr>
            @php 
                $runningBalance = $saldoAwal; 
                $totalDebit = 0;
                $totalKredit = 0;
            @endphp
                @foreach($transaksis as $index => $trx)
                @php
                    if($trx->jenis_transaksi == 'Masuk') {
                        $runningBalance += $trx->jumlah;
                        $totalDebit += $trx->jumlah;
                    } else {
                        $runningBalance -= $trx->jumlah;
                        $totalKredit += $trx->jumlah;
                    }
                @endphp
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">
                        {{ $trx->tanggal->format('d/m/Y') }}<br>
                        <span style="font-size: 8px; color: #777;">{{ $trx->created_at->format('H:i') }}</span>
                    </td>
                    <td>
                        {{ $trx->uraian }}
                        @if($trx->category)
                            <span class="category-label">Kategori: {{ $trx->category->name }}</span>
                        @endif
                    </td>
                    <td class="text-right">
                        {{ $trx->jenis_transaksi == 'Masuk' ? 'Rp ' . number_format($trx->jumlah, 0, ',', '.') : '-' }}
                    </td>
                    <td class="text-right">
                        {{ $trx->jenis_transaksi == 'Keluar' ? 'Rp ' . number_format($trx->jumlah, 0, ',', '.') : '-' }}
                    </td>
                    <td class="text-right">Rp {{ number_format($runningBalance, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr>
                <th colspan="3" class="text-right">TOTAL PERIODE INI</th>
                <th class="text-right">Rp {{ number_format($totalDebit, 0, ',', '.') }}</th>
                <th class="text-right">Rp {{ number_format($totalKredit, 0, ',', '.') }}</th>
                <th class="text-right">Rp {{ number_format($runningBalance, 0, ',', '.') }}</th>
            </tr>
        </tbody>
    </table>

    <div class="signatures" style="margin-top: 50px; page-break-inside: avoid;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="line-height: 1.8; page-break-inside: avoid;">
            <tr>
                <td colspan="2" style="text-align: center; border: none; vertical-align: top;">
                    Mengetahui,<br>
                    <div style="height: 1.2em;"></div>
                </td>
            </tr>
            <tr>
                <td width="50%" style="text-align: center; border: none; vertical-align: top;">
                    <br>
                    <br>
                    <div style="height: 1.2em;"></div>
                    Ketua {{ $wilayahFilter == 'Semua RT' ? 'RW.04' : 'RT.' . $wilayahFilter }}
                    <div style="height: 60px;"></div>
                    <strong>( {{ strtoupper($profil->nama_rt ?? '....................') }} )</strong>
                </td>
                <td width="50%" style="text-align: center; border: none; vertical-align: top;">
                    <br>
                    Cirebon, {{ now()->translatedFormat('d F Y') }}<br>
                    <div style="height: 1.2em;"></div>
                    Bendahara {{ $wilayahFilter == 'Semua RT' ? 'RW.04' : 'RT.' . $wilayahFilter }}
                    <div style="height: 60px;"></div>
                    <strong>( {{ strtoupper(Auth::user()->name) }} )</strong>
                </td>
            </tr>
            @if($wilayahFilter != 'Semua RT')
            <tr>
                <td colspan="2" style="text-align: center; border: none; vertical-align: top; padding-top: 30px;">
                    Ketua RW.04
                    <div style="height: 60px;"></div>
                    <strong>( {{ strtoupper($profilRW->nama_rt ?? '....................') }} )</strong>
                </td>
            </tr>
            @endif
        </table>
    </div>

</body>
</html>
