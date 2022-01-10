<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index() {
		$positions = Position::orderBy('name')
			->paginate(50)
			->withQueryString();

		return view('pages.positions.index', [
			'active' => 'positions', 
			'positions' => $positions
		]);
	}

	public function create() {
		$status = [1 => 'Active', 'Inactive'];
		return view('pages.positions.create', [
			'active' => 'positions', 'status' => $status
		]);
	}

	public function store(Request $request) {
		$this->validate($request, [
            'name' => ['required', 'unique:positions'], 
            'status' => ['required'], 
        ]);

		$message = new Position();
		$message->name = $request->name;
		$message->status = $request->status;
		$message->creator = 'admin';
		$message->editor = 'admin';
		$message->save();

		$request->session()->flash('success', 'Data Position has been added successfully');
		return redirect()->route('position.index');
	}

	public function show(Position $position) {
		return view('pages.positions.show');
	}

	public function edit(Position $position) {
		$status = [1 => 'Active', 'Inactive'];

		return view('pages.positions.edit', [
			'active' => 'positions', 'status' => $status, 'position' => $position
		]);
	}

	public function update(Request $request, Position $position) {
		$this->validate($request, [
            'name' => ['required', 'unique:positions,name,'. $request->id], 
            'status' => ['required'], 
        ]);

		$message = Position::findOrFail($position->id);
		$message->name = $request->name;
		$message->status = $request->status;
		$message->editor = 'admin';
		$message->save();

		$request->session()->flash('success', 'Data Position has been updated successfully');
		return redirect()->route('position.index');
	}
}
