<div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 flex flex-col">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
        <h3 class="text-lg font-bold text-gray-900">Today's Attendance</h3>
        <div class="text-sm font-medium text-gray-500">{{ \Carbon\Carbon::now()->format('l, d M Y') }}</div>
    </div>
    
    <div class="p-6">
        @if (session()->has('success'))
            <div class="mb-4 bg-green-50 border-l-4 border-green-400 p-4 rounded-md shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-4 bg-red-50 border-l-4 border-red-400 p-4 rounded-md shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="flex flex-col items-center justify-center space-y-6 mb-8">
            <div class="text-4xl font-bold text-gray-800 tracking-tight" wire:poll.1000ms>
                {{ \Carbon\Carbon::now()->format('H:i:s') }}
            </div>
            
            <div class="flex space-x-4">
                @if(!$todayAttendance)
                    <button wire:click="clockIn" wire:loading.attr="disabled" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 transition-all transform hover:scale-105">
                        <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Clock In
                    </button>
                @elseif(!$todayAttendance->check_out)
                    <div class="text-center">
                        <p class="text-sm text-gray-500 mb-3">Checked in at <span class="font-bold text-gray-900">{{ $todayAttendance->check_in }}</span></p>
                        <button wire:click="clockOut" wire:loading.attr="disabled" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 disabled:opacity-50 transition-all transform hover:scale-105">
                            <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Clock Out
                        </button>
                    </div>
                @else
                    <div class="text-center p-4 bg-green-50 rounded-2xl border border-green-100">
                        <p class="text-green-800 font-medium">You have completed your attendance for today.</p>
                        <p class="text-sm text-green-600 mt-1">Working hours: {{ $todayAttendance->working_hours }} hrs</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-6 border-t border-gray-100 pt-6">
            <h4 class="text-sm font-bold text-gray-900 mb-4 uppercase tracking-wider">Recent Activity</h4>
            <div class="space-y-3">
                @forelse($attendances->take(3) as $record)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($record->date)->format('M d, Y') }}</p>
                            <p class="text-xs text-gray-500">{{ $record->check_in }} - {{ $record->check_out ?? 'Pending' }}</p>
                        </div>
                        <div>
                            @if($record->status === 'Present')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Present</span>
                            @elseif($record->status === 'Late')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Late</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">{{ $record->status }}</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 italic">No recent attendance records.</p>
                @endforelse
            </div>
        </div>

    </div>
</div>
