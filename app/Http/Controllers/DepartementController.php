<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use Illuminate\Http\Request;

class DepartementController extends Controller
{
    public function index() {
		$departements = Departement::orderBy('name')
			->paginate(50)
			->withQueryString();

		return view('pages.departements.index', [
			'active' => 'departements', 
			'departements' => $departements
		]);
	}

	public function create() {
		$status = [1 => 'Active', 'Inactive'];
		return view('pages.departements.create', [
			'active' => 'departements', 'status' => $status
		]);
	}

	public function store(Request $request) {
		$this->validate($request, [
            'name' => ['required', 'unique:departements'], 
            'status' => ['required'], 
        ]);

		$message = new Departement();
		$message->name = $request->name;
		$message->status = $request->status;
		$message->creator = 'admin';
		$message->editor = 'admin';
		$message->save();

		
		return redirect()->route('departement.index');
	}

	public function show(Departement $departement) {
		return view('pages.departements.show');
	}

	public function edit(Departement $departement) {
		$status = [1 => 'Active', 'Inactive'];

		return view('pages.departements.edit', [
			'active' => 'departements', 'status' => $status, 'departement' => $departement
		]);
	}

	public function update(Request $request, Departement $departement) {
		$this->validate($request, [
            'name' => ['required', 'unique:departements,name,'. $request->id], 
            'status' => ['required'], 
        ]);

		$message = Departement::findOrFail($departement->id);
		$message->name = $request->name;
		$message->status = $request->status;
		$message->editor = 'admin';
		$message->save();

		$request->session()->flash('success', 'Data Departement has been updated successfully');
		return redirect()->route('departement.index');
	}
}
