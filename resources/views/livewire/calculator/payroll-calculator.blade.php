<div class="p-6 lg:p-8 space-y-6">

    {{-- ===== HEADER ===== --}}
    <div>
        <h1 class="text-2xl font-bold text-slate-800 dark:text-white">Buat Slip Gaji</h1>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Hitung dan terbitkan slip gaji karyawan untuk periode tertentu</p>
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

    {{-- ===== TWO COLUMN LAYOUT ===== --}}
    <div class="grid grid-cols-1 xl:grid-cols-5 gap-6">

        {{-- LEFT: Form --}}
        <div class="xl:col-span-3">
            <div class="card p-6">
                <h3 class="text-base font-semibold text-slate-800 dark:text-white mb-5">Detail Penggajian</h3>

                <form wire:submit="savePayroll" class="space-y-5">

                    {{-- Employee & Period row --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="form-label">Karyawan</label>
                            <select wire:model="employee_id" class="form-input-styled">
                                <option value="">-- Pilih Karyawan --</option>
                                @foreach($employees as $emp)
                                    <option value="{{ $emp->id }}">{{ $emp->nik }} — {{ $emp->name }}</option>
                                @endforeach
                            </select>
                            @error('employee_id') <span class="form-error">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="form-label">Periode Gaji</label>
                            <input type="text" wire:model="month_year" class="form-input-styled" placeholder="Mei 2026">
                            @error('month_year') <span class="form-error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div class="border-t border-slate-200 dark:border-slate-700"></div>

                    {{-- Salary components --}}
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-4">Komponen Gaji</p>
                        <div class="space-y-4">
                            <div>
                                <label class="form-label">Gaji Pokok</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-400 font-medium">Rp</span>
                                    <input type="number" wire:model.live="basic_salary" min="0" class="form-input-styled pl-10 money" placeholder="0">
                                </div>
                                @error('basic_salary') <span class="form-error">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="form-label flex items-center gap-2">
                                    Tunjangan
                                    <span class="badge-green text-[10px]">+ Tambahan</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-400 font-medium">Rp</span>
                                    <input type="number" wire:model.live="allowance" min="0" class="form-input-styled pl-10 money" placeholder="0">
                                </div>
                            </div>
                            <div>
                                <label class="form-label flex items-center gap-2">
                                    Potongan
                                    <span class="badge-red text-[10px]">− Pengurang</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-400 font-medium">Rp</span>
                                    <input type="number" wire:model.live="deduction" min="0" class="form-input-styled pl-10 money" placeholder="0">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="pt-2">
                        <button type="submit" wire:loading.attr="disabled" class="btn-primary w-full py-3">
                            <span wire:loading.remove class="flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                                </svg>
                                Simpan & Terbitkan Slip Gaji
                            </span>
                            <span wire:loading class="flex items-center justify-center gap-2">
                                <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                Menyimpan...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- RIGHT: Live Preview --}}
        <div class="xl:col-span-2">
            <div class="card p-6 sticky top-6">
                <h3 class="text-base font-semibold text-slate-800 dark:text-white mb-5">Ringkasan Gaji</h3>

                {{-- Breakdown --}}
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-slate-500 dark:text-slate-400">Gaji Pokok</span>
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-200 money">Rp {{ number_format($basic_salary ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-slate-500 dark:text-slate-400">Tunjangan</span>
                        <span class="text-sm font-medium text-emerald-600 dark:text-emerald-400 money">+ Rp {{ number_format($allowance ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-slate-500 dark:text-slate-400">Potongan</span>
                        <span class="text-sm font-medium text-red-500 dark:text-red-400 money">− Rp {{ number_format($deduction ?? 0, 0, ',', '.') }}</span>
                    </div>

                    {{-- Divider --}}
                    <div class="border-t-2 border-dashed border-slate-200 dark:border-slate-600"></div>

                    {{-- THP --}}
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-sm font-semibold text-slate-700 dark:text-slate-200">Take Home Pay</span>
                            <p class="text-[11px] text-slate-400 dark:text-slate-500">Gaji Bersih</p>
                        </div>
                        <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400 money">
                            Rp {{ number_format($net_salary ?? 0, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                {{-- Formula info --}}
                <div class="mt-6 p-3 bg-slate-50 dark:bg-slate-700/50 rounded-lg">
                    <p class="text-[11px] text-slate-400 dark:text-slate-500 text-center">
                        THP = Gaji Pokok + Tunjangan − Potongan
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>