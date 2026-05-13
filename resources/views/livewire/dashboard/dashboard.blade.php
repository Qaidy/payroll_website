<div class="p-6 lg:p-8 space-y-8">

    {{-- ===== GREETING ===== --}}
    <div>
        <h1 class="text-2xl font-bold text-slate-800 dark:text-white">
            Selamat {{ now()->hour < 12 ? 'Pagi' : (now()->hour < 17 ? 'Siang' : 'Malam') }}, {{ auth()->user()->name }} 👋
        </h1>
        <p class="text-slate-500 dark:text-slate-400 mt-1">Berikut ringkasan payroll untuk periode <span class="font-medium text-slate-700 dark:text-slate-300">{{ $currentPeriod }}</span></p>
    </div>

    {{-- ===== STATS CARDS ===== --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

        {{-- Total Karyawan --}}
        <div class="stat-card group">
            <div class="flex items-center justify-between">
                <div class="w-11 h-11 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-sm text-slate-500 dark:text-slate-400">Total Karyawan</p>
                <p class="text-3xl font-bold text-slate-800 dark:text-white mt-1 money">{{ $totalKaryawan }}</p>
            </div>
        </div>

        {{-- Total Gaji --}}
        <div class="stat-card group">
            <div class="flex items-center justify-between">
                <div class="w-11 h-11 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-sm text-slate-500 dark:text-slate-400">Total Gaji Bulan Ini</p>
                <p class="text-3xl font-bold text-slate-800 dark:text-white mt-1 money">Rp {{ number_format($totalGaji, 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- Slip Terbit --}}
        <div class="stat-card group">
            <div class="flex items-center justify-between">
                <div class="w-11 h-11 rounded-xl bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-sm text-slate-500 dark:text-slate-400">Slip Terbit</p>
                <p class="text-3xl font-bold text-slate-800 dark:text-white mt-1 money">{{ $slipCount }}</p>
            </div>
        </div>

        {{-- Rata-rata Gaji --}}
        <div class="stat-card group">
            <div class="flex items-center justify-between">
                <div class="w-11 h-11 rounded-xl bg-violet-50 dark:bg-violet-900/30 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-sm text-slate-500 dark:text-slate-400">Rata-rata THP</p>
                <p class="text-3xl font-bold text-slate-800 dark:text-white mt-1 money">Rp {{ number_format($avgSalary, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    {{-- ===== CHARTS & RECENT ===== --}}
    <div class="grid grid-cols-1 xl:grid-cols-5 gap-6">

        {{-- Monthly Payroll Trend --}}
        <div class="xl:col-span-3 card p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-base font-semibold text-slate-800 dark:text-white">Tren Pengeluaran Gaji</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">6 bulan terakhir</p>
                </div>
            </div>

            <div class="space-y-3">
                @foreach($monthlyTrend as $item)
                <div class="flex items-center gap-4">
                    <span class="text-xs text-slate-500 dark:text-slate-400 w-16 shrink-0 font-medium">{{ $item['period'] }}</span>
                    <div class="flex-1 h-8 bg-slate-100 dark:bg-slate-700 rounded-lg overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-indigo-500 to-indigo-400 dark:from-indigo-600 dark:to-indigo-400 rounded-lg flex items-center justify-end pr-3 transition-all duration-700"
                             style="width: {{ $maxTrend > 0 ? max(($item['total'] / $maxTrend) * 100, 2) : 2 }}%">
                            @if($item['total'] > 0)
                            <span class="text-[10px] font-bold text-white whitespace-nowrap">Rp {{ number_format($item['total'], 0, ',', '.') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Recent Payrolls --}}
        <div class="xl:col-span-2 card p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-semibold text-slate-800 dark:text-white">Slip Gaji Terbaru</h3>
                <a href="{{ route('payroll.history') }}" wire:navigate class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline font-medium">Lihat Semua →</a>
            </div>

            @if($recentPayrolls->isEmpty())
                <div class="empty-state py-8">
                    <svg class="w-12 h-12 text-slate-300 dark:text-slate-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-sm text-slate-400 dark:text-slate-500">Belum ada slip gaji</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($recentPayrolls as $p)
                    <div class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                        <div class="avatar-sm shrink-0">{{ strtoupper(substr($p->employee->name, 0, 2)) }}</div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-700 dark:text-slate-200 truncate">{{ $p->employee->name }}</p>
                            <p class="text-xs text-slate-400 dark:text-slate-500">{{ $p->month_year }}</p>
                        </div>
                        <span class="text-sm font-semibold text-slate-800 dark:text-white money whitespace-nowrap">Rp {{ number_format($p->net_salary, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- ===== QUICK ACTIONS ===== --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <a href="{{ route('employee.edit') }}" wire:navigate class="card-hover p-5 flex items-center gap-4 group">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
            </div>
            <div>
                <p class="font-semibold text-slate-800 dark:text-white">Kelola Karyawan</p>
                <p class="text-sm text-slate-500 dark:text-slate-400">Tambah, edit, atau hapus data karyawan</p>
            </div>
        </a>

        <a href="{{ route('payroll.calculator') }}" wire:navigate class="card-hover p-5 flex items-center gap-4 group">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <p class="font-semibold text-slate-800 dark:text-white">Buat Slip Gaji</p>
                <p class="text-sm text-slate-500 dark:text-slate-400">Hitung dan terbitkan slip gaji karyawan</p>
            </div>
        </a>
    </div>
</div>