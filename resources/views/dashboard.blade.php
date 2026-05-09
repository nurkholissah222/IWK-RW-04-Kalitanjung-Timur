<x-app-layout>
    <div class="py-12 bg-slate-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- HEADER HERO -->
            <div class="relative overflow-hidden rounded-3xl p-8 glass-dark">
                <div class="relative z-10">
                    <h2 class="text-3xl font-extrabold mb-2">
                        Dashboard {{ $wilayahText }}
                    </h2>
                    <p class="text-slate-400">Selamat datang kembali, <span class="text-indigo-400 font-semibold">{{ $jabatanText }}</span>. Pantau keuangan dan iuran warga {{ $wilayahText }} secara real-time.</p>
                </div>
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 bg-indigo-500/20 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-48 h-48 bg-purple-500/20 rounded-full blur-3xl"></div>
            </div>

            <!-- STATS WIDGETS -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Saldo RT -->
                <div class="glass-dark rounded-3xl p-6 border-l-4 border-emerald-500 transform transition hover:scale-105">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-emerald-500/20 rounded-2xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="text-right">
                            <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">Breakdown</span>
                            <span class="text-[10px] font-bold text-emerald-400">IWK: Rp {{ number_format($incomeByIWK, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <h3 class="text-slate-400 text-sm font-semibold uppercase tracking-wider">{{ $saldoTitle }}</h3>
                    <p class="text-3xl font-bold mt-1">Rp {{ number_format($totalKas, 0, ',', '.') }}</p>
                    <div class="mt-4 pt-4 border-t border-slate-700/50 flex justify-between items-center text-[11px]">
                        <span class="text-slate-500 font-bold uppercase">Lain-lain</span>
                        <span class="text-slate-300 font-mono">Rp {{ number_format($incomeByOther, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Jumlah Warga -->
                <div class="glass-dark rounded-3xl p-6 border-l-4 border-indigo-500 transform transition hover:scale-105">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-indigo-500/20 rounded-2xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <span class="text-xs font-bold text-indigo-500 bg-indigo-500/10 px-2 py-1 rounded-lg">Total</span>
                    </div>
                    <h3 class="text-slate-400 text-sm font-semibold uppercase tracking-wider">{{ $wargaTitle }}</h3>
                    <p class="text-3xl font-bold mt-1">{{ $jumlahWarga }} <span class="text-sm font-normal text-slate-500">Jiwa</span></p>
                </div>

                <!-- Warga Menunggak -->
                <div class="glass-dark rounded-3xl p-6 border-l-4 border-rose-500 transform transition hover:scale-105">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-rose-500/20 rounded-2xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <span class="text-xs font-bold text-rose-500 bg-rose-500/10 px-2 py-1 rounded-lg">{{ $namaBulan }}</span>
                    </div>
                    <h3 class="text-slate-400 text-sm font-semibold uppercase tracking-wider">Jumlah Menunggak</h3>
                    <p class="text-3xl font-bold mt-1">{{ $jumlahMenunggak }} <span class="text-sm font-normal text-slate-500">Keluarga</span></p>
                </div>
            </div>

            <!-- TABEL DAFTAR TUNGGAKAN -->
            <div class="glass-dark rounded-3xl overflow-hidden shadow-2xl">
                <div class="p-8 border-b border-slate-700/50 flex justify-between items-center">
                    <h3 class="text-xl font-bold flex items-center">
                        <span class="w-2 h-8 bg-rose-500 rounded-full mr-3"></span>
                        Daftar Tunggakan {{ $namaBulan }}
                    </h3>
                    <div class="flex space-x-2">
                         <span class="bg-rose-500/20 text-rose-400 text-xs font-bold px-3 py-1 rounded-full border border-rose-500/30">
                            Urgent: {{ $jumlahMenunggak }}
                        </span>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-800/50">
                                <th class="py-4 px-8 font-semibold text-sm text-slate-400 uppercase tracking-wider">Nama Warga</th>
                                <th class="py-4 px-8 font-semibold text-sm text-slate-400 uppercase tracking-wider">Jenis Iuran</th>
                                <th class="py-4 px-8 font-semibold text-sm text-slate-400 uppercase tracking-wider text-right">Nominal</th>
                                <th class="py-4 px-8 font-semibold text-sm text-slate-400 uppercase tracking-wider text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/30">
                            @forelse($tunggakanWarga as $w)
                                <tr class="hover:bg-white/5 transition">
                                    <td class="py-5 px-8">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-full bg-slate-700 flex items-center justify-center text-slate-300 font-bold mr-3 border border-slate-600">
                                                {{ substr($w->nama_warga, 0, 1) }}
                                            </div>
                                            <span class="text-slate-200 font-medium">{{ $w->nama_warga }}</span>
                                        </div>
                                    </td>
                                    <td class="py-5 px-8">
                                        <span class="px-3 py-1 rounded-lg text-xs font-bold {{ $w->jenis_iuran == 'Andon' ? 'bg-orange-500/20 text-orange-400 border border-orange-500/30' : 'bg-indigo-500/20 text-indigo-400 border border-indigo-500/30' }}">
                                            {{ $w->jenis_iuran }}
                                        </span>
                                    </td>
                                    <td class="py-5 px-8 text-right text-slate-300 font-mono nowrap-nominal">Rp {{ number_format($w->nominal, 0, ',', '.') }}</td>
                                    <td class="py-5 px-8 text-center">
                                        @php
                                            $noWa = $w->no_wa;
                                            $linkWa = '#';
                                            if ($noWa && trim($noWa) !== '') {
                                                $formattedNoWa = preg_replace('/[^0-9]/', '', $noWa);
                                                if (str_starts_with($formattedNoWa, '0')) {
                                                    $formattedNoWa = '62' . substr($formattedNoWa, 1);
                                                }
                                                $nominalRp = number_format($w->nominal, 0, ',', '.');
                                                
                                                // Dynamic RT/RW Info
                                                $user = Auth::user();
                                                $rtNumber = $user->isAdmin() ? 'RW' : 'RT.' . str_pad($user->rtUnit->nomor_rt ?? '00', 2, '0', STR_PAD_LEFT);
                                                $sebutanBendahara = $user->isAdmin() ? 'Bendahara RW' : 'Bendahara ' . $rtNumber;

                                                $pesan = "Halo Bapak/Ibu *" . $w->nama_warga . "*, menginfokan bahwa tunggakan *" . $w->jenis_iuran . "* Anda selama *" . $w->jumlah_bulan . " bulan* adalah sebesar *Rp " . $nominalRp . "*.\n\n";
                                                $pesan .= "Mohon segera dilakukan pembayaran melalui " . $sebutanBendahara . ". Terima kasih.";
                                                
                                                $emoji = "\u{1F64F}";
                                                $linkWa = 'https://api.whatsapp.com/send?phone=' . $formattedNoWa . '&text=' . rawurlencode($pesan . " " . $emoji);
                                            }
                                        @endphp

                                        @if ($noWa && trim($noWa) !== '')
                                            <a href="{{ $linkWa }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-bold rounded-xl shadow-lg shadow-emerald-500/20 transition transform hover:-translate-y-0.5 relative z-10" style="position: relative; z-index: 10;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="mr-2" viewBox="0 0 16 16">
                                                    <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.59-6.584a6.59 6.59 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
                                                </svg>
                                                Kirim WA
                                            </a>
                                        @else
                                            <button onclick="kirimWaKosong('{{ $w->nama_warga }}')" class="inline-flex items-center px-4 py-2 bg-slate-500 hover:bg-slate-600 text-white text-xs font-bold rounded-xl shadow-lg shadow-slate-500/20 transition transform hover:-translate-y-0.5 relative z-10" style="position: relative; z-index: 10;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="mr-2" viewBox="0 0 16 16">
                                                    <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.59-6.584a6.59 6.59 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
                                                </svg>
                                                Kirim WA
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-16 h-16 bg-emerald-500/10 rounded-full flex items-center justify-center mb-4">
                                                <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                            <p class="text-slate-400 font-medium">Luar biasa! Tidak ada tunggakan bulan ini.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function kirimWaKosong(nama) {
            Swal.fire({
                icon: 'warning',
                title: 'Nomor WA Belum Diisi',
                text: 'Nomor WhatsApp belum terdaftar untuk warga: ' + nama,
                background: getComputedStyle(document.body).getPropertyValue('--bg-card').trim() || '#0f172a',
                color: getComputedStyle(document.body).getPropertyValue('--text-main').trim() || '#f8fafc',
                confirmButtonColor: '#4f46e5'
            });
        }
    </script>
</x-app-layout>
