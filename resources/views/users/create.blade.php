<x-app-layout>
    <div class="p-6 lg:p-8">
        <div class="max-w-2xl mx-auto">
            
            <div class="mb-8">
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">Buat Akun Baru</h1>
                <p class="text-slate-600 mt-2 font-medium">Tambahkan Petugas RT atau Admin RW baru ke dalam sistem.</p>
            </div>

            <div class="bg-white border border-slate-200 rounded-[2.5rem] shadow-2xl shadow-slate-200/50 p-10">
                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Nama -->
                    <div>
                        <label class="block text-sm font-black uppercase tracking-widest text-slate-500 mb-2 ml-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" required 
                               placeholder="Contoh: Budi Santoso"
                               class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 text-slate-900 placeholder-slate-400 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all duration-300 outline-none">
                        @error('name') <p class="mt-2 text-sm text-rose-500 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <!-- Foto Profil -->
                    <div>
                        <label class="block text-sm font-black uppercase tracking-widest text-slate-500 mb-2 ml-1">Foto Profil (Opsional)</label>
                        <input type="file" name="profile_photo" 
                               class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3 text-slate-900 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all duration-300 outline-none">
                        <p class="text-[10px] text-slate-400 mt-2 font-bold uppercase tracking-wider">Format: JPG, PNG. Max: 2MB.</p>
                        @error('profile_photo') <p class="mt-2 text-sm text-rose-500 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <!-- Role & Wilayah -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-sm font-black uppercase tracking-widest text-slate-500 mb-2 ml-1">Peran (Role)</label>
                            <div class="relative">
                                <select name="role" id="role" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 text-slate-900 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all duration-300 outline-none appearance-none cursor-pointer">
                                    <option value="RT" {{ old('role') == 'RT' ? 'selected' : '' }}>Bendahara RT</option>
                                    <option value="RW" {{ old('role') == 'RW' ? 'selected' : '' }}>Bendahara RW</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-400">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                            @error('role') <p class="mt-2 text-sm text-rose-500 font-bold">{{ $message }}</p> @enderror
                        </div>
                        <div id="rt_id_container">
                            <label class="block text-sm font-black uppercase tracking-widest text-slate-500 mb-2 ml-1">Wilayah RT</label>
                            <div class="relative">
                                <select name="rt_id" id="rt_id" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 text-slate-900 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all duration-300 outline-none appearance-none cursor-pointer">
                                    @foreach($rts as $rt)
                                        <option value="{{ $rt->id }}" {{ old('rt_id') == $rt->id ? 'selected' : '' }}>RT {{ $rt->nomor_rt }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-400">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                            <p class="text-[10px] text-slate-400 mt-2 font-bold uppercase tracking-wider">Abaikan jika Role adalah Bendahara RW.</p>
                            @error('rt_id') <p class="mt-2 text-sm text-rose-500 font-bold">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4">
                        <div>
                            <label class="block text-sm font-black uppercase tracking-widest text-slate-500 mb-2 ml-1">Password</label>
                            <div class="relative group">
                                <input type="password" name="password" required placeholder="••••••••"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 text-slate-900 placeholder-slate-400 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all duration-300 outline-none">
                                <button type="button" onclick="togglePassword(this)" class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-indigo-600 transition-colors focus:outline-none">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password') <p class="mt-2 text-sm text-rose-500 font-bold">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-black uppercase tracking-widest text-slate-500 mb-2 ml-1">Konfirmasi Password</label>
                            <div class="relative group">
                                <input type="password" name="password_confirmation" required placeholder="••••••••"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-3.5 text-slate-900 placeholder-slate-400 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all duration-300 outline-none">
                                <button type="button" onclick="togglePassword(this)" class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-indigo-600 transition-colors focus:outline-none">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="pt-10 flex justify-end gap-4 border-t border-slate-100">
                        <a href="{{ route('users.index') }}" class="px-8 py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-black uppercase tracking-widest text-xs rounded-2xl transition-all duration-300">Batal</a>
                        <button type="submit" class="px-10 py-3.5 bg-indigo-600 hover:bg-indigo-500 text-white font-black uppercase tracking-widest text-xs rounded-2xl shadow-xl shadow-indigo-500/20 hover:shadow-indigo-500/40 transition-all duration-300 transform hover:-translate-y-1 active:scale-[0.98]">Simpan Akun</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role');
            const rtContainer = document.getElementById('rt_id_container');
            const rtSelect = document.getElementById('rt_id');

            function toggleRt() {
                if (roleSelect.value === 'RW') {
                    rtContainer.style.opacity = '0.5';
                    rtSelect.disabled = true;
                } else {
                    rtContainer.style.opacity = '1';
                    rtSelect.disabled = false;
                }
            }

            roleSelect.addEventListener('change', toggleRt);
            toggleRt(); // Initialize
        });
    </script>
</x-app-layout>
