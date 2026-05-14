<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true', sidebarOpen: false }" x-bind:class="{ 'dark': darkMode }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Kodakarsa Payroll') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="flex h-screen bg-slate-50 dark:bg-slate-900 overflow-hidden">

            <!-- ==================== SIDEBAR ==================== -->
            <!-- Mobile overlay -->
            <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-sm lg:hidden"></div>

            <!-- Sidebar panel -->
            <aside x-bind:class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 bg-sidebar flex flex-col transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:z-auto">

                <!-- Brand -->
                <div class="flex items-center gap-3 px-6 h-16 border-b border-white/10 shrink-0">
                    <div class="w-8 h-8 rounded-lg bg-indigo-500 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-white font-bold text-sm tracking-wide">KODAKARSA</span>
                        <span class="text-indigo-300 text-xs block -mt-0.5">Payroll System</span>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto scrollbar-thin">
                    <p class="px-3 text-[10px] font-semibold uppercase tracking-widest text-slate-500 mb-2">Menu Utama</p>

                    @if(auth()->user()->isAdmin())
                        <!-- Admin Dashboard -->
                        <a href="{{ route('dashboard') }}" wire:navigate
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150
                                  {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/25' : 'text-slate-400 hover:text-white hover:bg-sidebar-hover' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            Dashboard
                        </a>

                        <!-- Kelola Karyawan -->
                        <a href="{{ route('employee.edit') }}" wire:navigate
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150
                                  {{ request()->routeIs('employee.edit') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/25' : 'text-slate-400 hover:text-white hover:bg-sidebar-hover' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Karyawan
                        </a>

                        <p class="px-3 pt-4 text-[10px] font-semibold uppercase tracking-widest text-slate-500 mb-2">Penggajian</p>

                        <!-- Kalkulator Penggajian -->
                        <a href="{{ route('payroll.calculator') }}" wire:navigate
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150
                                  {{ request()->routeIs('payroll.calculator') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/25' : 'text-slate-400 hover:text-white hover:bg-sidebar-hover' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            Buat Slip Gaji
                        </a>

                        <!-- Riwayat Gaji -->
                        <a href="{{ route('payroll.history') }}" wire:navigate
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150
                                  {{ request()->routeIs('payroll.history') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/25' : 'text-slate-400 hover:text-white hover:bg-sidebar-hover' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Riwayat Gaji
                        </a>
                    @else
                        <!-- Employee Portal -->
                        <a href="{{ route('employee.portal') }}" wire:navigate
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150
                                  {{ request()->routeIs('employee.portal') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/25' : 'text-slate-400 hover:text-white hover:bg-sidebar-hover' }}">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Employee Portal
                        </a>
                    @endif
                </nav>

                <!-- User section (bottom) -->
                <div class="px-3 py-4 border-t border-white/10 shrink-0">
                    @auth
                    <div class="flex items-center gap-3 px-3 py-2">
                        <div class="w-9 h-9 rounded-full bg-indigo-500/20 flex items-center justify-center text-indigo-300 text-sm font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-500 truncate">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    @endauth
                </div>
            </aside>

            <!-- ==================== MAIN CONTENT ==================== -->
            <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

                <!-- Topbar -->
                <header class="h-16 bg-white dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between px-4 lg:px-6 shrink-0">
                    <!-- Left: Mobile menu + Page context -->
                    <div class="flex items-center gap-3">
                        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden btn-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                        <div>
                            @if (isset($header))
                                <h1 class="text-lg font-semibold text-slate-800 dark:text-slate-100">{{ $header }}</h1>
                            @endif
                        </div>
                    </div>

                    <!-- Right: Actions -->
                    <div class="flex items-center gap-2">
                        <!-- Dark mode toggle -->
                        <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" class="btn-icon" title="Toggle Dark Mode">
                            <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                            </svg>
                            <svg x-show="darkMode" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </button>

                        <!-- Profile dropdown -->
                        @auth
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center gap-2 pl-3 pr-2 py-1.5 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-200 hidden sm:block">{{ auth()->user()->name }}</span>
                                <div class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center text-indigo-700 dark:text-indigo-300 text-sm font-bold">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            </button>

                            <!-- Dropdown -->
                            <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 rounded-xl shadow-lg ring-1 ring-slate-200 dark:ring-slate-700 py-1 z-50">
                                <a href="{{ route('profile') }}" wire:navigate class="flex items-center gap-2 px-4 py-2.5 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    Profile
                                </a>
                                <div class="border-t border-slate-100 dark:border-slate-700 my-1"></div>
                                <livewire:layout.navigation />
                            </div>
                        </div>
                        @endauth
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 overflow-y-auto scrollbar-thin">
                    <div class="animate-fade-in">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>

        <!-- x-cloak style -->
        <style>[x-cloak] { display: none !important; }</style>
    </body>
</html>
