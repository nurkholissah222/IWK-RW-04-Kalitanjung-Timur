<x-app-layout>
    <div class="py-12 bg-slate-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12">
            
            <!-- FORM A: IURAN RUTIN WARGA -->
            <div class="glass-dark rounded-3xl overflow-hidden shadow-2xl border border-white/5">
                <div class="p-8 border-b border-slate-700/50 relative overflow-hidden bg-indigo-500/5">
                    <div class="relative z-10">
                        <h2 class="text-2xl font-black flex items-center">
                            <div class="p-3 bg-indigo-600 rounded-2xl mr-4 shadow-lg shadow-indigo-500/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            Form A: Catat Iuran Rutin Warga (IWK)
                        </h2>
                        <p class="text-slate-400 mt-2 text-base font-medium italic">Khusus untuk pembayaran IWK, Andon, dan Sumbangan rutin per bulan.</p>
                    </div>
                </div>

                <div class="p-8">
                    <form method="POST" action="{{ route('iuran.store') }}" class="space-y-8">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <x-input-label for="kategori_id_a" value="Kategori Iuran" class="text-slate-400 text-lg font-semibold mb-3" />
                                <select id="kategori_id_a" name="kategori_id" class="w-full bg-slate-800 rounded-2xl border border-slate-700 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 py-4 px-5 text-base transition-all" required>
                                    <option value="" disabled selected>-- Pilih Kategori --</option>
                                    @foreach($categoriesA as $cat)
                                        @php
                                            $rate = 0;
                                            if (stripos($cat->name, 'IWK') !== false) $rate = 3000;
                                            elseif (stripos($cat->name, 'Andon') !== false) $rate = 5000;
                                        @endphp
                                        <option value="{{ $cat->id }}" data-rate="{{ $rate }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <x-input-label for="warga_id_a" value="Pilih Warga" class="text-slate-400 text-lg font-semibold mb-3" />
                                <select id="warga_id_a" name="warga_id" class="w-full select2-dark" required>
                                    <option value="" disabled selected>-- Cari Warga --</option>
                                    @foreach($wargas as $w)
                                        <option value="{{ $w->id }}">
                                            {{ $w->nama_warga }} | {{ $w->nik }} | RT {{ $w->rtUnit->nomor_rt ?? '-' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between items-center mb-5">
                                <x-input-label value="Pilih Bulan Pembayaran" class="text-slate-400 text-lg font-semibold" />
                                <span id="status-loading" class="text-xs font-bold text-indigo-400 animate-pulse hidden uppercase tracking-widest">Mengecek Status...</span>
                            </div>
                            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-4" id="month-container-a">
                                @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $month)
                                    <label class="relative cursor-pointer group" id="label-{{ $month }}">
                                        <input type="checkbox" name="bulan[]" value="{{ $month }}" id="input-{{ $month }}" class="peer sr-only btn-bulan-a">
                                        <div class="month-box bg-white border border-slate-200 py-4 text-center rounded-2xl text-slate-900 font-black shadow-sm peer-checked:bg-sky-100 peer-checked:border-sky-400 peer-checked:text-slate-950 peer-checked:shadow-inner transition-all duration-300 group-hover:bg-slate-50 group-hover:scale-[1.02] transform active:scale-95">
                                            <span class="text-xs sm:text-sm uppercase tracking-wider block">{{ $month }}</span>
                                            <span class="status-label text-[9px] uppercase tracking-tighter hidden mt-1">Lunas</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-end">
                            <div>
                                <x-input-label for="tanggal_a" value="Tanggal Pembayaran" class="text-slate-400 text-lg font-semibold mb-3" />
                                <input id="tanggal_a" name="tanggal" type="date" value="{{ date('Y-m-d') }}" class="w-full bg-slate-800 rounded-2xl border border-slate-700 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 py-4 px-5 text-base transition-all" required />
                            </div>

                            <div class="bg-indigo-500/10 p-6 rounded-2xl border border-indigo-500/20 shadow-inner">
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-400 font-bold uppercase text-xs tracking-widest">Total Bayar</span>
                                    <span class="text-2xl font-black text-indigo-400" id="displayTotalA">Rp 0</span>
                                </div>
                                <input type="hidden" name="jumlah" id="inputTotalA" value="0">
                            </div>
                        </div>

                        <div>
                            <x-input-label for="uraian_a" value="Keterangan Tambahan (Opsional)" class="text-slate-400 text-lg font-semibold mb-3" />
                            <textarea id="uraian_a" name="uraian" rows="2" class="w-full bg-slate-800 rounded-2xl border border-slate-700 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 py-4 px-5 text-base transition-all" placeholder="Contoh: Titipan Bapak X atau Catatan lainnya"></textarea>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full py-5 bg-indigo-600 hover:bg-indigo-700 text-white font-black uppercase tracking-widest rounded-2xl shadow-xl shadow-indigo-500/30 transition-all transform hover:-translate-y-1">
                                Simpan Iuran Rutin
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- FORM B: KAS & PENGELUARAN UMUM -->
            <div class="glass-dark rounded-3xl overflow-hidden shadow-2xl border border-white/5">
                <div class="p-8 border-b border-slate-700/50 relative overflow-hidden bg-indigo-500/5">
                    <div class="relative z-10">
                        <h2 class="text-2xl font-black flex items-center">
                            <div class="p-3 bg-indigo-600 rounded-2xl mr-4 shadow-lg shadow-indigo-500/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                            Form B: Catat Kas & Pengeluaran Umum (Operasional)
                        </h2>
                        <p class="text-slate-400 mt-2 text-base font-medium italic">Digunakan untuk mencatat biaya infrastruktur, sosial, kebersihan, dll.</p>
                    </div>
                </div>

                <div class="p-8">
                    <form method="POST" action="{{ route('iuran.store-operasional') }}" class="space-y-8">
                        @csrf
                        <div class="grid grid-cols-1 {{ Auth::user()->isAdmin() && is_null(Auth::user()->rt_id) ? 'md:grid-cols-3' : 'md:grid-cols-2' }} gap-8">
                            <div>
                                <x-input-label for="jenis_transaksi_b" value="Jenis Transaksi" class="text-slate-400 text-lg font-semibold mb-3" />
                                <select id="jenis_transaksi_b" name="jenis_transaksi" class="w-full bg-slate-800 rounded-2xl border border-slate-700 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 py-4 px-5 text-base transition-all" required>
                                    <option value="Keluar">Pengeluaran (Kredit)</option>
                                    <option value="Masuk">Pemasukan (Debit)</option>
                                </select>
                            </div>

                            @if(Auth::user()->isAdmin() && is_null(Auth::user()->rt_id))
                            <div>
                                <x-input-label for="rt_id_b" value="Pilih RT" class="text-slate-400 text-lg font-semibold mb-3" />
                                <select id="rt_id_b" name="rt_id" class="w-full bg-slate-800 rounded-2xl border border-slate-700 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 py-4 px-5 text-base transition-all" required>
                                    <option value="" disabled selected>-- Pilih RT --</option>
                                    @foreach($rt_units as $rt)
                                        <option value="{{ $rt->id }}">RT {{ $rt->nomor_rt }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif

                            <div>
                                <x-input-label for="kategori_id_b" value="Kategori Operasional" class="text-slate-400 text-lg font-semibold mb-3" />
                                <select id="kategori_id_b" name="kategori_id" class="w-full bg-slate-800 rounded-2xl border border-slate-700 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 py-4 px-5 text-base transition-all" required>
                                    <option value="" disabled selected>-- Pilih Kategori --</option>
                                    @foreach($categoriesB as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <x-input-label for="tanggal_b" value="Tanggal Transaksi" class="text-slate-400 text-lg font-semibold mb-3" />
                                <input id="tanggal_b" name="tanggal" type="date" value="{{ date('Y-m-d') }}" class="w-full bg-slate-800 rounded-2xl border border-slate-700 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 py-4 px-5 text-base transition-all" required />
                            </div>

                            <div>
                                <x-input-label for="jumlah_b" value="Nominal (Rp)" class="text-slate-400 text-lg font-semibold mb-3" />
                                <input id="jumlah_b" name="jumlah" type="number" placeholder="Contoh: 100000" class="w-full bg-slate-800 rounded-2xl border border-slate-700 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 py-4 px-5 font-mono text-base transition-all" required />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="uraian_b" value="Keterangan / Uraian" class="text-slate-400 text-lg font-semibold mb-3" />
                            <textarea id="uraian_b" name="uraian" rows="3" class="w-full bg-slate-800 rounded-2xl border border-slate-700 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 py-4 px-5 text-base transition-all" placeholder="Misal: Perbaikan aspal jalan RT 03" required></textarea>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full py-5 bg-indigo-600 hover:bg-indigo-700 text-white font-black uppercase tracking-widest rounded-2xl shadow-xl shadow-indigo-500/30 transition-all transform hover:-translate-y-1">
                                Simpan Transaksi Umum
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Include jQuery and Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi Select2 untuk Form A
            $('#warga_id_a').select2({
                placeholder: "-- Pilih atau Cari Nama Warga --",
                width: '100%',
                allowClear: true
            });

            // Listener Form A
            $('#kategori_id_a').on('change', calculateTotalA);
            $(document).on('click change', '.btn-bulan-a', calculateTotalA);

            // AJAX Status Pengecekan Iuran
            $('#warga_id_a').on('change', function() {
                const wargaId = $(this).val();
                if (!wargaId) return resetMonthButtons();

                $('#status-loading').removeClass('hidden');
                
                $.ajax({
                    url: `/iuran/check-status/${wargaId}`,
                    method: 'GET',
                    success: function(response) {
                        $('#status-loading').addClass('hidden');
                        updateMonthStatus(response);
                    },
                    error: function() {
                        $('#status-loading').addClass('hidden');
                    }
                });
            });

            function resetMonthButtons() {
                $('.btn-bulan-a').prop('disabled', false).prop('checked', false);
                $('.month-box').removeClass('opacity-50 bg-emerald-50 border-emerald-300 border-rose-500 ring-2 ring-rose-500/20');
                $('.status-label').addClass('hidden').removeClass('text-emerald-600 text-rose-600 font-black');
                calculateTotalA();
            }

            function updateMonthStatus(data) {
                resetMonthButtons();
                const paidMonths = data.paid_months;
                const currentMonthIdx = data.current_month_index; // 1-12
                const allMonths = data.all_months;

                allMonths.forEach((month, index) => {
                    const input = $(`#input-${month}`);
                    const label = $(`#label-${month}`);
                    const box = label.find('.month-box');
                    const statusText = label.find('.status-label');

                    // 1. Cek Lunas
                    if (paidMonths.includes(month)) {
                        input.prop('disabled', true);
                        box.addClass('opacity-50 bg-emerald-50 border-emerald-300');
                        statusText.removeClass('hidden').text('Sudah Bayar').addClass('text-emerald-600');
                    } 
                    // 2. Cek Tunggakan (Bulan sudah lewat dan belum bayar)
                    else if ((index + 1) < currentMonthIdx) {
                        box.addClass('border-rose-500 ring-2 ring-rose-500/20');
                        statusText.removeClass('hidden').text('Tunggakan').addClass('text-rose-600 font-black');
                    }
                });
            }
        });

        function calculateTotalA() {
            var selectedKategori = $('#kategori_id_a').find(':selected');
            var valKategori = selectedKategori.val();
            
            if (!valKategori) {
                $('#displayTotalA').text('Rp 0');
                $('#inputTotalA').val(0);
                return;
            }

            var rate = parseInt(selectedKategori.data('rate')) || 0;
            var checkedMonthsCount = $('.btn-bulan-a:checked').length;
            var total = checkedMonthsCount * rate;

            var formatter = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            });

            $('#displayTotalA').text(formatter.format(total).replace('Rp', 'Rp '));
            $('#inputTotalA').val(total);
        }
    </script>

    <style>
        body { font-family: 'Outfit', sans-serif; }
        .glow-indigo { box-shadow: 0 0 20px rgba(79, 70, 229, 0.4); }

        /* Select2 Total Synchronization with Standard Selects */
        .select2-container .select2-selection--single {
            background-color: var(--bg-input) !important;
            border: 1px solid var(--border-input) !important;
            border-radius: 1rem !important; /* rounded-2xl */
            height: 58px !important; /* Matches py-4 exactly */
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }
        
        html.dark .select2-container .select2-selection--single,
        .dark .select2-container .select2-selection--single {
            background-color: #1e293b !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: var(--text-main) !important;
            padding-left: 1.25rem !important; /* px-5 */
            padding-right: 2.5rem !important;
            line-height: normal !important;
            font-weight: 500 !important;
            font-size: 16px !important; /* Larger font for elderly users */
            font-family: 'Outfit', sans-serif !important;
        }

        html.dark .select2-container--default .select2-selection--single .select2-selection__rendered,
        .dark .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #ffffff !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: var(--text-main) !important;
            opacity: 0.7;
        }
        
        /* Focus State Synchronization */
        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #4f46e5 !important; /* focus:border-indigo-500 */
            box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.2) !important; /* focus:ring-2 focus:ring-indigo-500/20 */
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100% !important;
            right: 1.25rem !important; /* px-5 */
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: var(--text-muted) transparent transparent transparent !important;
            border-width: 5px 4px 0 4px !important;
        }
        .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
            border-color: transparent transparent var(--text-muted) transparent !important;
            border-width: 0 4px 5px 4px !important;
        }
        
        /* Select2 Dropdown Integration */
        .select2-dropdown {
            background-color: var(--bg-card) !important;
            border-radius: 1rem !important;
            border: 1px solid var(--border-input) !important;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.5) !important;
            color: var(--text-main) !important;
            overflow: hidden;
            z-index: 9999;
            margin-top: 5px;
        }

        html.dark .select2-dropdown, .dark .select2-dropdown {
            background-color: #0f172a !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
        }
        .select2-search__field {
            background-color: var(--bg-input) !important;
            color: var(--text-main) !important;
            border: 1px solid var(--border-input) !important;
            border-radius: 0.75rem !important;
            padding: 12px 15px !important;
            margin: 8px !important;
            width: calc(100% - 16px) !important;
        }
        .select2-results__option {
            color: var(--text-muted) !important;
            padding: 12px 20px !important;
            transition: all 0.2s;
            font-size: 16px !important;
        }

        html.dark .select2-results__option, .dark .select2-results__option {
            color: #cbd5e1 !important;
        }
        .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
            background-color: #4f46e5 !important;
            color: #ffffff !important;
        }
        
        /* Date Picker Icon Optimization */
        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(0.5) sepia(1) saturate(5) hue-rotate(175deg);
            cursor: pointer;
        }
        body.light-mode input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(0.2) sepia(1) saturate(5) hue-rotate(175deg);
        }
    </style>
</x-app-layout>
