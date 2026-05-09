<x-app-layout>
    <div class="py-12 bg-slate-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- HEADER -->
            <div class="relative overflow-hidden rounded-3xl p-8 glass-dark">
                <div class="relative z-10 flex justify-between items-center">
                    <div>
                        <h2 class="text-3xl font-extrabold mb-2 tracking-tight">
                            Data Warga RT {{ Auth::user()->rt_id }}
                        </h2>
                        <p class="text-slate-400">Kelola informasi kependudukan dan status iuran warga secara real-time.</p>
                    </div>
                    <a href="{{ route('warga.create') }}" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl transition shadow-lg shadow-indigo-500/20 glow-indigo flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah Warga
                    </a>
                </div>
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl"></div>
            </div>

            <!-- TABLE -->
            <div class="glass-dark rounded-3xl overflow-hidden shadow-2xl border border-white/5">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-indigo-600/20 border-b border-indigo-500/20">
                                <th class="py-5 px-8 font-black text-xs text-indigo-300 uppercase tracking-widest">Warga</th>
                                <th class="py-5 px-8 font-black text-xs text-indigo-300 uppercase tracking-widest">Identitas (NIK/KK)</th>
                                <th class="py-5 px-8 font-black text-xs text-indigo-300 uppercase tracking-widest text-center">Status</th>
                                <th class="py-5 px-8 font-black text-xs text-indigo-300 uppercase tracking-widest text-center">Jenis Iuran</th>
                                <th class="py-5 px-8 font-black text-xs text-indigo-300 uppercase tracking-widest text-center">Kontak</th>
                                <th class="py-5 px-8 font-black text-xs text-indigo-300 uppercase tracking-widest text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/30">
                            @forelse($wargas as $w)
                                <tr class="hover:bg-white/5 transition group">
                                    <td class="py-6 px-8">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-xl bg-slate-800 flex items-center justify-center mr-4 border border-slate-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            <span class="font-bold tracking-wide">{{ $w->nama_warga }}</span>
                                        </div>
                                    </td>
                                    <td class="py-6 px-8">
                                        <div class="flex flex-col">
                                            <span class="text-xs text-slate-500 font-bold uppercase tracking-tighter">NIK: {{ $w->nik }}</span>
                                            <span class="text-xs text-slate-400 mt-1 font-medium">KK: {{ $w->no_kk ?: $w->kartuKeluarga->no_kk }}</span>
                                        </div>
                                    </td>
                                    <td class="py-6 px-8 text-center">
                                        <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest {{ $w->status == 'Pribumi' ? 'bg-indigo-500/20 text-indigo-400 border border-indigo-500/30' : 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' }}">
                                            {{ $w->status }}
                                        </span>
                                    </td>
                                    <td class="py-6 px-8 text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            <span class="font-black text-sm nowrap-nominal">Rp {{ number_format($w->nominal_iuran, 0, ',', '.') }}</span>
                                            <span class="text-[10px] text-slate-500 font-bold uppercase tracking-widest border-l border-white/10 pl-2">{{ $w->jenis_iuran }}</span>
                                        </div>
                                    </td>
                                    <td class="py-6 px-8 text-center">
                                        @if($w->no_telp)
                                            @php
                                                $cleanPhone = preg_replace('/[^0-9]/', '', $w->no_telp);
                                                if (str_starts_with($cleanPhone, '0')) {
                                                    $cleanPhone = '62' . substr($cleanPhone, 1);
                                                }
                                                
                                                // Dynamic RT/RW Info
                                                $user = Auth::user();
                                                $rtNumber = $user->isAdmin() ? 'RW' : 'RT.' . str_pad($user->rtUnit->nomor_rt ?? '00', 2, '0', STR_PAD_LEFT);
                                                $sebutanBendahara = $user->isAdmin() ? 'Bendahara RW' : 'Bendahara ' . $rtNumber;

                                                $waMsg = "Assalamu'alaikum wr wb.\n\n";
                                                $waMsg .= "Halo Bapak/Ibu " . $w->nama_warga . ", salam hangat dari pengurus " . $rtNumber . ". Mohon maaf mengganggu waktunya sebentar. Kami ingin menginformasikan terkait iuran IWK warga yang saat ini masih tertunda sebesar Rp " . number_format($w->tunggakan ?? 0, 0, ',', '.') . ".\n\n";
                                                $waMsg .= "Semoga Bapak/Ibu sekeluarga selalu diberikan kesehatan dan dilancarkan pintu rezekinya oleh Allah SWT. Amin.\n\n";
                                                $waMsg .= "Jika Bapak/Ibu ada waktu senggang, pembayaran bisa dilakukan melalui " . $sebutanBendahara . " ya. Terima kasih banyak atas partisipasinya untuk lingkungan kita. ";
                                                
                                                $emoji = "\u{1F64F}";
                                                $waUrl = "https://api.whatsapp.com/send?phone=" . $cleanPhone . "&text=" . rawurlencode($waMsg . " " . $emoji . $emoji);
                                            @endphp
                                            <a href="{{ $waUrl }}" target="_blank" class="inline-flex items-center text-emerald-400 hover:text-emerald-300 transition font-bold text-sm bg-emerald-500/10 px-4 py-2 rounded-xl border border-emerald-500/20">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                                </svg>
                                                {{ $w->no_telp }}
                                            </a>
                                        @else
                                            <span class="text-slate-600 text-xs italic">N/A</span>
                                        @endif
                                    </td>
                                    <td class="py-6 px-8 text-center">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('warga.edit', $w->id) }}" class="p-2.5 bg-slate-800 hover:bg-indigo-500/20 text-slate-400 hover:text-indigo-400 rounded-xl transition border border-slate-700 hover:border-indigo-500/30">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('warga.destroy', $w->id) }}" method="POST" onsubmit="return confirm('Hapus data warga ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2.5 bg-slate-800 hover:bg-rose-500/20 text-slate-400 hover:text-rose-400 rounded-xl transition border border-slate-700 hover:border-rose-500/30">
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
                                    <td colspan="6" class="py-12 text-center text-slate-500 font-medium">Belum ada data warga terdaftar di RT ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
