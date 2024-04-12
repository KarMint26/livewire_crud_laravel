<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Employee as ModelsEmployee;
use Livewire\WithPagination;

class Employee extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $nama;
    public $email;
    public $alamat;
    public $updateData = false;
    public $employeeId = 1;
    public $keyword = '';
    public $employee_selected_id = [];
    public $sortColumn = 'nama';
    public $sortDirection = 'asc';

    public function store()
    {
        $rules = [
            "nama" => "required",
            "email" => "required|email",
            "alamat" => "required",
        ];
        $validated = $this->validate($rules, [
            "nama.required" => "Nama wajib diisi",
            "email.required" => "Email wajib diisi",
            "email.email" => "Email tidak valid",
            "alamat.required" => "Alamat wajib diisi"
        ]);
        ModelsEmployee::create($validated);
        session()->flash('message', 'Data berhasil dimasukkan');

        $this->clear();
    }

    public function edit($id)
    {
        $employee = ModelsEmployee::find($id);
        $this->nama = $employee->nama;
        $this->email = $employee->email;
        $this->alamat = $employee->alamat;

        $this->updateData = true;
        $this->employeeId = $employee->id;
    }

    public function update()
    {
        $rules = [
            "nama" => "required",
            "email" => "required|email",
            "alamat" => "required",
        ];
        $validated = $this->validate($rules, [
            "nama.required" => "Nama wajib diisi",
            "email.required" => "Email wajib diisi",
            "email.email" => "Email tidak valid",
            "alamat.required" => "Alamat wajib diisi"
        ]);
        $data = ModelsEmployee::find($this->employeeId);
        $data->update($validated);
        session()->flash('message', 'Data berhasil diupdate');

        $this->clear();
    }

    public function delete()
    {
        if($this->employeeId != '') {
            $employee = ModelsEmployee::find($this->employeeId);
            $employee->delete();
        }
        if(count($this->employee_selected_id)) {
            for ($i = 0; $i < count($this->employee_selected_id); $i++) {
                ModelsEmployee::find($this->employee_selected_id[$i])->delete();
            }
        }

        session()->flash('message', 'Data berhasil dihapus');
        $this->clear();
    }

    public function delete_confirmation($id)
    {
        if($id != "") {
            $this->employeeId = $id;
        }
    }

    public function clear()
    {
        $this->nama = "";
        $this->email = "";
        $this->alamat = "";

        $this->updateData = false;
        $this->employeeId = "";
        $this->employee_selected_id = [];
    }

    public function sort($columnName)
    {
        $this->sortColumn = $columnName;
        $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';
    }

    public function render()
    {
        if($this->keyword != null) {
            $data = ModelsEmployee::where('nama', 'like', '%' . $this->keyword . '%')
                ->orWhere('email', 'like', '%' . $this->keyword . '%')
                ->orWhere('alamat', 'like', '%' . $this->keyword . '%')
                ->orderBy($this->sortColumn, $this->sortDirection )->paginate(5);
        } else {
            $data = ModelsEmployee::orderBy($this->sortColumn, $this->sortDirection )->paginate(5);
        }
        return view('livewire.employee', ['dataEmployees' => $data]);
    }
}
