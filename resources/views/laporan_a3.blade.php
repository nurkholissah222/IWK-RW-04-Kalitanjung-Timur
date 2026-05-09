<!DOCTYPE html>
<html>
<head>
    <title>Laporan Publik A3 - RT {{ $user->rtUnit->nomor_rt ?? '' }}</title>
    <style>
        @page { size: A3 landscape; margin: 3cm; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; line-height: 1.5; }
        .header { text-align: center; border-bottom: 5px double #333; padding-bottom: 20px; margin-bottom: 30px; }
        .header h1 { font-size: 50px; margin: 0; text-transform: uppercase; letter-spacing: 2px; }
        .header p { font-size: 24px; margin: 10px 0 0 0; color: #666; }
        
        .summary-box { display: block; width: 100%; margin-bottom: 40px; }
        .card { background: #f9f9f9; border: 1px solid #ddd; padding: 25px; margin-bottom: 15px; border-radius: 10px; }
        .card-title { font-size: 28px; font-weight: bold; border-bottom: 2px solid #indigo; margin-bottom: 15px; padding-bottom: 5px; color: #4f46e5; }
        
        table { width: 100%; border-collapse: collapse; font-size: 20px; }
        th { background-color: #4f46e5; color: white; padding: 15px; text-align: left; text-transform: uppercase; }
        td { padding: 15px; border-bottom: 1px solid #eee; }
        .total-row { background-color: #f3f4f6; font-weight: bold; font-size: 24px; }
        
        .footer { margin-top: 50px; text-align: right; font-size: 20px; }
        .signature { margin-top: 100px; display: inline-block; text-align: center; border-top: 2px solid #333; padding-top: 10px; width: 300px; }
        
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .text-green { color: #059669; }
        .text-red { color: #dc2626; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN TRANSPARANSI KAS RT {{ $user->rtUnit->nomor_rt ?? '...' }}</h1>
        <p>Periode Kuartal: {{ $periode }}</p>
    </div>

    <div class="summary-box">
        <div class="card">
            <div class="card-title">RINGKASAN TOTAL PER KATEGORI</div>
            <table>
                <thead>
                    <tr>
                        <th>Nama Kategori</th>
                        <th>Tipe</th>
                        <th class="text-right">Total Nominal</th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                        $grandTotalMasuk = 0;
                        $grandTotalKeluar = 0;
                    @endphp
                    @foreach($grouped as $categoryName => $items)
                        @php 
                            $totalCategory = $items->sum('jumlah');
                            $type = $items->first()->jenis_transaksi;
                            if($type == 'Masuk') $grandTotalMasuk += $totalCategory;
                            else $grandTotalKeluar += $totalCategory;
                        @endphp
                        <tr>
                            <td>{{ $categoryName }}</td>
                            <td>
                                <span class="{{ $type == 'Masuk' ? 'text-green' : 'text-red' }}">
                                    {{ $type }}
                                </span>
                            </td>
                            <td class="text-right">Rp {{ number_format($totalCategory, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="2">TOTAL SALDO AKHIR (KAS BERSIH)</td>
                        <td class="text-right">Rp {{ number_format($grandTotalMasuk - $grandTotalKeluar, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="footer">
        <p>Kalitanjung Timur, {{ now()->translatedFormat('d F Y') }}</p>
        <div class="signature">
            <strong>{{ $user->name }}</strong><br>
            Bendahara RT {{ $user->rtUnit->nomor_rt ?? '' }}
        </div>
    </div>
</body>
</html>
