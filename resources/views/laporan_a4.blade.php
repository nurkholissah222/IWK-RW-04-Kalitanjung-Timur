<!DOCTYPE html>
<html>
<head>
    <title>Arsip Laporan A4 - RT {{ $user->rtUnit->nomor_rt ?? '' }}</title>
    <style>
        @page { size: A4 portrait; margin: 1cm; }
        body { font-family: 'Arial', sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { margin: 0; font-size: 18px; }
        .detail-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .detail-table th { background: #f2f2f2; border: 1px solid #ccc; padding: 8px; text-align: left; }
        .detail-table td { border: 1px solid #ccc; padding: 6px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .footer { margin-top: 30px; }
        .summary-mini { float: right; width: 250px; border: 1px solid #000; padding: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>ARSIP TRANSPARANSI IURAN WARGA (IWK)</h2>
        <p>Unit RT {{ $user->rtUnit->nomor_rt ?? '...' }} | Periode: {{ $periode }}</p>
    </div>

    <table class="detail-table">
        <thead>
            <tr>
                <th width="15%">Tanggal</th>
                <th width="35%">Keterangan / Uraian</th>
                <th width="20%">Pihak Terkait</th>
                <th width="10%">Tipe</th>
                <th width="20%" class="text-right">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($transaksis as $trx)
                @php 
                    if($trx->jenis_transaksi == 'Masuk') $total += $trx->jumlah;
                    else $total -= $trx->jumlah;
                @endphp
                <tr>
                    <td>{{ $trx->tanggal->format('d/m/Y') }}</td>
                    <td>{{ $trx->uraian }}</td>
                    <td>{{ $trx->warga->nama_warga ?? '-' }}</td>
                    <td class="text-center">{{ $trx->jenis_transaksi }}</td>
                    <td class="text-right">Rp {{ number_format($trx->jumlah, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background: #f9f9f9; font-weight: bold;">
                <td colspan="4" class="text-right">SALDO AKHIR PERIODE INI</td>
                <td class="text-right">Rp {{ number_format($total, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Dokumen ini dicetak secara otomatis melalui Sistem IWK RW 04 pada {{ now()->format('d/m/Y H:i') }}</p>
        <p>Oleh: {{ $user->name }} (Bendahara)</p>
    </div>
</body>
</html>
