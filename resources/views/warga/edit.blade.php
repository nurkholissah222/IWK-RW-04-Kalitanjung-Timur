<x-app-layout>
    <div class="py-12 bg-slate-950 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-dark rounded-3xl overflow-hidden shadow-2xl border border-white/5">
                <div class="p-8 border-b border-slate-700/50">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <div class="p-2 bg-indigo-600 rounded-xl mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        Edit Data Warga: {{ $warga->nama_warga }}
                    </h2>
                </div>

                <div class="p-8">
                    <form method="POST" action="{{ route('warga.update', $warga->id) }}" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <x-input-label for="nama_warga" value="Nama Lengkap" class="text-slate-400 font-bold mb-1" />
                            <input type="text" name="nama_warga" value="{{ $warga->nama_warga }}" class="mt-1 block w-full rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 py-3 px-4 transition-all" required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="nik" value="NIK (16 Digit)" class="text-slate-400 font-bold mb-1" />
                                <input type="text" name="nik" value="{{ $warga->nik }}" maxlength="16" class="mt-1 block w-full rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 py-3 px-4 transition-all" required>
                            </div>
                            <div>
                                <x-input-label for="no_kk" value="Nomor KK (16 Digit)" class="text-slate-400 font-bold mb-1" />
                                <input type="text" name="no_kk" value="{{ $warga->no_kk }}" maxlength="16" class="mt-1 block w-full rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 py-3 px-4 transition-all" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="no_telp" value="Nomor WhatsApp" class="text-slate-400 font-bold mb-1" />
                                <input type="text" name="no_telp" value="{{ $warga->no_telp }}" placeholder="Contoh: 08123456789" class="mt-1 block w-full rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 py-3 px-4 transition-all">
                            </div>
                            <div>
                                <x-input-label for="status" value="Status Warga" class="text-slate-400 font-bold mb-1" />
                                <select name="status" class="mt-1 block w-full rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 py-3 px-4 transition-all" required>
                                    <option value="Pribumi" {{ $warga->status == 'Pribumi' ? 'selected' : '' }}>Pribumi (Rp 3.000)</option>
                                    <option value="Pendatang" {{ $warga->status == 'Pendatang' ? 'selected' : '' }}>Pendatang (Rp 5.000)</option>
                                </select>
                            </div>
                        </div>

                        @if(Auth::user()->isAdmin() && is_null(Auth::user()->rt_id))
                        <div>
                            <x-input-label for="rt_id" value="Pindah Wilayah RT" class="text-slate-400 font-bold mb-1" />
                            <select name="rt_id" class="mt-1 block w-full rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 py-3 px-4 transition-all" required>
                                @foreach($rt_units as $rt)
                                    <option value="{{ $rt->id }}" {{ $warga->rt_id == $rt->id ? 'selected' : '' }}>RT {{ $rt->nomor_rt }} - {{ $rt->nama_ketua }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        <div class="pt-4 flex justify-end items-center space-x-4">
                            <a href="{{ route('warga.index') }}" class="px-6 py-3 text-slate-400 font-bold hover:text-white transition-colors">Batal</a>
                            <button type="submit" class="px-10 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-black uppercase tracking-widest rounded-xl shadow-xl shadow-indigo-500/30 transition-all transform hover:-translate-y-1">
                                Perbarui Data Warga
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
