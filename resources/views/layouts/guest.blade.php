<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Kodakarsa Payroll') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-slate-900 antialiased bg-white dark:bg-slate-900 selection:bg-indigo-500 selection:text-white">
    <div class="min-h-screen flex bg-white dark:bg-slate-900">
        <!-- Left: Form Area -->
        <div class="w-full lg:w-1/2 flex flex-col justify-center p-8 relative">
            <!-- Branding / Back to Home -->
            <div class="absolute top-8 left-8">
                <a href="/" wire:navigate class="flex items-center gap-2.5 text-slate-900 dark:text-slate-100 transition-opacity hover:opacity-80">
                    <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center shadow-md shadow-indigo-600/20">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="font-bold tracking-wide text-sm">KODAKARSA</span>
                </a>
            </div>

            <!-- Injected Slot (Login/Register Form) -->
            <div class="w-full max-w-[360px] mx-auto mt-16 lg:mt-0">
                {{ $slot }}
            </div>
        </div>
        
        <!-- Right: Premium Visual Area (Hidden on mobile) -->
        <div class="hidden lg:flex w-1/2 bg-slate-50 dark:bg-slate-800/50 relative overflow-hidden border-l border-slate-200 dark:border-slate-700/50 items-center justify-center">
            <!-- Subtle Radial Gradient Background -->
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-indigo-100/40 via-slate-50 to-white dark:from-indigo-900/20 dark:via-slate-800/50 dark:to-slate-900"></div>
            
            <!-- Floating Decorative Card -->
            <div class="relative z-10 text-center p-12 w-full max-w-md mx-auto">
                <div class="bg-white/70 dark:bg-slate-800/60 backdrop-blur-xl p-8 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white/50 dark:border-slate-700 text-left transition-transform duration-500 hover:scale-[1.02]">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-full bg-indigo-50 dark:bg-indigo-500/10 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold text-sm border border-indigo-100 dark:border-indigo-500/20">
                            SA
                        </div>
                        <div>
                            <h4 class="font-semibold text-slate-900 dark:text-slate-100 text-sm">Super Admin</h4>
                            <p class="text-xs text-slate-500">Kodakarsa Payroll</p>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-3 tracking-tight">Streamline your payroll process.</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed mb-6">Experience the fastest, most accurate way to manage employees and process payroll. Secure, reliable, and beautifully designed.</p>
                    
                    <!-- Micro-Interaction Element (Status Bar) -->
                    <div class="bg-white dark:bg-slate-900 rounded-lg p-4 border border-slate-100 dark:border-slate-700/50 shadow-sm">
                        <div class="flex justify-between items-center mb-2.5">
                            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">System Status</span>
                            <span class="flex items-center gap-1.5 text-xs font-bold text-emerald-600 dark:text-emerald-400">
                                <span class="relative flex h-2 w-2">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                </span>
                                Online
                            </span>
                        </div>
                        <div class="h-1.5 w-full bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                            <div class="h-full bg-emerald-500 w-full rounded-full"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
