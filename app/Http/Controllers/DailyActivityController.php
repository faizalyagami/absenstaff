<?php

namespace App\Http\Controllers;

use App\Models\DailyActivity;
use App\Models\DailyActivityAttachment;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DailyActivityController extends Controller
{
    public function index() {
		$activities = DailyActivity::with(['dailyActivityAttachments'])
			->when(auth()->user()->level == 3, function($q) {
				$q->where('employee_id', auth()->user()->employee_id);
			})
			->orderBy('created_at', 'desc')
			->paginate(50)
			->withQueryString();

		return view('pages.activities.index', [
			'active' => 'activities', 'activities' => $activities
		]);
	}

	public function create() {
		$employees = Employee::selectRaw("CONCAT(first_name, ' ', last_name) as name, id")->where('status', 1)->orderBy('name')->pluck('name', 'id');

		return view('pages.activities.create', [
			'active' => 'activities', 'employees' => $employees
		]);
	}

	public function store(Request $request) {
		$this->validate($request, [
            'name' => ['required', 'unique:daily_jobs'],  
            'employee_id' => ['required', 'gt:0'], 
            'description' => ['required'],  
        ]);

		DB::transaction(function() use($request) {
			$message = new DailyActivity();
			$message->name = $request->name;
			$message->employee_id = $request->employee_id;
			$message->description = $request->description;
			$message->creator = 'admin';
			$message->editor = 'admin';
			$message->save();

			foreach ($request->attachments as $key => $value) {
				$file_name = date('YmdHis') .'.'. $value->getClientOriginalExtension();
				$folder_path = public_path('uploads');
		
				$value->move($folder_path, $file_name);

				$attachment = new DailyActivityAttachment();
				$attachment->file_name = $file_name;
				$attachment->creator = 'admin';
				$attachment->editor = 'admin';
				$message->dailyActivityAttachments()->save($attachment);
			}

		});

		$request->session()->flash('success', 'Data Activities has been added successfully');
		return redirect()->route('daily-activity.index');
	}

	public function show(DailyActivity $dailyActivity) {
		$employees = Employee::selectRaw("CONCAT(first_name, ' ', last_name) as name, id")->where('status', 1)->orderBy('name')->pluck('name', 'id');

		return view('pages.activities.show', [
			'active' => 'activities', 'employees' => $employees, 'dailyActivity' => $dailyActivity
		]);
	}

	public function edit(Request $request, DailyActivity $dailyActivity) {
		if(date("Y-m-d", strtotime($dailyActivity->created_at)) !== Carbon::now()->format("Y-m-d")) {
			$request->session()->flash('success', 'You cannot edit, due to date validation.');
			return redirect()->route('daily-activity.index');
		}

		if(auth()->user()->level == 3) {
			$request->session()->flash('success', 'You cannot edit, due to date validation.');
			return redirect()->route('daily-activity.index');
		}
		$employees = Employee::selectRaw("CONCAT(first_name, ' ', last_name) as name, id")->where('status', 1)->orderBy('name')->pluck('name', 'id');

		return view('pages.activities.edit', [
			'active' => 'activities', 'employees' => $employees, 'dailyActivity' => $dailyActivity
		]);
	}

	public function update(Request $request, DailyActivity $dailyActivity) {
		$this->validate($request, [
            'name' => ['required', 'unique:daily_jobs,name,'. $dailyActivity->id],  
            'employee_id' => ['required', 'gt:0'], 
            'description' => ['required'],  
        ]);

		$message = DailyActivity::findOrFail($dailyActivity->id);
		$message->name = $request->name;
		$message->employee_id = $request->employee_id;
		$message->description = $request->description;
		$message->editor = 'admin';
		$message->save();

		$request->session()->flash('success', 'Data Activities has been updated successfully');
		return redirect()->route('daily-activity.index');
	}
}
