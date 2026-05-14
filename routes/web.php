<?php

use Illuminate\Support\Facades\Route;
use App\Models\Payroll;
use Barryvdh\DomPDF\Facade\Pdf;

Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->role === 'employee') {
            return redirect()->route('employee.portal');
        }
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
})->name('home');

// Admin Routes
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('dashboard', \App\Livewire\Dashboard\Dashboard::class)->name('dashboard');
    Route::view('employee', 'livewire.employee.index')->name('employee.index');
    Route::get('editkaryawan', \App\Livewire\Employee\EmployeeManager::class)->name('employee.edit');
    Route::get('/payroll', \App\Livewire\Calculator\PayrollCalculator::class)->name('payroll.calculator');
    Route::get('/payroll-history', \App\Livewire\Payrol\PayrollHistory::class)->name('payroll.history');
});

// Employee Portal Routes
Route::middleware(['auth', 'verified', 'role:employee'])->group(function () {
    Route::get('/employee-portal', \App\Livewire\EmployeePortal\Dashboard::class)->name('employee.portal');
});

// Common Auth Routes
Route::middleware(['auth'])->group(function () {
    Route::view('profile', 'profile')->name('profile');
    
    // Download Payslip (Admin or the specific Employee)
    Route::get('/cetak-slip/{id}', function ($id) {
        $payroll = Payroll::with('employee')->findOrFail($id);
        
        $user = auth()->user();
        if ($user->role !== 'admin') {
            if (!$user->employee || $user->employee->id !== $payroll->employee_id) {
                abort(403, 'You are not authorized to view this payslip.');
            }
        }

        $pdf = Pdf::loadView('pdf.slip-gaji', ['data' => $payroll]);
        return $pdf->stream('Slip_Gaji_' . $payroll->employee->nik . '.pdf');
    })->name('payroll.cetak');
});


require __DIR__ . '/auth.php';
