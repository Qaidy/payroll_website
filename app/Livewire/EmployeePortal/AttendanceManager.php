<?php

namespace App\Livewire\EmployeePortal;

use Livewire\Component;

use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceManager extends Component
{
    public $employee;
    public $todayAttendance;
    public $attendances;

    public function mount()
    {
        $this->employee = auth()->user()->employee;
        if ($this->employee) {
            $this->loadAttendanceData();
        }
    }

    public function loadAttendanceData()
    {
        $this->todayAttendance = Attendance::where('employee_id', $this->employee->id)
            ->whereDate('date', Carbon::today())
            ->first();
            
        $this->attendances = Attendance::where('employee_id', $this->employee->id)
            ->orderBy('date', 'desc')
            ->take(10)
            ->get();
    }

    public function clockIn()
    {
        if (!$this->employee) return;
        if ($this->todayAttendance) {
            session()->flash('error', 'You have already checked in today.');
            return;
        }

        $now = Carbon::now();
        $status = $now->format('H:i:s') > '09:00:00' ? 'Late' : 'Present';

        Attendance::create([
            'employee_id' => $this->employee->id,
            'date' => $now->toDateString(),
            'check_in' => $now->toTimeString(),
            'status' => $status,
        ]);

        session()->flash('success', 'Successfully clocked in!');
        $this->loadAttendanceData();
    }

    public function clockOut()
    {
        if (!$this->employee || !$this->todayAttendance) return;
        
        if ($this->todayAttendance->check_out) {
            session()->flash('error', 'You have already clocked out today.');
            return;
        }

        $now = Carbon::now();
        $checkInTime = Carbon::parse($this->todayAttendance->date . ' ' . $this->todayAttendance->check_in);
        
        // Calculate diff in hours
        $hours = $checkInTime->diffInMinutes($now) / 60;

        $this->todayAttendance->update([
            'check_out' => $now->toTimeString(),
            'working_hours' => round($hours, 2),
        ]);

        session()->flash('success', 'Successfully clocked out!');
        $this->loadAttendanceData();
    }

    public function render()
    {
        return view('livewire.employee-portal.attendance-manager');
    }
}
