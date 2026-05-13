<div class="p-6 lg:p-8 space-y-6">

    {{-- ===== HEADER ===== --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 dark:text-white">Kelola Karyawan</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Tambah, edit, dan kelola data karyawan perusahaan</p>
        </div>
        <button wire:click="openForm" class="btn-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Karyawan
        </button>
    </div>

    {{-- ===== TOAST NOTIFICATION ===== --}}
    @if (session()->has('success'))
        <div class="toast-success" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- ===== FORM PANEL ===== --}}
    @if($showForm)
    <div class="card p-6 animate-slide-up">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-lg font-semibold text-slate-800 dark:text-white">
                {{ $isEditMode ? 'Edit Data Karyawan' : 'Input Karyawan Baru' }}
            </h3>
            <button wire:click="resetForm" class="btn-icon">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form wire:submit="store">
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                <div>
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" wire:model.blur="name" class="form-input-styled" placeholder="Masukkan nama lengkap">
                    @error('name') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="form-label">Nomor Induk / NIK</label>
                    <input type="text" wire:model.blur="nik" class="form-input-styled" placeholder="Contoh: 001234">
                    @error('nik') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="form-label">No. Telepon</label>
                    <input type="text" wire:model.blur="phone" class="form-input-styled" placeholder="Contoh: 08123456789">
                    @error('phone') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="form-label">Jabatan</label>
                    <select wire:model="position" class="form-input-styled">
                        <option value="">-- Pilih Jabatan --</option>
                        <option value="Staff IT">Staff IT</option>
                        <option value="HRD / Personalia">HRD / Personalia</option>
                        <option value="Keuangan">Keuangan</option>
                    </select>
                    @error('position') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="md:col-span-2">
                    <label class="form-label">Alamat</label>
                    <textarea wire:model.blur="address" class="form-input-styled" rows="2" placeholder="Masukkan alamat lengkap"></textarea>
                    @error('address') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex items-center gap-3 mt-6 pt-5 border-t border-slate-200 dark:border-slate-700">
                <button type="submit" wire:loading.attr="disabled" class="btn-primary">
                    <span wire:loading.remove>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ $isEditMode ? 'Perbarui Data' : 'Simpan' }}
                    </span>
                    <span wire:loading>
                        <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                        Menyimpan...
                    </span>
                </button>
                <button type="button" wire:click="resetForm" class="btn-secondary">Batal</button>
            </div>
        </form>
    </div>
    @endif

    {{-- ===== SEARCH BAR ===== --}}
    <div class="flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1 max-w-md">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" wire:model.live.debounce.300ms="search" class="form-input-styled pl-10" placeholder="Cari nama, NIK, atau jabatan...">
        </div>
        <div class="text-sm text-slate-500 dark:text-slate-400 flex items-center">
            {{ $employees->total() }} karyawan ditemukan
        </div>
    </div>

    {{-- ===== TABLE ===== --}}
    <div class="table-container">
        <div class="overflow-x-auto">
            <table class="table-styled">
                <thead>
                    <tr>
                        <th>Karyawan</th>
                        <th>NIK</th>
                        <th>Jabatan</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $item)
                        <tr class="group">
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="avatar-sm shrink-0">{{ strtoupper(substr($item->name, 0, 2)) }}</div>
                                    <span class="font-medium text-slate-800 dark:text-white">{{ $item->name }}</span>
                                </div>
                            </td>
                            <td><span class="badge-indigo font-mono">{{ $item->nik }}</span></td>
                            <td>{{ $item->position }}</td>
                            <td>{{ $item->phone }}</td>
                            <td class="max-w-[200px] truncate" title="{{ $item->address }}">{{ $item->address }}</td>
                            <td>
                                <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button wire:click="edit({{ $item->id }})" class="btn-icon" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    <button wire:click="delete({{ $item->id }})" wire:confirm="Yakin ingin menghapus karyawan '{{ $item->name }}'?" class="btn-icon text-red-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state py-10">
                                    <svg class="w-16 h-16 text-slate-200 dark:text-slate-700 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <p class="text-slate-500 dark:text-slate-400 font-medium">Belum ada data karyawan</p>
                                    <p class="text-sm text-slate-400 dark:text-slate-500 mt-1">Klik "Tambah Karyawan" untuk memulai</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($employees->hasPages())
        <div class="px-5 py-4 border-t border-slate-200 dark:border-slate-700">
            {{ $employees->links() }}
        </div>
        @endif
    </div>
</div>