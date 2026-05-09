<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Keuangan - IWK RW 04</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .summary-box {
            float: right;
            width: 300px;
            border: 1px solid #000;
            padding: 10px;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        .summary-row.total {
            font-weight: bold;
            border-top: 1px solid #000;
            padding-top: 5px;
        }
        @media print {
            body {
                margin: 0;
            }
            button {
                display: none;
            }
        }
    </style>
</head>
<body onload="window.print()">

    <button onclick="window.print()" style="margin-bottom: 20px; padding: 10px; cursor: pointer;">Cetak Sekarang</button>

    <div class="header">
        <h1>Laporan Keuangan Kas</h1>
        <p>IWK RW 04 - RT {{ Auth::user()->rt_id }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" width="5%">No</th>
                <th width="15%">Tanggal</th>
                <th width="40%">Uraian</th>
                <th class="text-right" width="20%">Debit (Masuk)</th>
                <th class="text-right" width="20%">Kredit (Keluar)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksis as $index => $trx)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>
                    {{ $trx->tanggal->format('d/m/Y') }}<br>
                    <small style="color: #666;">Pukul: {{ $trx->created_at->format('H:i') }}</small>
                </td>
                <td>
                    {{ $trx->uraian }}
                    @if($trx->warga)
                        <br><small>Oleh: {{ $trx->warga->nama_lengkap }}</small>
                    @endif
                    @if($trx->category)
                        <small>({{ $trx->category->name }})</small>
                    @endif
                </td>
                <td class="text-right">
                    {{ $trx->jenis_transaksi == 'Masuk' ? 'Rp ' . number_format($trx->jumlah, 0, ',', '.') : '-' }}
                </td>
                <td class="text-right">
                    {{ $trx->jenis_transaksi == 'Keluar' ? 'Rp ' . number_format($trx->jumlah, 0, ',', '.') : '-' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Belum ada data transaksi.</td>
            </tr>
            @endforelse
            <tr>
                <th colspan="3" class="text-right">Total Keseluruhan</th>
                <th class="text-right">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</th>
                <th class="text-right">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</th>
            </tr>
        </tbody>
    </table>

    <div class="summary-box">
        <div class="summary-row">
            <span>Total Masuk:</span>
            <span>Rp {{ number_format($totalMasuk, 0, ',', '.') }}</span>
        </div>
        <div class="summary-row">
            <span>Total Keluar:</span>
            <span>Rp {{ number_format($totalKeluar, 0, ',', '.') }}</span>
        </div>
        <div class="summary-row total">
            <span>Saldo Akhir:</span>
            <span>Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</span>
        </div>
    </div>

    <div style="clear: both; margin-top: 50px;"></div>

    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border: none; margin-top: 30px;">
        <tr>
            <td colspan="2" style="text-align: center; border: none; padding-bottom: 20px;">
                Mengetahui,
            </td>
        </tr>
        <tr>
            <td width="50%" style="text-align: center; border: none; vertical-align: top;">
                Ketua {{ Auth::user()->role == 'RW' ? 'RW.04' : 'RT.' . Auth::user()->unit_rt }}
                <div style="height: 80px;"></div>
                <strong>( {{ strtoupper($profil->nama_rt ?? '....................') }} )</strong>
            </td>
            <td width="50%" style="text-align: center; border: none; vertical-align: top;">
                Cirebon, {{ now()->translatedFormat('d F Y') }}<br>
                Bendahara {{ Auth::user()->role == 'RW' ? 'RW.04' : 'RT.' . Auth::user()->unit_rt }}
                <div style="height: 80px;"></div>
                <strong>( {{ strtoupper(Auth::user()->name) }} )</strong>
            </td>
        </tr>
        @if(Auth::user()->role != 'RW')
        <tr>
            <td colspan="2" style="text-align: center; border: none; padding-top: 40px;">
                Ketua RW.04
                <div style="height: 80px;"></div>
                <strong>( {{ strtoupper($profilRW->nama_rt ?? '....................') }} )</strong>
            </td>
        </tr>
        @endif
    </table>

</body>
</html>
