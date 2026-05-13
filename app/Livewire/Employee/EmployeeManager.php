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
        // NIK harus unik, tapi dikecualikan jika sedang edit data sendiri

        $this->validate([
            'nik' => 'required|unique:employees,nik,' . $this->employee_id,
            'name' => 'required|min:3',
            'phone' => 'required',
            'position' => 'required|min:3',
            'address' => 'required|min:5',
        ],[
            // Custom pesan error
            'nik.required' => 'NIK wajib diisi.',
            'nik.unique' => 'NIK sudah digunakan oleh karyawan lain.',
            'name.required' => 'Nama wajib diisi.',
            'name.min' => 'Nama minimal 3 karakter.',
            'phone.required' => 'No. Telepon wajib diisi.',
            'position.required' => 'Jabatan wajib diisi.',
            'position.min' => 'Jabatan minimal 3 karakter.',
            'address.required' => 'Alamat wajib diisi.',
            'address.min' => 'Alamat minimal 5 karakter.',
        ]);

        //Simpan atau update data karyawan
        // Jika employee_id null, berarti tambah data baru, jika ada nilai berarti update data lama
        Employee::updateOrCreate(
            ['id' => $this->employee_id], // Kondisi untuk update (cari data berdasarkan ID)
            [
                'nik' => $this->nik,
                'name' => $this->name,
                'phone' => $this->phone,
                'position' => $this->position,
                'address' => $this->address,
            ] // Data yang akan disimpan atau diupdate
        );

        // Flash message untuk notifikasi sukses
        session()->flash(
            'success',
            $this->isEditMode 
            ? 'Data karyawan berhasil diperbarui.' 
            : 'Data karyawan berhasil ditambahkan.'
        );

        // Reset form setelah simpan
        $this->resetForm();

    }
    // 2. Siapkan form Edit
    public function edit(int $id)
    {
        $emp = Employee::findOrFail($id);
        $this->employee_id = $emp->id;
        $this->nik         = $emp->nik;
        $this->name        = $emp->name;
        $this->position    = $emp->position;
        $this->phone       = $emp->phone;
        $this->address     = $emp->address;
        $this->isEditMode  = true;
        $this->showForm    = true;
    }

    // 3. DELETE
    public function delete(int $id)
    {
        Employee::findOrFail($id)->delete();
        session()->flash('success', 'Karyawan berhasil dihapus.');
    }

    public function resetForm()
    {
        $this->reset(['employee_id', 'nik', 'name', 'phone', 'position', 'address', 'isEditMode', 'showForm']);
        $this->resetValidation();
    }

    // 4. READ
    public function render()
    {
        $query = Employee::query();

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
