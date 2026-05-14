<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'user_id',
        'nik',
        'name',
        'phone',
        'position',
        'address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Satu karyawan bisa punya banyak slip gaji
    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
