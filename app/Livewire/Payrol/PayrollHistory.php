<?php

namespace App\Livewire\Payrol;

use Livewire\Component;
use App\Models\Payroll;
use Livewire\WithPagination;

class PayrollHistory extends Component
{
    use WithPagination;
    public string $filterPeriod = '';
    public string $search = '';

    // Reset ke halaman 1 setiap kali dropdown filter berubah   
    public function updatingFilterPeriod(): void
    {
        $this->resetPage();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function deletePayroll(int $id): void
    {
        Payroll::findOrFail($id)->delete();
        session()->flash('success', 'Slip gaji berhasil dihapus.');
    }
    
    public function render()
    {
        $query = Payroll::with('employee')->orderBy('created_at', 'desc');

        // $query HARUS di-assign ulang — where() mengembalikan instance baru
        if ($this->filterPeriod){
            $query = $query->where('month_year', $this->filterPeriod);
        }

        if ($this->search) {
            $query = $query->whereHas('employee', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('nik', 'like', '%' . $this->search . '%');
            });
        }

        // Calculate total for current filter
        $totalAmount = (clone $query)->sum('net_salary');
        $totalCount = (clone $query)->count();

        return view('livewire.payrol.payroll-history',[
            'payrolls'=> $query->paginate(10),
            'periods' => Payroll::select('month_year')
            ->distinct()
            ->orderBy('month_year', 'desc')
            ->pluck('month_year'),
            'totalAmount' => $totalAmount,
            'totalCount' => $totalCount,
        ])->layout('layouts.app');
    }
}
