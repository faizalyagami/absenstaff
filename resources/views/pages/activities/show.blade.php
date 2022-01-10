@extends('layouts.main')

@section('contents')

	<h2>Daily Activities</h2>
	<br>
	<div class="card mb-3">
		<div class="card-header text-white bg-success">
			Edit Activity
		</div>
		<div class="card-body">
			<form action="" method="post" name="activity-form" id="activity-form">
				@csrf
				<div class="mb-3">
					<label for="name" class="form-label">Title</label>
					<input readonly type="text" value="{{ $dailyActivity->name }}" class="form-control form-control-sm @error('name') is-invalid @enderror" id="name" name="name" autocomplete="off">
					@error('name')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
					@enderror
				</div>
				
				<div class="mb-3">
					<label for="employee_id" class="form-label">Employee</label>
					<select disabled class="form-select form-select-sm  @error('employee_id') is-invalid @enderror" name="employee_id" aria-label=".form-select-sm example">
						<option value="0">Please select Employee</option>
						@foreach ($employees as $key => $item)
							<option value="{{ $key }}" {{ $dailyActivity->employee_id == $key ? 'selected' : '' }}>{{ $item }}</option>
						@endforeach
					</select>
					@error('employee_id')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
					@enderror
				</div>

				<div class="mb-3">
					<label for="description" class="form-label">Description</label>
					<textarea readonly class="form-control form-control-sm @error('description') is-invalid @enderror" name="description" id="description" rows="3">{{ $dailyActivity->description }}</textarea>
					@error('description')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
					@enderror
				</div>

				<div class="mb-3">
					<label for="attachments" class="form-label">Attachments</label>
					<br>
					@if (count($dailyActivity->dailyActivityAttachments))
						@foreach ($dailyActivity->dailyActivityAttachments as $attach)
							<button type="button" class="btn btn-sm btn-primary">
								{{ $attach->file_name }} <span class="badge bg-secondary"><a href="/uploads/{{ $attach->file_name }}" download><i class="fas fa-download"></i></a></span>
							</button>
						@endforeach
					@endif
				</div>

				<div class="text-right float-end">
					@if (date("Y-m-d", strtotime($dailyActivity->created_at)) === \Carbon\Carbon::now()->format("Y-m-d")) --}}
						@if (auth()->user()->level != 3)
							<a href="{{ route('daily-activity.edit', [$dailyActivity->id]) }}" class="btn btn-primary"><i class="fas fa-edit"></i>Edit </a>
						@endif
					@endif
					<a href="{{ route('daily-activity.index') }}" class="btn btn-primary">Back</a>
				</div>
			</form>
		</div>
	</div>

@endsection