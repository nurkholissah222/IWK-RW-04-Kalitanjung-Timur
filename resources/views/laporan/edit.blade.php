<x-app-layout>
    <div class="py-12 bg-slate-950 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-dark overflow-hidden shadow-2xl rounded-[2.5rem] border border-white/10">
                <div class="p-10">
                    <div class="flex items-center mb-10">
                        <a href="{{ route('laporan.index') }}" class="mr-6 p-3 bg-white border border-slate-200 hover:border-indigo-600 hover:text-indigo-600 rounded-2xl text-slate-500 shadow-sm transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </a>
                        <div>
                            <h2 class="text-3xl font-black text-white uppercase tracking-tight">Edit Transaksi</h2>
                            <p class="text-slate-400 font-medium text-sm mt-1">Perbarui rincian data pemasukan atau pengeluaran kas.</p>
                        </div>
                    </div>

                    <form action="{{ route('laporan.update', $transaksi->id) }}" method="POST" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Tanggal -->
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Tanggal Transaksi</label>
                                <input type="date" name="tanggal" value="{{ $transaksi->tanggal->format('Y-m-d') }}" required
                                    class="w-full rounded-2xl px-5 py-4 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 transition-all outline-none">
                            </div>

                            <!-- Jenis Transaksi -->
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Jenis Kas</label>
                                <select name="jenis_transaksi" required
                                    class="w-full rounded-2xl px-5 py-4 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 transition-all outline-none">
                                    <option value="Masuk" {{ $transaksi->jenis_transaksi == 'Masuk' ? 'selected' : '' }}>Pemasukan (Debit)</option>
                                    <option value="Keluar" {{ $transaksi->jenis_transaksi == 'Keluar' ? 'selected' : '' }}>Pengeluaran (Kredit)</option>
                                </select>
                            </div>
                        </div>

                        <!-- Uraian -->
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Uraian / Keterangan</label>
                            <textarea name="uraian" rows="3" required placeholder="Masukkan keterangan transaksi secara detail..."
                                class="w-full rounded-2xl px-5 py-4 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 transition-all outline-none">{{ $transaksi->uraian }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Jumlah -->
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Nominal (Rp)</label>
                                <div class="relative">
                                    <span class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 font-bold">Rp</span>
                                    <input type="number" name="jumlah" value="{{ (int)$transaksi->jumlah }}" required
                                        class="w-full rounded-2xl pl-12 pr-5 py-4 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 transition-all outline-none">
                                </div>
                            </div>

                            <!-- Kategori -->
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Kategori Laporan</label>
                                <select name="kategori_id"
                                    class="w-full rounded-2xl px-5 py-4 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 transition-all outline-none">
                                    <option value="">Tanpa Kategori</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ $transaksi->kategori_id == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }} ({{ ucfirst($cat->type) }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Warga (Opsional) -->
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Kaitan Warga (Opsional)</label>
                            <select name="warga_id"
                                class="w-full rounded-2xl px-5 py-4 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 transition-all outline-none">
                                <option value="">Tidak Berkaitan dengan Warga</option>
                                @foreach($wargas as $w)
                                    <option value="{{ $w->id }}" {{ $transaksi->warga_id == $w->id ? 'selected' : '' }}>
                                        {{ $w->nama_warga }} - RT {{ $w->rtUnit->nomor_rt ?? '-' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="pt-10 border-t border-slate-100">
                            <button type="submit" class="w-full py-5 bg-indigo-600 hover:bg-indigo-500 text-white font-black uppercase tracking-widest rounded-2xl transition-all duration-300 shadow-xl shadow-indigo-500/20 transform hover:-translate-y-1 active:scale-[0.98]">
                                Simpan Perubahan Laporan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
