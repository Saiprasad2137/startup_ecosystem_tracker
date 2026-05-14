<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Startup Ecosystem Tracker</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .gradient-text {
            background: linear-gradient(135deg, #38bdf8, #818cf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .bg-glow {
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(56,189,248,0.15) 0%, rgba(15,23,42,0) 70%);
            top: -200px;
            left: -200px;
            z-index: -1;
            pointer-events: none;
        }
    </style>
</head>
<body class="antialiased bg-slate-900 text-slate-200 min-h-screen relative overflow-x-hidden">
    <div class="bg-glow"></div>
    <div class="bg-glow" style="top: auto; bottom: -200px; left: auto; right: -200px; background: radial-gradient(circle, rgba(129,140,248,0.15) 0%, rgba(15,23,42,0) 70%);"></div>

    <header class="absolute inset-x-0 top-0 z-50">
        <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
            <div class="flex lg:flex-1">
                <a href="#" class="-m-1.5 p-1.5 flex items-center gap-2">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-sky-400 to-indigo-500 flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-sky-500/30">
                        E
                    </div>
                    <span class="font-bold text-xl tracking-tight text-white">EcoTrack</span>
                </a>
            </div>
            
            <div class="flex flex-1 justify-end items-center gap-6">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-semibold leading-6 text-white hover:text-sky-400 transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold leading-6 text-slate-300 hover:text-white transition">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="rounded-full bg-white/10 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-white/20 border border-white/10 transition backdrop-blur-md">Sign up</a>
                        @endif
                    @endauth
                @endif
            </div>
        </nav>
    </header>

    <div class="relative isolate px-6 pt-14 lg:px-8">
        <div class="mx-auto max-w-4xl py-32 sm:py-48 lg:py-56">
            <div class="text-center">
                <div class="mb-8 flex justify-center">
                    <div class="relative rounded-full px-3 py-1 text-sm leading-6 text-slate-400 ring-1 ring-white/10 hover:ring-white/20 transition cursor-pointer glass-card">
                        Announcing our new funding metrics dashboard. <a href="#" class="font-semibold text-sky-400"><span class="absolute inset-0" aria-hidden="true"></span>Read more <span aria-hidden="true">&rarr;</span></a>
                    </div>
                </div>
                <h1 class="text-5xl font-extrabold tracking-tight text-white sm:text-7xl">
                    Track the <span class="gradient-text">Future</span> of the Ecosystem
                </h1>
                <p class="mt-6 text-lg leading-8 text-slate-300 max-w-2xl mx-auto">
                    The ultimate platform to monitor startups, discover active investors, and analyze funding trends in real-time. Join the network powering tomorrow's unicorns.
                </p>
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    <a href="{{ route('register') }}" class="rounded-full bg-gradient-to-r from-sky-500 to-indigo-500 px-8 py-3.5 text-sm font-semibold text-white shadow-lg shadow-indigo-500/30 hover:scale-105 transition-transform duration-300">Get started</a>
                </div>
            </div>
        </div>
    </div>


</body>
</html>
