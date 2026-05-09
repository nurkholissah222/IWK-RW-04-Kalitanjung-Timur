<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <style>
            :root {
                --bg-body: #020617;
                --text-main: #f8fafc;
                --bg-card: rgba(15, 23, 42, 0.7);
                --border-color: rgba(255, 255, 255, 0.1);
            }

            body.light-mode {
                --bg-body: #f0f9ff;
                --text-main: #082f49;
                --bg-card: #ffffff;
                --border-color: #bae6fd;
            }

            body { 
                background: var(--bg-body) !important;
                color: var(--text-main) !important;
                font-family: 'Outfit', sans-serif; 
                transition: background-color 0.4s ease, color 0.4s ease;
            }

            h1, h2, h3, h4, h5, h6, p, span, div, a, label, input { color: var(--text-main) !important; }
            
            .card-guest {
                background: var(--bg-card) !important;
                border-color: var(--border-color) !important;
                backdrop-filter: blur(20px);
            }
            
            #theme-toggle { transition: all 0.3s ease; }
            body.light-mode #theme-toggle { color: #082f49 !important; background: #ffffff !important; }

            /* Light Mode Heading Fix */
            body.light-mode .guest-heading {
                background-image: linear-gradient(to right, #082f49, #4f46e5) !important;
            }

            /* Custom Input Styles - THEME SYNC */
            .bg-input-guest { background-color: #ffffff !important; color: #000000 !important; }
            .text-input-guest { color: #000000 !important; }

            /* Dark Mode Overrides */
            .dark-mode .bg-input-guest, .dark .bg-input-guest { 
                background-color: rgba(15, 23, 42, 0.7) !important; 
                border-color: rgba(255, 255, 255, 0.1) !important;
                color: #ffffff !important; 
            }
            .dark-mode .text-input-guest, .dark .text-input-guest { 
                color: #ffffff !important; 
            }
            .dark-mode .bg-input-guest:focus, .dark .bg-input-guest:focus {
                border-color: #818cf8 !important;
                box-shadow: 0 0 0 4px rgba(129, 140, 248, 0.1) !important;
            }

            /* Custom Scrollbar */
            ::-webkit-scrollbar { width: 8px; }
            ::-webkit-scrollbar-track { background: #020617; }
            ::-webkit-scrollbar-thumb { background: #1e293b; border-radius: 10px; }
        </style>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    </head>
    <body class="font-sans antialiased selection:bg-indigo-500/30">
        <script>
            (function() {
                const theme = localStorage.getItem('theme') || 'dark';
                if (theme === 'light') {
                    document.body.classList.add('light-mode');
                    document.documentElement.classList.add('light');
                } else {
                    document.body.classList.add('dark-mode');
                    document.documentElement.classList.remove('light');
                }
            })();
        </script>
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative overflow-hidden">
            <!-- Decorative Glows - Luxury Light Navy Theme -->
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[1000px] h-[1000px] bg-blue-500/20 rounded-full blur-[150px] pointer-events-none animate-pulse"></div>
            <div class="absolute -top-24 -left-24 w-[500px] h-[500px] bg-indigo-500/20 rounded-full blur-[120px] pointer-events-none"></div>
            <div class="absolute -bottom-24 -right-24 w-[500px] h-[500px] bg-blue-600/20 rounded-full blur-[120px] pointer-events-none"></div>

            <div class="fixed top-6 right-8 z-[60] no-print">
                <button id="theme-toggle" class="p-3 rounded-2xl bg-slate-900/50 backdrop-blur-xl border border-white/10 text-white hover:scale-110 transition-all duration-300 active:scale-95 shadow-2xl relative overflow-hidden group">
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

            <div class="relative z-10 text-center">
                <a href="/">
                    <h1 class="text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-white via-blue-200 to-indigo-400 tracking-tighter mb-2 guest-heading">SI-IWK RW 04</h1>
                </a>
                
                @if(!$db_connected)
                    <div class="mt-4 px-6 py-3 rounded-full bg-red-500/10 border border-red-500/20 text-red-400 text-xs font-bold uppercase tracking-widest animate-pulse inline-flex items-center space-x-2">
                        <i class="fas fa-database"></i>
                        <span>DATABASE OFFLINE - Periksa XAMPP</span>
                    </div>
                @endif
            </div>

            <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-white/[0.03] backdrop-blur-2xl shadow-[0_20px_50px_rgba(0,0,0,0.5)] overflow-hidden sm:rounded-[2.5rem] border border-white/10 relative z-10 card-guest">
                <!-- Inner Glow for Card -->
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-indigo-500/50 to-transparent"></div>
                
                {{ $slot }}
            </div>
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

            // Initial Icon State
            updateIcons(localStorage.getItem('theme') || 'dark');

            themeToggleBtn.addEventListener('click', function() {
                if (document.body.classList.contains('light-mode')) {
                    document.body.classList.remove('light-mode');
                    localStorage.setItem('theme', 'dark');
                    updateIcons('dark');
                } else {
                    document.body.classList.add('light-mode');
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
