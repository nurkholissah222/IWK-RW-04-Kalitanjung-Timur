<x-app-layout>
    <div class="p-6 lg:p-8 space-y-8">
        
        <div class="space-y-4">
            <div>
                <h1 class="text-3xl font-black tracking-tight text-slate-100">Manajemen User</h1>
                <p class="text-slate-400 mt-1">Kelola hak akses Admin RW dan Bendahara RT.</p>
            </div>
            
            <div class="flex">
                <a href="{{ route('users.create') }}" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-2xl shadow-xl shadow-indigo-500/20 transition-all duration-300 transform hover:-translate-y-1 active:scale-95 flex items-center gap-2">
                    <i class="fas fa-plus-circle"></i>
                    Buat User Baru
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="p-4 mb-4 text-sm text-emerald-400 rounded-xl bg-emerald-500/10 border border-emerald-500/20" role="alert">
            <span class="font-bold">Berhasil!</span> {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="p-4 mb-4 text-sm text-rose-400 rounded-xl bg-rose-500/10 border border-rose-500/20" role="alert">
            <span class="font-bold">Gagal!</span> {{ session('error') }}
        </div>
        @endif

        <!-- Data Table -->
        <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl overflow-hidden shadow-2xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-white/5 text-slate-300 text-sm uppercase tracking-wider">
                            <th class="p-4 font-bold border-b border-white/10">Nama & Email</th>
                            <th class="p-4 font-bold border-b border-white/10">Role</th>
                            <th class="p-4 font-bold border-b border-white/10">Wilayah</th>
                            <th class="p-4 font-bold border-b border-white/10 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-slate-300 text-sm">
                        @forelse($users as $u)
                        <tr class="border-b border-white/5 hover:bg-white/5 transition">
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                     <div class="flex-shrink-0">
                                         <img src="/storage/{{ str_replace('public/', '', $u->profile_photo_path) }}" 
                                              onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($u->name) }}'"
                                              class="w-10 h-10 rounded-full object-cover"
                                              alt="Foto">
                                     </div>
                                     <div>
                                         <p class="font-bold text-slate-100">{{ $u->name }}</p>
                                         <p class="text-xs text-slate-400">{{ $u->email }}</p>
                                     </div>
                                 </div>
                            </td>
                            <td class="p-4">
                                @if($u->role == 'RW')
                                    <span class="px-3 py-1 bg-amber-500/20 text-amber-400 border border-amber-500/30 rounded-lg text-[10px] font-black uppercase tracking-widest">BENDAHARA RW</span>
                                @else
                                    <span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 rounded-lg text-[10px] font-black uppercase tracking-widest">BENDAHARA RT</span>
                                @endif
                            </td>
                            <td class="p-4">
                                @if($u->role == 'RW')
                                    <span class="text-indigo-600 font-bold text-[10px] uppercase tracking-widest">SELURUH WILAYAH (RW 04)</span>
                                @else
                                    <span class="text-slate-700 font-medium text-[10px] uppercase tracking-widest">WILAYAH RT.{{ $u->unit_rt ?? '00' }}</span>
                                @endif
                            </td>
                            <td class="p-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('users.edit', $u->id) }}" class="p-2 bg-blue-500/20 text-blue-400 rounded-lg hover:bg-blue-500 hover:text-slate-50 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                        </svg>
                                    </a>
                                    @if($u->id !== auth()->id())
                                    <form action="{{ route('users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-rose-500/20 text-rose-400 rounded-lg hover:bg-rose-500 hover:text-white transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-slate-500">Belum ada data user.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
