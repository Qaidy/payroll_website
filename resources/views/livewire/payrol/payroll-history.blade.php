<div class="p-6 lg:p-8 space-y-6">

    {{-- ===== HEADER ===== --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 dark:text-white">Riwayat Slip Gaji</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Lihat dan kelola semua slip gaji yang telah diterbitkan</p>
        </div>
        <a href="{{ route('payroll.calculator') }}" wire:navigate class="btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Buat Slip Baru
        </a>
    </div>

    {{-- ===== TOAST ===== --}}
    @if(session()->has('success'))
        <div class="toast-success" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- ===== SUMMARY BAR ===== --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="card p-4 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center">
                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-500 dark:text-slate-400">Total Slip</p>
                <p class="text-lg font-bold text-slate-800 dark:text-white money">{{ $totalCount }}</p>
            </div>
        </div>
        <div class="card p-4 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-500 dark:text-slate-400">Total Pengeluaran</p>
                <p class="text-lg font-bold text-slate-800 dark:text-white money">Rp {{ number_format($totalAmount, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    {{-- ===== FILTERS ===== --}}
    <div class="flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1 max-w-md">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" wire:model.live.debounce.300ms="search" class="form-input-styled pl-10" placeholder="Cari karyawan...">
        </div>
        <select wire:model.live="filterPeriod" class="form-input-styled w-auto min-w-[180px]">
            <option value="">Semua Periode</option>
            @foreach($periods as $period)
                <option value="{{ $period }}">{{ $period }}</option>
            @endforeach
        </select>
    </div>

    {{-- ===== TABLE ===== --}}
    <div class="table-container">
        <div class="overflow-x-auto">
            <table class="table-styled">
                <thead>
                    <tr>
                        <th>Karyawan</th>
                        <th>Periode</th>
                        <th class="text-right">Gaji Pokok</th>
                        <th class="text-right">Tunjangan</th>
                        <th class="text-right">Potongan</th>
                        <th class="text-right">Take Home Pay</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payrolls as $p)
                        <tr class="group">
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="avatar-sm shrink-0">{{ strtoupper(substr($p->employee->name, 0, 2)) }}</div>
                                    <div>
                                        <p class="font-medium text-slate-800 dark:text-white">{{ $p->employee->name }}</p>
                                        <p class="text-xs text-slate-400 dark:text-slate-500 font-mono">{{ $p->employee->nik }}</p>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge-indigo">{{ $p->month_year }}</span></td>
                            <td class="text-right money">Rp {{ number_format($p->basic_salary, 0, ',', '.') }}</td>
                            <td class="text-right money text-emerald-600 dark:text-emerald-400">+Rp {{ number_format($p->allowance, 0, ',', '.') }}</td>
                            <td class="text-right money text-red-500 dark:text-red-400">−Rp {{ number_format($p->deduction, 0, ',', '.') }}</td>
                            <td class="text-right money font-bold text-indigo-600 dark:text-indigo-400">Rp {{ number_format($p->net_salary, 0, ',', '.') }}</td>
                            <td>
                                <div class="flex items-center justify-end gap-1">
                                    @if(Route::has('payroll.cetak'))
                                        <a href="{{ route('payroll.cetak', $p->id) }}" target="_blank" class="btn-icon" title="Cetak PDF">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                            </svg>
                                        </a>
                                    @endif
                                    <button wire:click="deletePayroll({{ $p->id }})" wire:confirm="Hapus slip gaji {{ $p->employee->name }} ({{ $p->month_year }})?" class="btn-icon text-red-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 opacity-0 group-hover:opacity-100 transition-opacity" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state py-10">
                                    <svg class="w-16 h-16 text-slate-200 dark:text-slate-700 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p class="text-slate-500 dark:text-slate-400 font-medium">Belum ada riwayat slip gaji</p>
                                    <p class="text-sm text-slate-400 dark:text-slate-500 mt-1">
                                        Buat slip gaji pertama di halaman
                                        <a href="{{ route('payroll.calculator') }}" wire:navigate class="text-indigo-600 dark:text-indigo-400 hover:underline font-medium">Buat Slip Gaji</a>
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($payrolls->hasPages())
        <div class="px-5 py-4 border-t border-slate-200 dark:border-slate-700">
            {{ $payrolls->links() }}
        </div>
        @endif
    </div>
</div>