<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Employee Portal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(!$employee)
                <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-md shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">
                                You are not linked to an employee profile. Please contact the administrator.
                            </p>
                        </div>
                    </div>
                </div>
            @else

                <!-- Grid for Salary and Attendance -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- Salary Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 flex flex-col">
                        <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-white">
                            <h3 class="text-lg font-bold text-gray-900">Current Salary Overview</h3>
                            <p class="text-sm text-gray-500">{{ $latestPayroll ? $latestPayroll->month_year : 'No data available' }}</p>
                        </div>
                        <div class="p-6 flex-1 flex flex-col justify-center">
                            @if($latestPayroll)
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center pb-3 border-b border-gray-50">
                                        <span class="text-gray-500">Basic Salary</span>
                                        <span class="font-medium text-gray-900">Rp {{ number_format($latestPayroll->basic_salary, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center pb-3 border-b border-gray-50">
                                        <span class="text-gray-500">Allowances</span>
                                        <span class="font-medium text-green-600">+ Rp {{ number_format($latestPayroll->allowance, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center pb-3 border-b border-gray-50">
                                        <span class="text-gray-500">Deductions</span>
                                        <span class="font-medium text-red-600">- Rp {{ number_format($latestPayroll->deduction, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center pt-2">
                                        <span class="text-lg font-bold text-gray-900">Take Home Pay</span>
                                        <span class="text-2xl font-bold text-indigo-600">Rp {{ number_format($latestPayroll->net_salary, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            @else
                                <div class="text-center text-gray-400 py-8">
                                    <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p>No payroll data available yet.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Attendance Component -->
                    <livewire:employee-portal.attendance-manager />

                </div>

                <!-- Payroll History -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 mt-6">
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900">Salary History</h3>
                    </div>
                    <div class="p-6">
                        @if($payrolls->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-l-lg">Period</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Basic Salary</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Net Salary</th>
                                            <th class="px-6 py-3 bg-gray-50 text-right text-xs font-medium text-gray-500 uppercase tracking-wider rounded-r-lg">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-100">
                                        @foreach($payrolls as $payroll)
                                            <tr class="hover:bg-gray-50 transition-colors">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $payroll->month_year }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    Rp {{ number_format($payroll->basic_salary, 0, ',', '.') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-indigo-600">
                                                    Rp {{ number_format($payroll->net_salary, 0, ',', '.') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <a href="{{ route('payroll.cetak', $payroll->id) }}" target="_blank" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                                        <svg class="mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                        </svg>
                                                        Download PDF
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-6 text-gray-500">No payroll history found.</div>
                        @endif
                    </div>
                </div>

            @endif
        </div>
    </div>
</div>
