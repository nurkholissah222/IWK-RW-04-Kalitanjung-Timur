<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    @php $dashboardRoute = Auth::user()->role === 'RW' ? 'dashboard.rw' : 'dashboard.rt'; @endphp
                    <a href="{{ route($dashboardRoute) }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route($dashboardRoute)" :active="request()->routeIs('dashboard*')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @if (Route::has('warga.index'))
                    <x-nav-link :href="route('warga.index')" :active="request()->routeIs('warga.*')">
                        {{ __('Data Warga') }}
                    </x-nav-link>
                    @endif

                    @if (Route::has('iuran.create'))
                    <x-nav-link :href="route('iuran.create')" :active="request()->routeIs('iuran.*')">
                        {{ __('Catat Iuran') }}
                    </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }} ({{ Auth::user()->role === 'RW' ? 'RW 04' : 'RT ' . (Auth::user()->unit_rt ?? str_pad(Auth::user()->rtUnit->nomor_rt ?? '0', 2, '0', STR_PAD_LEFT)) }})</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>

{{-- SCRIPT PENGHAPUS NOTIFIKASI OTOMATIS --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Fungsi untuk mencari dan menghapus teks "No longer supported"
        function removeAnnoyingWarning() {
            const allElements = document.querySelectorAll('div, p, span, a');
            allElements.forEach(el => {
                if (el.innerText.includes("This version of Antigravity is no longer supported") || 
                    el.innerText.includes("Please upgrade")) {
                    el.style.display = 'none'; // Sembunyikan
                    el.remove(); // Hapus dari DOM
                }
            });
        }

        // Jalankan saat load
        removeAnnoyingWarning();
        
        // Jalankan lagi setelah 2 detik (berjaga-jaga jika muncul terlambat karena n8n/Vite)
        setTimeout(removeAnnoyingWarning, 2000);
    });
</script>