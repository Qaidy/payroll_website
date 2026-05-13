<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Employee;
use App\Models\Payroll;
use Carbon\Carbon;

class Dashboard extends Component
{
    public function render()
    {
        // Current period in Indonesian locale
        $periodeBulanIni = Carbon::now()->locale('id')->isoFormat('MMMM YYYY');

        // Monthly trend data (last 6 months)
        $monthlyTrend = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $period = $date->locale('id')->isoFormat('MMMM YYYY');
            $shortLabel = $date->locale('id')->isoFormat('MMM YY');
            $total = Payroll::where('month_year', $period)->sum('net_salary');
            $monthlyTrend->push([
                'period' => $shortLabel,
                'total' => $total,
            ]);
        }
        $maxTrend = $monthlyTrend->max('total') ?: 1;

        // Recent payrolls
        $recentPayrolls = Payroll::with('employee')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('livewire.dashboard.dashboard', [
            'totalKaryawan' => Employee::count(),
            'totalGaji' => Payroll::where('month_year', $periodeBulanIni)->sum('net_salary'),
            'slipCount' => Payroll::where('month_year', $periodeBulanIni)->count(),
            'avgSalary' => Payroll::where('month_year', $periodeBulanIni)->avg('net_salary') ?? 0,
            'monthlyTrend' => $monthlyTrend,
            'maxTrend' => $maxTrend,
            'recentPayrolls' => $recentPayrolls,
            'currentPeriod' => $periodeBulanIni,
        ])->layout('layouts.app');
    }
}
