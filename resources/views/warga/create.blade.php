<x-app-layout>
    <div class="py-12 bg-slate-950 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-dark rounded-3xl overflow-hidden shadow-2xl border border-white/5">
                <div class="p-8 border-b border-slate-700/50">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <div class="p-2 bg-indigo-600 rounded-xl mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                        </div>
                        Tambah Data Warga Baru
                    </h2>
                </div>

                <div class="p-8">
                    @if (session('success'))
                        <div class="mb-6 bg-emerald-500/20 border border-emerald-500/50 text-emerald-300 px-5 py-4 rounded-xl flex items-center shadow-lg shadow-emerald-500/10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-bold">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-6 bg-rose-500/20 border border-rose-500/50 text-rose-300 px-5 py-4 rounded-xl shadow-lg shadow-rose-500/10">
                            <div class="flex items-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <span class="font-bold">Gagal menyimpan data:</span>
                            </div>
                            <ul class="list-disc list-inside text-sm ml-7">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('warga.store') }}" class="space-y-6">
                        @csrf
                        
                        <div>
                            <x-input-label for="nama_warga" value="Nama Lengkap" class="text-slate-400 font-bold mb-1" />
                            <input type="text" name="nama_warga" class="mt-1 block w-full rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 py-3 px-4 transition-all" required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="nik" value="NIK (16 Digit)" class="text-slate-400 font-bold mb-1" />
                                <input type="text" name="nik" maxlength="16" class="mt-1 block w-full rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 py-3 px-4 transition-all" required>
                            </div>
                            <div>
                                <x-input-label for="no_kk" value="Nomor KK (16 Digit)" class="text-slate-400 font-bold mb-1" />
                                <input type="text" name="no_kk" maxlength="16" class="mt-1 block w-full rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 py-3 px-4 transition-all" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="no_telp" value="Nomor WhatsApp" class="text-slate-400 font-bold mb-1" />
                                <input type="text" name="no_telp" placeholder="Contoh: 08123456789" class="mt-1 block w-full rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 py-3 px-4 transition-all">
                            </div>
                            <div>
                                <x-input-label for="status" value="Status Warga" class="text-slate-400 font-bold mb-1" />
                                <select name="status" class="mt-1 block w-full rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 py-3 px-4 transition-all" required>
                                    <option value="Pribumi">Pribumi (Rp 3.000)</option>
                                    <option value="Pendatang">Pendatang (Rp 5.000)</option>
                                </select>
                            </div>
                        </div>

                        @if(Auth::user()->isAdmin() && is_null(Auth::user()->rt_id))
                        <div>
                            <x-input-label for="rt_id" value="Pilih RT Lokasi Warga" class="text-slate-400 font-bold mb-1" />
                            <select name="rt_id" class="mt-1 block w-full rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 py-3 px-4 transition-all" required>
                                <option value="" disabled selected>-- Pilih RT --</option>
                                @foreach($rt_units as $rt)
                                    <option value="{{ $rt->id }}">RT {{ $rt->nomor_rt }} - {{ $rt->nama_ketua }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        <div class="pt-4 flex justify-end items-center space-x-4">
                            <a href="{{ route('warga.index') }}" class="px-6 py-3 text-slate-400 font-bold hover:text-white transition-colors">Batal</a>
                            <button type="submit" class="px-10 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-black uppercase tracking-widest rounded-xl shadow-xl shadow-indigo-500/30 transition-all transform hover:-translate-y-1">
                                Simpan Data Warga
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
