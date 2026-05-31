<!DOCTYPE html>
<html lang="id" class="{{ $frontendTheme }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengumuman Kelulusan SDMUHLA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: {
                            dark: '#0f172a',
                            gold: '#fbbf24',
                            glow: '#38bdf8'
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
        .glow-button {
            box-shadow: 0 0 15px rgba(251, 191, 36, 0.5);
            transition: all 0.3s ease;
        }
        .glow-button:hover {
            box-shadow: 0 0 25px rgba(251, 191, 36, 0.8);
            transform: translateY(-2px);
        }
    </style>
    <script>
        // Apply theme from localStorage if exists, else it falls back to the server-rendered class
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && '{{ $frontendTheme }}' === 'dark')) {
            document.documentElement.classList.add('dark');
        } else if (localStorage.theme === 'light') {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="min-h-screen flex items-center justify-center relative bg-gray-50 dark:bg-brand-dark text-gray-900 dark:text-white transition-colors duration-300">
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

    <!-- Animated background particles (simplified) -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute w-64 h-64 bg-brand-glow rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob top-10 left-10"></div>
        <div class="absolute w-64 h-64 bg-brand-gold rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000 top-1/2 right-10"></div>
    </div>

    <div class="glass p-8 md:p-12 rounded-2xl w-full max-w-md z-10 mx-4 relative transition-colors duration-300">
        <div class="text-center mb-8">
            @if(isset($schoolLogo) && $schoolLogo)
                <img src="{{ Storage::disk('public')->url($schoolLogo) }}" alt="Logo Sekolah" class="h-24 mx-auto mb-4 object-contain drop-shadow-[0_0_15px_rgba(255,255,255,0.3)]">
            @endif
            <p class="text-brand-glow font-semibold tracking-wider text-sm uppercase">Portal Kelulusan</p>
            @if(isset($academicYear) && $academicYear)
                <p class="text-gray-500 dark:text-gray-400 text-xs mt-1">Tahun Ajaran {{ $academicYear }}</p>
            @endif
        </div>

        @if($errors->any())
            <div class="bg-red-500/20 border border-red-500 text-red-700 dark:text-red-100 px-4 py-3 rounded-lg mb-6 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        @if(!$isTime && $announcementDate)
            <div class="text-center mb-6" id="countdown-container">
                <p class="text-gray-600 dark:text-gray-400 mb-2">Pengumuman akan dibuka pada:</p>
                <div class="text-xl font-bold text-brand-gold bg-black/10 dark:bg-black/30 py-3 rounded-lg border border-gray-300 dark:border-white/10" id="countdown" data-date="{{ $announcementDate }}">
                    Loading...
                </div>
            </div>
        @endif

        <form action="{{ route('student.login.post') }}" method="POST">
            @csrf
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">NISN</label>
                <input type="text" name="nisn" id="input-nisn" class="w-full bg-white dark:bg-black/20 border border-gray-300 dark:border-white/10 rounded-lg px-4 py-3 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-brand-glow transition" placeholder="Masukkan NISN Anda" required {{ (!$isTime && $announcementDate) ? 'disabled' : '' }}>
            </div>
            
            <div class="mb-8">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password</label>
                <input type="password" name="password" id="input-password" class="w-full bg-white dark:bg-black/20 border border-gray-300 dark:border-white/10 rounded-lg px-4 py-3 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-brand-glow transition" placeholder="Masukkan Password" required {{ (!$isTime && $announcementDate) ? 'disabled' : '' }}>
            </div>

            <button type="submit" id="btn-submit" class="w-full bg-brand-gold text-brand-dark font-bold py-3 px-4 rounded-lg glow-button flex justify-center items-center gap-2 {{ (!$isTime && $announcementDate) ? 'opacity-50 cursor-not-allowed' : '' }}" {{ (!$isTime && $announcementDate) ? 'disabled' : '' }}>
                <span>Lihat Pengumuman</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </form>
    </div>

    @if(!$isTime && $announcementDate)
    <script>
        const targetDate = new Date(document.getElementById('countdown').dataset.date).getTime();
        
        const updateCountdown = () => {
            const now = new Date().getTime();
            const distance = targetDate - now;

            if (distance < 0) {
                // Sembunyikan countdown
                const container = document.getElementById('countdown-container');
                if (container) container.style.display = 'none';

                // Aktifkan input dan tombol
                document.getElementById('input-nisn').disabled = false;
                document.getElementById('input-password').disabled = false;
                
                const btnSubmit = document.getElementById('btn-submit');
                btnSubmit.disabled = false;
                btnSubmit.classList.remove('opacity-50', 'cursor-not-allowed');

                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById('countdown').innerHTML = `${days}h ${hours}j ${minutes}m ${seconds}s`;
        };

        setInterval(updateCountdown, 1000);
        updateCountdown();
    </script>
    @endif
</body>
</html>
