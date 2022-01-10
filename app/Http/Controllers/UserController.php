<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index() {
		$levels = ['Super Admin', 'Admin', 'Editor', 'User', 'Moderator'];

		$users = User::with(['employee'])
			->orderBy('username')
			->paginate(50)
			->withQueryString();

		return view('pages.users.index', [
			'active' => 'users', 'users' => $users, 'levels' => $levels
		]);
	}

	public function create() {
		$status = [1 => 'Active', 'Inactive'];
		$levels = ['Super Admin', 'Admin', 'Editor', 'User', 'Moderator'];
		$employees = Employee::selectRaw("CONCAT(first_name, ' ', last_name) as name, id")->where('status', 1)->orderBy('name')->pluck('name', 'id');

		return view('pages.users.create', [
			'active' => 'users', 'status' => $status, 'employees' => $employees, 'levels' => $levels
		]);
	}

	public function store(Request $request) {
		$this->validate($request, [
            'username' => ['required', 'unique:users'],  
            'employee_id' => ['required', 'gt:0'], 
            'password' => ['required', 'confirmed'], 
            'level' => ['required'], 
            'status' => ['required'], 
        ]);

		$message = new User();
		$message->username = $request->username;
		$message->password = Hash::make($request->password);
		$message->employee_id = $request->employee_id;
		$message->level = $request->level;
		$message->status = $request->status;
		$message->creator = 'admin';
		$message->editor = 'admin';
		$message->save();

		$request->session()->flash('success', 'Data User has been added successfully');
		return redirect()->route('user.index');
	}

	public function show(User $user) {
		$status = [1 => 'Active', 'Inactive'];
		// $levels = ['Super Admin', 'Admin', 'Editor', 'User', 'Moderator'];
		$levels = [1 => 'Admin', 'Editor'];
		$employees = Employee::selectRaw("CONCAT(first_name, ' ', last_name) as name, id")->where('status', 1)->orderBy('name')->pluck('name', 'id');

		return view('pages.users.show', [
			'active' => 'users', 'status' => $status, 'employees' => $employees, 'levels' => $levels, 'user' => $user
		]);
	}

	public function edit(User $user) {
		$status = [1 => 'Active', 'Inactive'];
		// $levels = ['Super Admin', 'Admin', 'Editor', 'User', 'Moderator'];
		$levels = [1 => 'Admin', 'Editor'];
		$employees = Employee::selectRaw("CONCAT(first_name, ' ', last_name) as name, id")->where('status', 1)->orderBy('name')->pluck('name', 'id');

		return view('pages.users.edit', [
			'active' => 'users', 'status' => $status, 'employees' => $employees, 'levels' => $levels, 'user' => $user
		]);
	}

	public function update(Request $request, User $user) {
		$this->validate($request, [
            'username' => ['required', 'unique:users,username,'. $user->id],  
            'employee_id' => ['required', 'gt:0'], 
            'password' => ['confirmed'], 
            'level' => ['required'], 
            'status' => ['required'], 
        ]);

		$message = User::findOrFail($user->id);
		$message->username = $request->username;
		if($request->password !== null) {
			$message->password = Hash::make($request->password);
		}
		$message->employee_id = $request->employee_id;
		$message->level = $request->level;
		$message->status = $request->status;
		$message->editor = 'admin';
		$message->save();

		$request->session()->flash('success', 'Data User has been updated successfully');
		return redirect()->route('user.index');
	}
}
