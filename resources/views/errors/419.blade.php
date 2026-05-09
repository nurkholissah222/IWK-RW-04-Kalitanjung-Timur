<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sesi Berakhir - SI-IWK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #020617; color: white; }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-6">
    <div class="text-center space-y-6">
        <div class="inline-block p-4 bg-indigo-500/10 rounded-full mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <h1 class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-white to-indigo-400">Sesi Berakhir</h1>
        <p class="text-slate-400 max-w-sm mx-auto">Halaman telah kedaluwarsa demi keamanan. Kami akan mengarahkan Anda kembali ke halaman login dalam sekejap.</p>
        <div class="pt-4">
            <div class="inline-block h-8 w-8 animate-spin rounded-full border-4 border-solid border-indigo-400 border-r-transparent align-[-0.125em] motion-reduce:animate-[spin_1.5s_linear_infinite]" role="status">
                <span class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">Loading...</span>
            </div>
        </div>
    </div>

    <script>
        // Otomatis refresh ke halaman login setelah 3 detik
        setTimeout(function() {
            window.location.href = "{{ route('login') }}";
        }, 3000);
    </script>
</body>
</html>
