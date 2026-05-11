<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'IWK RW 04') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <script src="https://cdn.tailwindcss.com"></script>
            <script>
                tailwind.config = {
                    darkMode: 'class',
                    theme: {
                        extend: {
                            fontFamily: {
                                sans: ['Outfit', 'sans-serif'],
                            }
                        }
                    }
                }
            </script>
        @endif
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <style>
            :root {
                --bg-body: #020617;
                --text-main: #f8fafc;
                --text-muted: #94a3b8;
                --bg-sidebar: #020617;
                --bg-card: #0f172a;
                --bg-input: #0f172a;
                --text-input: #f8fafc;
                --text-label: #94a3b8;
                --border-color: rgba(255, 255, 255, 0.05);
                --border-input: rgba(255, 255, 255, 0.1);
                --shadow-card: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
                --glass-bg: rgba(15, 23, 42, 0.8);
                --hover-bg: rgba(255, 255, 255, 0.05);
            }

            body.light-mode {
                --bg-body: #f0f9ff;
                --text-main: #082f49;
                --text-muted: #0369a1;
                --bg-sidebar: #e0f2fe;
                --bg-card: #ffffff;
                --bg-input: #ffffff;
                --text-input: #082f49;
                --text-label: #082f49;
                --border-color: #bae6fd;
                --border-input: #7dd3fc;
                --shadow-card: 0 10px 30px -10px rgba(7, 89, 133, 0.1);
                --glass-bg: rgba(255, 255, 255, 0.9);
                --hover-bg: #e0f2fe;
            }

            body { 
                font-family: 'Outfit', sans-serif; 
                font-size: 1.125rem; /* Increased to 18px equivalent */
                background-color: var(--bg-body) !important;
                color: var(--text-main) !important;
                transition: background-color 0.4s ease, color 0.4s ease;
                line-height: 1.6;
            }

            .bg-slate-950.min-h-screen { background-color: var(--bg-body) !important; }

            aside, aside.bg-slate-950 {
                background-color: var(--bg-sidebar) !important;
                border-right: 1px solid var(--border-input) !important;
                transition: all 0.4s ease;
            }

            .glass, .glass-dark, .bg-slate-900, .bg-slate-800, .bg-white\/5 {
                background-color: var(--bg-card) !important;
                border: 1px solid var(--border-input) !important;
                box-shadow: var(--shadow-card) !important;
            }

            body.light-mode .glass-dark.relative.overflow-hidden {
                background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%) !important;
            }

            h1, h2, h3, h4, h5, h6, p, span, td, th, .text-slate-200, .text-slate-100 { color: var(--text-main) !important; }
            .text-white { color: #ffffff !important; }
            body.light-mode .text-white { color: var(--text-main) !important; }
            body.light-mode .bg-indigo-600, 
            body.light-mode .bg-indigo-600 * { 
                color: #ffffff !important; 
            }
            
            label, .text-slate-400, .text-slate-500, .text-slate-300 { color: var(--text-label) !important; }

            table thead tr, table tr.bg-slate-800\/50 { background-color: var(--hover-bg) !important; }
            table tbody tr:hover { background-color: var(--hover-bg) !important; }
            .divide-slate-700\/30, .border-slate-700\/50, .border-slate-600 { border-color: var(--border-input) !important; }

            /* Table Font Optimization */
            table td { font-size: 1.125rem !important; font-weight: 500; }
            table th { font-size: 0.95rem !important; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; }
            
            /* Heading Scale */
            h1 { font-size: 2.25rem !important; font-weight: 900; line-height: 1.2; }
            h2 { font-size: 1.875rem !important; font-weight: 800; line-height: 1.3; }
            
            /* Sidebar Menu Font */
            aside span { font-size: 1.05rem !important; font-weight: 700 !important; }
            aside p { font-size: 0.85rem !important; }
            
            /* Navbar Font */
            .navbar-user-name { font-size: 0.9rem !important; font-weight: 900 !important; }
            .navbar-user-role { font-size: 0.75rem !important; font-weight: 800 !important; }

            input, select, textarea {
                background-color: var(--bg-input) !important;
                color: var(--text-input) !important;
                border: 1px solid var(--border-input) !important;
            }

            input::placeholder, textarea::placeholder {
                color: var(--text-muted) !important;
                opacity: 0.7;
            }

            select option { 
                background-color: var(--bg-card) !important; 
                color: var(--text-input) !important; 
            }

            .bg-indigo-600 {
                background-color: #4f46e5 !important;
                color: #ffffff !important;
                box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.4) !important;
            }

            body.light-mode .text-indigo-400, body.light-mode .text-indigo-300 { color: #4f46e5 !important; font-weight: 700; }

            /* Sidebar Sync & Leftover Black Spots Removal */
            .bg-slate-700, .bg-slate-800, .bg-slate-900, .bg-black, .bg-[#020617] {
                background-color: var(--bg-card) !important;
                border-color: var(--border-input) !important;
            }

            body.light-mode aside a:not(.bg-indigo-600) {
                color: var(--text-main) !important;
            }
            body.light-mode aside a:not(.bg-indigo-600):hover {
                background-color: var(--hover-bg) !important;
                color: var(--text-main) !important;
            }
            body.light-mode aside a svg { color: inherit !important; }

            #theme-toggle { transition: all 0.3s ease; }
            body.light-mode #theme-toggle { background-color: #ffffff !important; color: #082f49 !important; border: 1px solid #e2e8f0 !important; }
            body.light-mode #theme-toggle span i { color: #082f49 !important; }

            .nowrap-nominal { 
                white-space: nowrap !important; 
                display: inline-block !important; 
                font-size: 1.05rem !important;
            }
            
            table td, table th {
                vertical-align: middle !important;
            }
            * { transition: background-color 0.2s ease, border-color 0.2s ease; }

            /* --- CRITICAL DARK MODE OVERRIDES --- */
            html.dark, .dark {
                background-color: #0b132b !important;
                color-scheme: dark !important; /* Force native dark UI for datepickers/selects */
            }
            html.dark body, .dark body {
                background-color: #0b132b !important;
                color: #ffffff !important;
            }

            /* 1. Form Inputs & Cards Background (Hitam Pekat) */
            html.dark input:not([type="checkbox"]):not([type="radio"]), 
            html.dark select, 
            html.dark textarea,
            .dark input:not([type="checkbox"]):not([type="radio"]), 
            .dark select, 
            .dark textarea {
                background-color: #0b132b !important;
                color: #ffffff !important;
                border-color: rgba(255, 255, 255, 0.1) !important;
            }

            /* 2. Month Selection Cards (Dark Mode Fix) */
            html.dark .peer + div, .dark .peer + div {
                background-color: #1e293b !important;
                color: #ffffff !important;
                border-color: rgba(255, 255, 255, 0.1) !important;
            }
            html.dark .peer:checked + div, .dark .peer:checked + div {
                background-color: #4f46e5 !important;
                color: #ffffff !important;
                border-color: #6366f1 !important;
                box-shadow: inset 0 2px 4px rgba(0,0,0,0.3) !important;
            }

            /* 3. Warga Dropdown (Select2) Font Size & Dark Style */
            .select2-container--default .select2-selection--single .select2-selection__rendered,
            .select2-results__option,
            #warga_id, #warga_id_a, select[name="warga_id"] {
                font-size: 16px !important; /* Larger font for elderly users */
            }

            html.dark .select2-dropdown, .dark .select2-dropdown {
                background-color: #0b132b !important;
                color: #ffffff !important;
            }

            html.dark .select2-results__option, .dark .select2-results__option {
                color: #cbd5e1 !important;
                background-color: transparent !important;
            }

            html.dark .select2-results__option--highlighted, .dark .select2-results__option--highlighted {
                background-color: #4f46e5 !important;
                color: #ffffff !important;
            }

            /* 4. Profile, Management Cards & Specific Overrides */
            html.dark .glass-dark, .dark .glass-dark,
            html.dark .bg-white, .dark .bg-white,
            html.dark .bg-slate-50, .dark .bg-slate-50,
            html.dark .bg-slate-50\/50, .dark .bg-slate-50\/50,
            html.dark .bg-slate-100, .dark .bg-slate-100,
            html.dark .bg-slate-200, .dark .bg-slate-200,
            html.dark .bg-slate-800, .dark .bg-slate-800,
            html.dark .bg-slate-900, .dark .bg-slate-900,
            html.dark .border-slate-100, .dark .border-slate-100,
            html.dark .border-white, .dark .border-white {
                background-color: #0b132b !important;
                border-color: rgba(255, 255, 255, 0.1) !important;
            }

            /* Global Text Overrides for Dark Mode */
            html.dark h1, .dark h1,
            html.dark h2, .dark h2,
            html.dark h3, .dark h3,
            html.dark label, .dark label,
            html.dark .text-slate-900, .dark .text-slate-900,
            html.dark .text-slate-800, .dark .text-slate-800,
            html.dark .text-slate-700, .dark .text-slate-700 {
                color: #ffffff !important;
            }

            html.dark .text-slate-600, .dark .text-slate-600,
            html.dark .text-slate-500, .dark .text-slate-500,
            html.dark .text-slate-400, .dark .text-slate-400 {
                color: #94a3b8 !important;
            }

            /* 5. Calendar Pop-up (Datepicker) Text Color Fix */
            html.dark input[type="date"], .dark input[type="date"] {
                color: #ffffff !important;
            }

            /* 6. Success Alert & Button Contrast (Dark Mode) */
            html.dark .bg-emerald-50 span, 
            html.dark .text-emerald-700 {
                color: #064E3B !important; /* Hijau Sangat Tua */
            }

            html.dark .bg-indigo-600, 
            html.dark .bg-indigo-600 * { 
                color: #ffffff !important; /* Putih Bersih */
            }
        </style>
    </head>
    <body class="font-sans antialiased selection:bg-indigo-500/30">
        <script>
            (function() {
                const theme = localStorage.getItem('theme') || 'dark';
                if (theme === 'light') {
                    document.body.classList.add('light-mode');
                    document.documentElement.classList.add('light');
                    document.documentElement.classList.remove('dark');
                } else {
                    document.documentElement.classList.add('dark');
                }
            })();
        </script>
        <div class="min-h-screen flex">
            @auth
                @include('layouts.sidebar', ['user' => Auth::user()])
            @endauth

            <div class="flex-1 {{ Auth::check() ? 'lg:ml-72' : '' }} transition-all duration-300">
                <div class="fixed top-6 right-8 z-[60] flex items-center space-x-4 no-print">
                    @auth
                    <div class="flex items-center space-x-3">
                        <div class="flex flex-col items-end">
                            <span class="navbar-user-name uppercase tracking-widest text-slate-100">{{ Auth::user()->name }}</span>
                            <span class="navbar-user-role text-indigo-400">
                                @if(Auth::user()->role == 'RW')
                                    Bendahara RW 04
                                @else
                                    Bendahara RT.{{ Auth::user()->unit_rt ?? '00' }}
                                @endif
                            </span>
                        </div>
                        <div class="flex-shrink-0">
                            @php
                                $finalSrc = Auth::user()->profile_photo_path 
                                    ? asset('storage/' . Auth::user()->profile_photo_path) . '?v=' . time()
                                    : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=4f46e5&color=fff&bold=true';
                            @endphp
                            <img src="{{ $finalSrc }}" 
                                 class="w-10 h-10 rounded-full object-cover border-2 border-white/20 shadow-lg group-hover:border-indigo-500 transition-all duration-300">
                        </div>
                    </div>
                    @endauth
                    
                    <button id="theme-toggle" class="p-3 rounded-2xl bg-slate-900/50 backdrop-blur-xl border border-white/10 text-white hover:scale-110 transition-all duration-300 active:scale-95 shadow-2xl group overflow-hidden relative" title="Toggle Theme">
                        <div class="relative z-10 flex items-center justify-center w-6 h-6">
                            <span id="theme-toggle-dark-icon" class="absolute transition-all duration-500 transform translate-y-10 opacity-0">
                                <i class="fas fa-moon text-lg"></i>
                            </span>
                            <span id="theme-toggle-light-icon" class="absolute transition-all duration-500 transform translate-y-10 opacity-0">
                                <i class="fas fa-sun text-lg"></i>
                            </span>
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-tr from-indigo-500/10 to-purple-500/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </button>
                </div>

                <main>
                    @if(!$db_connected)
                        <div class="m-6 p-4 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-400 flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-xl bg-red-500/20 flex items-center justify-center animate-pulse">
                                    <i class="fas fa-database"></i>
                                </div>
                                <div>
                                    <p class="font-black uppercase tracking-widest text-xs">Database Connection Error</p>
                                    <p class="text-sm opacity-80">Sistem gagal terhubung ke MySQL. Pastikan MySQL di XAMPP sudah aktif.</p>
                                </div>
                            </div>
                            <div class="px-4 py-2 rounded-lg bg-red-500/20 text-[10px] font-bold uppercase">OFFLINE</div>
                        </div>
                    @endif
                    {{ $slot }}
                </main>
        </div>
        <script>
            const themeToggleBtn = document.getElementById('theme-toggle');
            const darkIcon = document.getElementById('theme-toggle-dark-icon');
            const lightIcon = document.getElementById('theme-toggle-light-icon');

            function updateIcons(theme) {
                if (theme === 'light') {
                    lightIcon.classList.remove('translate-y-10', 'opacity-0');
                    lightIcon.classList.add('translate-y-0', 'opacity-100');
                    darkIcon.classList.add('translate-y-10', 'opacity-0');
                    darkIcon.classList.remove('translate-y-0', 'opacity-100');
                } else {
                    darkIcon.classList.remove('translate-y-10', 'opacity-0');
                    darkIcon.classList.add('translate-y-0', 'opacity-100');
                    lightIcon.classList.add('translate-y-10', 'opacity-0');
                    lightIcon.classList.remove('translate-y-0', 'opacity-100');
                }
            }

            updateIcons(localStorage.getItem('theme') || 'dark');

            themeToggleBtn.addEventListener('click', function() {
                if (document.body.classList.contains('light-mode')) {
                    document.body.classList.remove('light-mode');
                    document.documentElement.classList.remove('light');
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                    updateIcons('dark');
                } else {
                    document.body.classList.add('light-mode');
                    document.documentElement.classList.add('light');
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                    updateIcons('light');
                }
            });

            function togglePassword(btn) {
                const container = btn.closest('.relative');
                const input = container.querySelector('input');
                const icon = btn.querySelector('i');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.replace('fa-eye', 'fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.replace('fa-eye-slash', 'fa-eye');
                }
            }
        </script>
</body>
</html>