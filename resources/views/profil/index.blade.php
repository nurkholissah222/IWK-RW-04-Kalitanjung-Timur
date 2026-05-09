<x-app-layout>
    <div class="py-12 bg-slate-950 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @php $isAdmin = auth()->user()->isAdmin(); @endphp
            <div class="glass-dark rounded-3xl overflow-hidden shadow-2xl border border-white/5">
                
                <!-- Header -->
                <!-- Header -->
                <div class="p-10 border-b border-white/5 relative overflow-hidden">
                    <div class="relative z-10">
                        <h2 class="text-3xl font-black flex items-center text-white">
                            <div class="p-3 bg-indigo-600 rounded-2xl mr-4 shadow-xl shadow-indigo-500/20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                </svg>
                            </div>
                            Profil Pengurus {{ $isAdmin ? 'RW' : 'RT' }}
                        </h2>
                        <p class="text-slate-500 mt-3 font-medium text-lg">Atur informasi pengurus untuk keperluan tanda tangan laporan dan sinkronisasi WhatsApp otomatis.</p>
                    </div>
                </div>

                <div class="p-10">
                    @if (session('success'))
                        <div class="mb-8 p-5 rounded-2xl bg-emerald-50 border border-emerald-200 flex items-center shadow-sm">
                            <div class="bg-emerald-500 p-1.5 rounded-full mr-4">
                                <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-emerald-700 font-bold">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-8 p-5 rounded-2xl bg-rose-50 border border-rose-200 shadow-sm">
                            <ul class="list-disc list-inside text-rose-700 font-bold text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                        <!-- Photo Section -->
                        <div class="md:col-span-1 flex flex-col items-center">
                            <div class="w-56 h-56 rounded-[2.5rem] border-8 border-slate-800 overflow-hidden bg-slate-900 shadow-2xl relative group mb-6">
                                @php
                                    $exists = $profil->foto && file_exists(storage_path('app/public/' . $profil->foto));
                                    $photoUrl = $exists 
                                        ? url('storage-file/' . $profil->foto) . '?v=' . time() 
                                        : 'https://ui-avatars.com/api/?name=' . urlencode($profil->nama_bendahara ?: auth()->user()->name) . '&background=4f46e5&color=fff&size=512';
                                @endphp
                                <img id="photo-preview" src="{{ $photoUrl }}" alt="Foto Bendahara" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                                <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                                    <span class="text-white text-xs font-black uppercase tracking-widest">Pratinjau Foto</span>
                                </div>
                            </div>
                            
                            <div class="flex flex-col w-full gap-3">
                                <label for="foto" class="cursor-pointer w-full py-3 bg-indigo-600 hover:bg-indigo-500 text-white text-center text-xs font-black uppercase tracking-widest rounded-2xl shadow-lg shadow-indigo-500/20 transition-all duration-300 flex items-center justify-center gap-2">
                                    <i class="fas fa-camera"></i>
                                    {{ $profil->foto ? 'Ganti Foto' : 'Unggah Foto' }}
                                </label>
                                
                                @if($profil->foto)
                                <form id="delete-photo-form" action="{{ route('profil-rt.delete-photo') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full py-3 bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs font-black uppercase tracking-widest rounded-2xl transition-all duration-300 flex items-center justify-center gap-2">
                                        <i class="fas fa-trash"></i>
                                        Hapus Foto
                                    </button>
                                </form>
                                @endif
                            </div>
                            
                            <p class="text-[10px] text-slate-400 font-bold text-center mt-6 uppercase tracking-widest leading-relaxed">Format: JPG, PNG, JPEG.<br>Maksimal Ukuran: 2MB.</p>
                        </div>

                        <!-- Input Sections -->
                        <div class="md:col-span-2">
                            <form method="POST" action="{{ route('profil-rt.update') }}" enctype="multipart/form-data" class="space-y-8">
                                @csrf
                                <input type="file" id="foto" name="foto" class="hidden" accept="image/*" onchange="previewImage(event)">
                                
                                <!-- Bendahara -->
                                <div class="glass-dark p-8 rounded-[2rem] border border-white/10 shadow-sm relative overflow-hidden">
                                    <div class="absolute top-0 right-0 p-4 opacity-5">
                                        <i class="fas fa-user-tie text-6xl text-white"></i>
                                    </div>
                                    <h3 class="text-white font-black mb-6 uppercase tracking-widest text-xs flex items-center">
                                        <div class="w-2 h-6 bg-indigo-600 rounded-full mr-3"></div>
                                        Data Bendahara {{ $isAdmin ? 'RW' : 'RT' }}
                                    </h3>
                                    <div class="space-y-5">
                                        <div>
                                            <x-input-label for="nama_bendahara" value="Nama Lengkap Bendahara {{ $isAdmin ? 'RW' : 'RT' }}" class="text-slate-500 font-black uppercase tracking-widest text-[10px] mb-2 ml-1" />
                                            <input id="nama_bendahara" name="nama_bendahara" type="text" value="{{ old('nama_bendahara', Auth::user()->name) }}" 
                                                class="w-full rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none" required />
                                        </div>
                                        <div>
                                            <x-input-label for="no_wa_bendahara" value="No. WA Bendahara {{ $isAdmin ? 'RW' : 'RT' }}" class="text-slate-500 font-black uppercase tracking-widest text-[10px] mb-2 ml-1" />
                                            <input id="no_wa_bendahara" name="no_wa_bendahara" type="text" value="{{ old('no_wa_bendahara', $profil->no_wa_bendahara) }}" 
                                                class="w-full rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none" required />
                                        </div>
                                    </div>
                                </div>

                                <!-- Ketua -->
                                <div class="glass-dark p-8 rounded-[2rem] border border-white/10 shadow-sm relative overflow-hidden">
                                    <div class="absolute top-0 right-0 p-4 opacity-5">
                                        <i class="fas fa-shield-alt text-6xl text-white"></i>
                                    </div>
                                    <h3 class="text-white font-black mb-6 uppercase tracking-widest text-xs flex items-center">
                                        <div class="w-2 h-6 bg-indigo-600 rounded-full mr-3"></div>
                                        Data Ketua {{ $isAdmin ? 'RW' : 'RT' }}
                                    </h3>
                                    <div class="space-y-5">
                                        <div>
                                            <x-input-label for="nama_rt" value="Nama Lengkap Ketua {{ $isAdmin ? 'RW' : 'RT' }}" class="text-slate-500 font-black uppercase tracking-widest text-[10px] mb-2 ml-1" />
                                            <input id="nama_rt" name="nama_rt" type="text" value="{{ old('nama_rt', $profil->nama_rt) }}" 
                                                class="w-full rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none" required />
                                        </div>
                                        <div>
                                            <x-input-label for="no_wa_rt" value="No. WA Ketua {{ $isAdmin ? 'RW' : 'RT' }}" class="text-slate-500 font-black uppercase tracking-widest text-[10px] mb-2 ml-1" />
                                            <input id="no_wa_rt" name="no_wa_rt" type="text" value="{{ old('no_wa_rt', $profil->no_wa_rt) }}" 
                                                class="w-full rounded-2xl px-5 py-3.5 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all outline-none" required />
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-4">
                                    <button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-black uppercase tracking-widest rounded-2xl shadow-xl shadow-indigo-500/20 transition-all duration-300 transform hover:-translate-y-1 active:scale-95">
                                        Simpan Perubahan Profil
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        body { font-family: 'Outfit', sans-serif; }
        .glow-indigo { box-shadow: 0 0 20px rgba(79, 70, 229, 0.4); }
    </style>

    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('photo-preview');
                output.src = reader.result;
            }
            if(event.target.files[0]){
                reader.readAsDataURL(event.target.files[0]);
            }
        }
    </script>
</x-app-layout>
