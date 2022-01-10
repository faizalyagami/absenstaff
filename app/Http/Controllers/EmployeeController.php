<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index() {
		$genders = [1 => 'Male', 'Female'];

		$employees = Employee::with(['departement', 'position'])
			->orderBy('first_name')
			->paginate(50)
			->withQueryString();

		return view('pages.employees.index', [
			'active' => 'employees', 'genders' => $genders, 
			'employees' => $employees
		]);
	}

	public function create() {
		$status = [1 => 'Active', 'Inactive'];
		$genders = [1 => 'Male', 'Female'];
		$religions = [1 => 'Islam', 'Kristen', 'Hindu', 'Budha', 'Other'];
		$departements = Departement::where('status', 1)->orderBy('name')->pluck('name', 'id');
		$positions = Position::where('status', 1)->orderBy('name')->pluck('name', 'id');

		return view('pages.employees.create', [
			'active' => 'employees', 'status' => $status, 'genders' => $genders, 'religions' => $religions, 'departements' => $departements, 
			'positions' => $positions
		]);
	}

	public function store(Request $request) {
		$this->validate($request, [
            'nik' => ['required', 'unique:employees'], 
            'first_name' => ['required'], 
            'gender' => ['required'], 
            'religion' => ['required'], 
            'departement_id' => ['required', 'gt:0'], 
            'position_id' => ['required', 'gt:0'], 
            'status' => ['required'], 
            'in_date' => ['required'], 
            'phone' => ['required'], 
            'email' => ['required', 'email:dns', 'unique:employees'], 
        ]);

		$message = new Employee();
		$message->nik = $request->nik;
		$message->first_name = $request->first_name;
		$message->last_name = $request->last_name;
		$message->born_place = $request->born_place;
		$message->born_date = $request->born_date;
		$message->gender = $request->gender;
		$message->religion = $request->religion;
		$message->phone = $request->phone;
		$message->email = $request->email;
		$message->in_date = $request->in_date;
		$message->out_date = $request->out_date;
		$message->departement_id = $request->departement_id;
		$message->position_id = $request->position_id;
		$message->status = $request->status;
		$message->creator = 'admin';
		$message->editor = 'admin';
		$message->save();

		$request->session()->flash('success', 'Data Employee has been added successfully');
		return redirect()->route('employee.index');
	}

	public function show(Employee $employee) {
		$status = [1 => 'Active', 'Inactive'];
		$genders = [1 => 'Male', 'Female'];
		$religions = [1 => 'Islam', 'Kristen', 'Hindu', 'Budha', 'Other'];
		$departements = Departement::where('status', 1)->orderBy('name')->pluck('name', 'id');
		$positions = Position::where('status', 1)->orderBy('name')->pluck('name', 'id');

		return view('pages.employees.show', [
			'active' => 'employees', 'status' => $status, 'employee' => $employee, 'genders' => $genders, 'religions' => $religions, 'departements' => $departements, 
			'positions' => $positions
		]);
	}

	public function edit(Employee $employee) {
		$status = [1 => 'Active', 'Inactive'];
		$genders = [1 => 'Male', 'Female'];
		$religions = [1 => 'Islam', 'Kristen', 'Hindu', 'Budha', 'Other'];
		$departements = Departement::where('status', 1)->orderBy('name')->pluck('name', 'id');
		$positions = Position::where('status', 1)->orderBy('name')->pluck('name', 'id');

		return view('pages.employees.edit', [
			'active' => 'employees', 'status' => $status, 'employee' => $employee, 'genders' => $genders, 'religions' => $religions, 'departements' => $departements, 
			'positions' => $positions
		]);
	}

	public function update(Request $request, Employee $employee) {
		$this->validate($request, [
            'nik' => ['required', 'unique:employees,nik,'. $employee->id], 
            'first_name' => ['required'], 
            'gender' => ['required'], 
            'religion' => ['required'], 
            'departement_id' => ['required', 'gt:0'], 
            'position_id' => ['required', 'gt:0'], 
            'status' => ['required'], 
            'in_date' => ['required'], 
            'phone' => ['required'], 
            'email' => ['required', 'email:dns', 'unique:employees,email,'. $employee->id], 
        ]);

		$message = Employee::findOrFail($employee->id);
		$message->nik = $request->nik;
		$message->first_name = $request->first_name;
		$message->last_name = $request->last_name;
		$message->born_place = $request->born_place;
		$message->born_date = $request->born_date;
		$message->gender = $request->gender;
		$message->religion = $request->religion;
		$message->phone = $request->phone;
		$message->email = $request->email;
		$message->in_date = $request->in_date;
		$message->out_date = $request->out_date;
		$message->departement_id = $request->departement_id;
		$message->position_id = $request->position_id;
		$message->status = $request->status;
		$message->editor = 'admin';
		$message->save();

		$request->session()->flash('success', 'Data Employee has been updated successfully');
		return redirect()->route('employee.index');
	}
}
