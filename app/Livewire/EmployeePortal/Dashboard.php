<?php

namespace App\Livewire\EmployeePortal;

use Livewire\Component;

class Dashboard extends Component
{
    public $employee;
    public $latestPayroll;
    public $payrolls;

    public function mount()
    {
        // Get the logged in user's employee record
        $this->employee = auth()->user()->employee;
        
        if ($this->employee) {
            $this->payrolls = $this->employee->payrolls()->orderBy('id', 'desc')->get();
            $this->latestPayroll = $this->payrolls->first();
        } else {
            $this->payrolls = collect();
            $this->latestPayroll = null;
        }
    }

    public function render()
    {
        return view('livewire.employee-portal.dashboard')->layout('layouts.app');
    }
}
