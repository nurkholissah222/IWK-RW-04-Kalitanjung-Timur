<x-app-layout>
    <div class="py-12 bg-slate-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- HEADER -->
            <div class="relative overflow-hidden rounded-3xl p-8 glass-dark">
                <div class="relative z-10">
                    <h2 class="text-3xl font-extrabold mb-2">
                        Master Kategori Kas
                    </h2>
                    <p class="text-slate-400">Kelola kategori pemasukan dan pengeluaran untuk sistem iuran RW 04.</p>
                </div>
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl"></div>
            </div>

            <!-- ALERTS -->
            @if(session('status'))
                <div class="p-4 glass bg-emerald-500/20 text-emerald-400 rounded-2xl border border-emerald-500/30 font-bold">
                    {{ session('status') }}
                </div>
            @endif
            @if(session('error'))
                <div class="p-4 glass bg-rose-500/20 text-rose-400 rounded-2xl border border-rose-500/30 font-bold">
                    {{ session('error') }}
                </div>
            @endif

            <!-- FILTER -->
            <div class="glass-dark rounded-3xl p-6 border border-white/5 shadow-xl">
                <form method="GET" action="{{ route('kategori.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <div>
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 block">Cari Nama</label>
                        <input type="text" name="name" value="{{ request('name') }}" placeholder="Ketik nama..." class="w-full bg-slate-800 text-slate-200 border border-slate-700 rounded-xl px-4 py-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500 transition shadow-inner">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 block">Tipe</label>
                        <select name="type" class="w-full bg-slate-800 text-slate-200 border border-slate-700 rounded-xl px-4 py-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500 transition shadow-inner">
                            <option value="">Semua Tipe</option>
                            <option value="pemasukan" {{ request('type') == 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                            <option value="pengeluaran" {{ request('type') == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 block">Tanggal Buat</label>
                        <input type="date" name="date" value="{{ request('date') }}" class="w-full bg-slate-800 text-slate-200 border border-slate-700 rounded-xl px-4 py-2.5 text-sm focus:ring-indigo-500 focus:border-indigo-500 transition shadow-inner">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-bold rounded-xl transition shadow-lg shadow-indigo-500/30">
                            Filter
                        </button>
                        <a href="{{ route('kategori.index') }}" class="flex-1 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white text-sm text-center font-bold rounded-xl transition shadow-lg shadow-indigo-500/30">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- TABLE -->
            <div class="glass-dark rounded-3xl overflow-hidden shadow-2xl relative z-10">
                <div class="p-8 border-b border-slate-700/50 flex flex-col md:flex-row justify-between items-center gap-4">
                    <h3 class="text-xl font-bold flex items-center">
                        <span class="w-2 h-8 bg-indigo-500 rounded-full mr-3"></span>
                        Daftar Kategori
                    </h3>
                    <button onclick="openAddModal()" class="w-full md:w-auto px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition shadow-lg shadow-indigo-500/20 glow-indigo">
                        + Tambah Kategori
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-800/50">
                                <th class="py-4 px-8 font-semibold text-sm text-slate-400 uppercase tracking-wider">Nama Kategori</th>
                                <th class="py-4 px-8 font-semibold text-sm text-slate-400 uppercase tracking-wider text-center">Tipe</th>
                                <th class="py-4 px-8 font-semibold text-sm text-slate-400 uppercase tracking-wider">Deskripsi</th>
                                <th class="py-4 px-8 font-semibold text-sm text-slate-400 uppercase tracking-wider text-center">Tanggal</th>
                                <th class="py-4 px-8 font-semibold text-sm text-slate-400 uppercase tracking-wider text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/30">
                            @forelse($categories as $cat)
                                <tr class="hover:bg-white/5 transition group">
                                    <td class="py-5 px-8">
                                        <span class="text-slate-200 font-bold tracking-wide">{{ $cat->name }}</span>
                                    </td>
                                    <td class="py-5 px-8 text-center">
                                        <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest {{ $cat->type == 'pemasukan' ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : 'bg-rose-500/20 text-rose-400 border border-rose-500/30' }}">
                                            {{ $cat->type }}
                                        </span>
                                    </td>
                                    <td class="py-5 px-8 text-slate-400 text-sm italic">
                                        {{ $cat->description }}
                                    </td>
                                    <td class="py-5 px-8 text-center text-slate-400 text-xs font-mono">
                                        {{ $cat->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="py-5 px-8 text-center">
                                        <div class="flex justify-center space-x-2">
                                            <button onclick="openEditModal({{ $cat->id }}, '{{ $cat->name }}', '{{ $cat->type }}', '{{ $cat->description }}')" class="p-2 border border-indigo-500/50 hover:border-indigo-400 hover:bg-indigo-500/10 text-indigo-400 rounded-xl transition-all duration-300 z-20" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </button>
                                            <button onclick="confirmDelete({{ $cat->id }}, '{{ $cat->name }}')" class="p-2 border border-indigo-500/50 hover:border-indigo-400 hover:bg-indigo-500/10 text-indigo-400 rounded-xl transition-all duration-300 z-20" title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center text-slate-500 font-medium">Data tidak ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- MODAL ADD/EDIT -->
    <div id="categoryModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-slate-950/80 backdrop-blur-sm"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom glass-dark rounded-3xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-white/10">
                <form id="categoryForm" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <div class="p-8">
                        <h3 class="text-2xl font-bold mb-6" id="modalTitle">Tambah Kategori</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="name" value="Nama Kategori" class="text-slate-400 font-bold mb-1" />
                                <input type="text" name="name" id="modalName" class="mt-1 block w-full bg-slate-800 text-slate-200 rounded-xl border border-slate-700 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 px-4 py-3" required>
                            </div>
                            
                            <div>
                                <x-input-label for="type" value="Tipe" class="text-slate-400 font-bold mb-1" />
                                <select name="type" id="modalType" class="mt-1 block w-full bg-slate-800 text-slate-200 rounded-xl border border-slate-700 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 px-4 py-3" required>
                                    <option value="pemasukan" class="bg-slate-800">Pemasukan</option>
                                    <option value="pengeluaran" class="bg-slate-800">Pengeluaran</option>
                                </select>
                            </div>
 
                            <div>
                                <x-input-label for="description" value="Deskripsi" class="text-slate-400 font-bold mb-1" />
                                <textarea name="description" id="modalDescription" rows="3" class="mt-1 block w-full bg-slate-800 rounded-xl border border-slate-700 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 px-4 py-3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="px-8 py-6 bg-slate-800/30 flex justify-end space-x-3">
                        <button type="button" onclick="closeModal()" class="px-6 py-2 text-slate-400 font-bold hover:text-white transition">Batal</button>
                        <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition shadow-lg shadow-indigo-500/20">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL DELETE -->
    <div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm"></div>
            <div class="relative glass-dark rounded-3xl p-8 max-w-sm w-full border border-white/10 text-center">
                <div class="w-20 h-20 bg-rose-500/20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold mb-2">Hapus Kategori?</h3>
                <p class="text-slate-400 mb-8">Anda yakin ingin menghapus kategori <span id="deleteItemName" class="text-rose-400 font-bold"></span>? Tindakan ini tidak bisa dibatalkan.</p>
                <div class="flex space-x-3">
                    <button onclick="closeDeleteModal()" class="flex-1 py-3 text-slate-400 font-bold hover:text-white transition">Batal</button>
                    <form id="deleteForm" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full py-3 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-xl transition shadow-lg shadow-rose-500/20">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const modal = document.getElementById('categoryModal');
        const form = document.getElementById('categoryForm');
        const methodInput = document.getElementById('formMethod');
        const title = document.getElementById('modalTitle');

        function openAddModal() {
            title.innerText = 'Tambah Kategori';
            form.action = "{{ route('kategori.store') }}";
            methodInput.value = 'POST';
            document.getElementById('modalName').value = '';
            document.getElementById('modalType').value = 'pemasukan';
            document.getElementById('modalDescription').value = '';
            modal.classList.remove('hidden');
        }

        function openEditModal(id, name, type, description) {
            title.innerText = 'Edit Kategori';
            form.action = `/kategori/${id}`;
            methodInput.value = 'PUT';
            document.getElementById('modalName').value = name;
            document.getElementById('modalType').value = type;
            document.getElementById('modalDescription').value = description;
            modal.classList.remove('hidden');
        }

        function closeModal() {
            modal.classList.add('hidden');
        }

        function confirmDelete(id, name) {
            document.getElementById('deleteItemName').innerText = name;
            document.getElementById('deleteForm').action = `/kategori/${id}`;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
