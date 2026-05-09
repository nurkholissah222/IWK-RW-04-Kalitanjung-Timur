<x-app-layout>
    <div class="py-12 bg-slate-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Header & Actions -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-3xl font-black tracking-tight">Laporan Keuangan</h1>
                    <p class="text-slate-400 mt-1 font-medium">Rekapitulasi pemasukan dan pengeluaran kas RT.</p>
                </div>
                
                @if($user->isAdmin())
                <form method="GET" action="{{ route('laporan.index') }}" class="flex items-center space-x-3 bg-white/5 p-2 rounded-2xl border border-white/10 backdrop-blur-md">
                    <select name="rt_id" class="bg-slate-800 text-slate-200 border border-slate-700 rounded-xl px-4 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500 transition shadow-inner">
                        <option value="">Semua RT</option>
                        @foreach($rts as $rt)
                            <option value="{{ $rt->id }}" {{ $selectedRt == $rt->id ? 'selected' : '' }}>RT {{ $rt->nomor_rt }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-bold rounded-xl transition shadow-lg shadow-indigo-500/30">
                        Filter
                    </button>
                </form>
                @endif
            </div>

            <!-- Summary Widgets -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Masuk -->
                <div class="bg-emerald-500/5 backdrop-blur-xl border border-emerald-500/20 rounded-[2rem] p-8 relative overflow-hidden group transition-all duration-500 hover:border-emerald-500/40 shadow-2xl">
                    <div class="absolute -right-8 -top-8 w-32 h-32 bg-emerald-500/10 rounded-full blur-3xl group-hover:bg-emerald-500/20 transition duration-700"></div>
                    <p class="text-emerald-400/60 font-bold uppercase tracking-widest text-[10px] mb-3">Total Masuk (Debit)</p>
                    <h2 class="text-4xl font-black text-emerald-400 tracking-tight group-hover:scale-105 transition duration-500 origin-left">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</h2>
                </div>
                
                <!-- Total Keluar -->
                <div class="bg-rose-500/5 backdrop-blur-xl border border-rose-500/20 rounded-[2rem] p-8 relative overflow-hidden group transition-all duration-500 hover:border-rose-500/40 shadow-2xl">
                    <div class="absolute -right-8 -top-8 w-32 h-32 bg-rose-500/10 rounded-full blur-3xl group-hover:bg-rose-500/20 transition duration-700"></div>
                    <p class="text-rose-400/60 font-bold uppercase tracking-widest text-[10px] mb-3">Total Keluar (Kredit)</p>
                    <h2 class="text-4xl font-black text-rose-400 tracking-tight group-hover:scale-105 transition duration-500 origin-left">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</h2>
                </div>

                <!-- Saldo Akhir -->
                <div class="bg-indigo-600/20 backdrop-blur-2xl border border-indigo-400/30 rounded-[2rem] p-8 relative overflow-hidden group shadow-2xl shadow-indigo-900/40 transition-all duration-500 hover:scale-[1.02]">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-indigo-500/20 rounded-full blur-3xl group-hover:bg-white/10 transition duration-700"></div>
                    <p class="text-indigo-300 font-bold uppercase tracking-widest text-[10px] mb-3">Saldo Akhir</p>
                    <h2 class="text-4xl font-black tracking-tight">Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</h2>
                </div>
            </div>

            <!-- Data Table (Glassmorphism) -->
            <div class="glass-dark rounded-3xl overflow-hidden shadow-2xl border border-white/5">
                <div class="p-8 border-b border-slate-700/50 flex flex-col md:flex-row justify-between items-center gap-4">
                    <h2 class="text-xl font-bold flex items-center">
                        <span class="w-2 h-8 bg-indigo-500 rounded-full mr-3"></span>
                        Rincian Transaksi
                    </h2>
                    <div class="flex flex-row flex-wrap justify-end gap-3">
                        @php $printQuery = $selectedRt ? '?rt_id='.$selectedRt : ''; @endphp
                        <a href="{{ route('laporan.a4') . $printQuery }}" target="_blank" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-bold rounded-xl transition shadow-lg shadow-indigo-500/30 flex items-center gap-2 border border-white/10 backdrop-blur-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            Print Laporan
                        </a>
                        <a href="{{ route('laporan.a3') . $printQuery }}" target="_blank" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-bold rounded-xl transition shadow-lg shadow-indigo-500/30 flex items-center gap-2 border border-white/10 backdrop-blur-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            Cetak PDF A3
                        </a>
                        <a href="{{ route('laporan.a4') . $printQuery }}" target="_blank" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-bold rounded-xl transition shadow-lg shadow-indigo-500/30 flex items-center gap-2 border border-white/10 backdrop-blur-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            Cetak PDF A4
                        </a>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-800/50 text-slate-300 text-sm uppercase tracking-wider">
                                <th class="py-5 px-8 font-bold border-b border-slate-700/50 text-center">No</th>
                                <th class="py-5 px-8 font-bold border-b border-slate-700/50">Tanggal & Waktu</th>
                                <th class="py-5 px-8 font-bold border-b border-slate-700/50">Uraian</th>
                                <th class="py-5 px-8 font-bold border-b border-slate-700/50 text-right">Debit</th>
                                <th class="py-5 px-8 font-bold border-b border-slate-700/50 text-right">Kredit</th>
                                <th class="py-5 px-8 font-bold border-b border-slate-700/50 text-center no-print">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-slate-300 text-sm">
                            @forelse($transaksis as $index => $trx)
                            <tr class="border-b border-slate-700/30 hover:bg-white/5 transition">
                            <td class="py-5 px-8 text-center">{{ $loop->iteration }}</td>
                            <td class="py-5 px-8 whitespace-nowrap">
                                <span class="block font-bold">{{ $trx->tanggal->format('d/m/Y') }}</span>
                                <span class="text-[10px] text-slate-500 font-medium">Pukul: {{ $trx->created_at->format('H:i') }}</span>
                            </td>
                                <td class="py-5 px-8">
                                    <span class="block font-medium">{{ $trx->uraian }}</span>
                                    @if($trx->warga)
                                        <span class="text-xs text-slate-400">Oleh: {{ $trx->warga->nama_lengkap }}</span>
                                    @endif
                                    @if($trx->category)
                                        <span class="text-xs text-indigo-400 ml-2">[{{ $trx->category->name }}]</span>
                                    @endif
                                </td>
                                <td class="py-5 px-8 text-right font-medium text-emerald-400">
                                    <span class="nowrap-nominal">{{ $trx->jenis_transaksi == 'Masuk' ? 'Rp ' . number_format($trx->jumlah, 0, ',', '.') : '-' }}</span>
                                </td>
                                <td class="py-5 px-8 text-right text-rose-400 font-mono">
                                    <span class="nowrap-nominal">{{ $trx->jenis_transaksi == 'Keluar' ? 'Rp ' . number_format($trx->jumlah, 0, ',', '.') : '-' }}</span>
                                </td>
                                <td class="py-5 px-8 text-center no-print">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('laporan.edit', $trx->id) }}" class="p-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg transition shadow-md shadow-indigo-500/20" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('laporan.destroy', $trx->id) }}" method="POST" onsubmit="return confirm('Hapus transaksi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 bg-rose-600 hover:bg-rose-500 text-white rounded-lg transition shadow-md shadow-rose-500/20" title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="p-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 bg-white/5 rounded-full flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0l-8 8-8-8"></path></svg>
                                        </div>
                                        <p class="text-slate-500 font-medium">Belum ada data transaksi.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="bg-indigo-600 text-white font-bold">
                            <tr>
                                <td colspan="3" class="py-5 px-8 text-right uppercase tracking-widest text-xs text-white border-t border-white/10">Total Keseluruhan</td>
                                <td class="py-5 px-8 text-right text-white border-t border-white/10">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</td>
                                <td class="py-5 px-8 text-right text-white border-t border-white/10">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</td>
                                <td class="py-5 px-8 border-t border-white/10 no-print"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
