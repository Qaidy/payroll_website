<x-app-layout>
    <x-slot name="header">
        {{ __('Overview') }}
    </x-slot>

    <div class="p-4 lg:p-8">
        <!-- Header Actions -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-slate-100">Dashboard</h1>
                <p class="text-sm text-slate-500 mt-1">Overview of your current payroll cycle.</p>
            </div>
            <a href="{{ route('payroll.calculator') }}" wire:navigate class="btn-primary shadow-sm shadow-indigo-500/20">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Run Payroll
            </a>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Stat Card 1 -->
            <div class="stat-card">
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Payroll This Month</p>
                <div class="mt-2 flex items-baseline gap-2">
                    <p class="text-3xl font-semibold text-slate-900 dark:text-slate-100 tracking-tight money">Rp 45,231,890</p>
                    <span class="badge-green">+12%</span>
                </div>
            </div>
            <!-- Stat Card 2 -->
            <div class="stat-card">
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Active Employees</p>
                <div class="mt-2 flex items-baseline gap-2">
                    <p class="text-3xl font-semibold text-slate-900 dark:text-slate-100 tracking-tight">24</p>
                </div>
            </div>
            <!-- Stat Card 3 -->
            <div class="stat-card">
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Next Processing Date</p>
                <div class="mt-2 flex items-baseline gap-2">
                    <p class="text-3xl font-semibold text-slate-900 dark:text-slate-100 tracking-tight">25 Nov</p>
                    <span class="badge-indigo">In 12 days</span>
                </div>
            </div>
        </div>

        <!-- Recent Activity Table -->
        <div class="table-container">
            <div class="px-6 py-5 border-b border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 flex justify-between items-center">
                <h3 class="text-base font-semibold text-slate-900 dark:text-slate-100">Recent Transactions</h3>
                <a href="{{ route('payroll.history') }}" wire:navigate class="text-sm text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 font-medium transition-colors">View all</a>
            </div>
            <div class="overflow-x-auto">
                <table class="table-styled">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="avatar-sm">SJ</div>
                                    <span class="font-medium text-slate-900 dark:text-slate-100">Sarah Jenkins</span>
                                </div>
                            </td>
                            <td class="text-slate-500">Oct 24, 2023</td>
                            <td class="font-medium money text-slate-900 dark:text-slate-100">Rp 4,120,000</td>
                            <td><span class="badge-green">Processed</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="avatar-sm">MJ</div>
                                    <span class="font-medium text-slate-900 dark:text-slate-100">Michael Jordan</span>
                                </div>
                            </td>
                            <td class="text-slate-500">Oct 24, 2023</td>
                            <td class="font-medium money text-slate-900 dark:text-slate-100">Rp 5,500,000</td>
                            <td><span class="badge-green">Processed</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="avatar-sm">AD</div>
                                    <span class="font-medium text-slate-900 dark:text-slate-100">Amanda Doe</span>
                                </div>
                            </td>
                            <td class="text-slate-500">Oct 24, 2023</td>
                            <td class="font-medium money text-slate-900 dark:text-slate-100">Rp 3,850,000</td>
                            <td><span class="badge-green">Processed</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
