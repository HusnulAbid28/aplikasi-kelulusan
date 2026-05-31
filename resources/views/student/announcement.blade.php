<!DOCTYPE html>
<html lang="id" class="{{ $frontendTheme }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Kelulusan - {{ $student->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: {
                            dark: '#0f172a',
                            gold: '#fbbf24',
                            glow: '#38bdf8',
                            success: '#22c55e',
                            danger: '#ef4444'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; overflow-x: hidden; }
        .glass {
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        .dark .glass {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        html:not(.dark) .glass {
            background: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.1);
        }
        .status-lulus { box-shadow: 0 0 30px rgba(34, 197, 94, 0.3); }
        .status-ditangguhkan { box-shadow: 0 0 30px rgba(239, 68, 68, 0.3); }
    </style>
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && '{{ $frontendTheme }}' === 'dark')) {
            document.documentElement.classList.add('dark');
        } else if (localStorage.theme === 'light') {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="min-h-screen bg-gray-50 dark:bg-brand-dark py-12 px-4 relative transition-colors duration-300">
    <!-- Theme Toggle -->
    <button onclick="toggleTheme()" class="absolute top-4 right-4 z-50 p-2 rounded-full bg-white/50 dark:bg-black/50 backdrop-blur-md border border-gray-200 dark:border-white/10 shadow-lg text-gray-800 dark:text-white hover:scale-110 transition">
        <svg id="theme-icon-dark" class="w-6 h-6 hidden dark:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
        </svg>
        <svg id="theme-icon-light" class="w-6 h-6 block dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
    </button>
    <script>
        function toggleTheme() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
            }
        }
    </script>

    <div class="max-w-2xl mx-auto z-10 relative">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">SD MUHAMMADIYAH 1 LAMONGAN</h1>
                <p class="text-brand-glow text-sm uppercase tracking-wider">Hasil Kelulusan</p>
                @if(isset($academicYear) && $academicYear)
                    <p class="text-gray-500 dark:text-gray-400 text-xs mt-1">Tahun Ajaran {{ $academicYear }}</p>
                @endif
            </div>
            <form action="{{ route('student.logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition px-4 py-2 border border-gray-300 dark:border-white/10 rounded-lg glass">Logout</button>
            </form>
        </div>

        <!-- Main Card -->
        <div class="glass p-8 md:p-10 rounded-2xl border-t border-l border-white/20 shadow-2xl relative {{ $student->status == 'LULUS' ? 'status-lulus' : 'status-ditangguhkan' }} transition-colors duration-300">
            
            <div class="text-center mb-10">
                <p class="text-gray-500 dark:text-gray-400 mb-1">Status Kelulusan untuk:</p>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-2">{{ $student->name }}</h2>
                <p class="text-brand-glow font-mono bg-gray-200 dark:bg-black/30 inline-block px-3 py-1 rounded-md">{{ $student->nisn }}</p>
            </div>

            <div class="text-center py-8 bg-white/80 dark:bg-black/20 rounded-xl mb-8 border border-gray-200 dark:border-white/5 transition-colors duration-300">
                @if($student->status == 'LULUS')
                    <div class="text-5xl md:text-7xl font-black text-brand-success mb-4 tracking-tight drop-shadow-[0_0_15px_rgba(34,197,94,0.5)]">LULUS</div>
                    <p class="text-gray-700 dark:text-gray-300">Selamat! Anda dinyatakan lulus dari SD Muhammadiyah 1 Lamongan.</p>
                @else
                    <div class="text-5xl md:text-7xl font-black text-brand-danger mb-4 tracking-tight drop-shadow-[0_0_15px_rgba(239,68,68,0.5)]">DITANGGUHKAN</div>
                    <p class="text-gray-700 dark:text-gray-300">Mohon maaf, status kelulusan Anda saat ini ditangguhkan. Silakan hubungi pihak sekolah.</p>
                @endif
            </div>

            @if($message)
            <div class="bg-white/80 dark:bg-black/20 border border-brand-gold/30 p-6 rounded-xl mb-8 relative transition-colors duration-300">
                <div class="absolute -top-3 left-6 bg-gray-100 dark:bg-brand-dark px-2 text-brand-gold text-xs font-bold uppercase tracking-wider transition-colors duration-300">Pesan Kepala Sekolah</div>
                <p class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed italic whitespace-pre-wrap">"{{ $message }}"</p>
            </div>
            @endif

            <div class="flex flex-col sm:flex-row gap-4 justify-center mt-10">
                @if($student->status == 'LULUS')
                <a href="{{ route('announcement.pdf') }}" class="bg-brand-gold text-brand-dark font-bold py-3 px-8 rounded-lg text-center hover:bg-yellow-400 transition shadow-[0_0_15px_rgba(251,191,36,0.3)] hover:shadow-[0_0_25px_rgba(251,191,36,0.6)] flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    Unduh Bukti Kelulusan
                </a>
                @endif
            </div>
        </div>
    </div>

    @if($student->status == 'LULUS')
    <script>
        window.onload = function() {
            var duration = 3 * 1000;
            var animationEnd = Date.now() + duration;
            var defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 0 };

            function randomInRange(min, max) {
                return Math.random() * (max - min) + min;
            }

            var interval = setInterval(function() {
                var timeLeft = animationEnd - Date.now();

                if (timeLeft <= 0) {
                    return clearInterval(interval);
                }

                var particleCount = 50 * (timeLeft / duration);
                confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 } }));
                confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 } }));
            }, 250);
        }
    </script>
    @endif
</body>
</html>
