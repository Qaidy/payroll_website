<?php

namespace App\Livewire\Employee;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Employee;

class EmployeeManager extends Component
{
    use WithPagination;

    // Menyimpan ID karyawan (null = mode tambah, ada nilai = mode edit)
    public ?int $employee_id = null;

     // Penanda apakah sedang dalam mode edit
    public bool $isEditMode = false;

    // Toggle form visibility
    public bool $showForm = false;

    // Search
    public string $search = '';

    // Properti yang terhubung dengan input form (binding Livewire)
    public string $nik ='';
    public string $name = '';
    public string $email = ''; // Added email for user account
    public string $phone = '';
    public string $position ='';
    public string $address ='';

    // Reset pagination when search changes
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    // Open form for new employee
    public function openForm(): void
    {
        $this->resetForm();
        $this->showForm = true;
    }

    // create/update data
    public function store(){
        // validasi input form
        $rules = [
            'nik' => 'required|unique:employees,nik,' . $this->employee_id,
            'name' => 'required|min:3',
            'phone' => 'required',
            'position' => 'required|min:3',
            'address' => 'required|min:5',
        ];

        // Validasi email
        if (!$this->isEditMode) {
            $rules['email'] = 'required|email|unique:users,email';
        } else {
            $emp = Employee::find($this->employee_id);
            if ($emp && $emp->user_id) {
                $rules['email'] = 'required|email|unique:users,email,' . $emp->user_id;
            } else {
                $rules['email'] = 'required|email|unique:users,email';
            }
        }

        $this->validate($rules, [
            'nik.required' => 'NIK wajib diisi.',
            'nik.unique' => 'NIK sudah digunakan oleh karyawan lain.',
            'name.required' => 'Nama wajib diisi.',
            'name.min' => 'Nama minimal 3 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'phone.required' => 'No. Telepon wajib diisi.',
            'position.required' => 'Jabatan wajib diisi.',
            'position.min' => 'Jabatan minimal 3 karakter.',
            'address.required' => 'Alamat wajib diisi.',
            'address.min' => 'Alamat minimal 5 karakter.',
        ]);

        $userId = null;

        // Create or Update User account
        if (!$this->isEditMode) {
            $user = \App\Models\User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => \Illuminate\Support\Facades\Hash::make('password123'), // Default password
                'role' => 'employee'
            ]);
            $userId = $user->id;
        } else {
            $emp = Employee::find($this->employee_id);
            if ($emp && $emp->user_id) {
                $user = \App\Models\User::find($emp->user_id);
                $user->update([
                    'name' => $this->name,
                    'email' => $this->email,
                ]);
                $userId = $user->id;
            } else {
                // If editing an old employee without a user account
                $user = \App\Models\User::create([
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                    'role' => 'employee'
                ]);
                $userId = $user->id;
            }
        }

        //Simpan atau update data karyawan
        Employee::updateOrCreate(
            ['id' => $this->employee_id],
            [
                'user_id' => $userId,
                'nik' => $this->nik,
                'name' => $this->name,
                'phone' => $this->phone,
                'position' => $this->position,
                'address' => $this->address,
            ]
        );

        session()->flash(
            'success',
            $this->isEditMode 
            ? 'Data karyawan dan akun berhasil diperbarui.' 
            : 'Data karyawan dan akun berhasil ditambahkan. Password default: password123'
        );

        $this->resetForm();
    }

    // 2. Siapkan form Edit
    public function edit(int $id)
    {
        $emp = Employee::with('user')->findOrFail($id);
        $this->employee_id = $emp->id;
        $this->nik         = $emp->nik;
        $this->name        = $emp->name;
        $this->email       = $emp->user ? $emp->user->email : '';
        $this->position    = $emp->position;
        $this->phone       = $emp->phone;
        $this->address     = $emp->address;
        $this->isEditMode  = true;
        $this->showForm    = true;
    }

    // 3. DELETE
    public function delete(int $id)
    {
        $emp = Employee::findOrFail($id);
        if ($emp->user_id) {
            \App\Models\User::find($emp->user_id)?->delete();
        }
        $emp->delete();
        session()->flash('success', 'Karyawan dan akun berhasil dihapus.');
    }

    public function resetForm()
    {
        $this->reset(['employee_id', 'nik', 'name', 'email', 'phone', 'position', 'address', 'isEditMode', 'showForm']);
        $this->resetValidation();
    }

    // 4. READ
    public function render()
    {
        $query = Employee::query()->with('user');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('nik', 'like', '%' . $this->search . '%')
                  ->orWhere('position', 'like', '%' . $this->search . '%');
            });
        }

        return view('livewire.employee.employee-manager', [
            'employees' => $query->orderBy('id', 'desc')->paginate(10),
        ])->layout('layouts.app');
    }
}
