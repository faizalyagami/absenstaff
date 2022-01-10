@extends('layouts.main')

@section('contents')

	<h2>Daily Activities</h2>
	<br>
	<div class="card mb-3">
		<div class="card-header text-white bg-success">
			Add New Activity
		</div>
		<div class="card-body">
			<form action="{{ route('daily-activity.store') }}" method="post" name="activity-form" id="activity-form" enctype="multipart/form-data">
				@csrf
				<div class="mb-3">
					<label for="name" class="form-label">Title</label>
					<input type="text" value="{{ old('name') }}" class="form-control form-control-sm @error('name') is-invalid @enderror" id="name" name="name" autocomplete="off">
					@error('name')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
					@enderror
				</div>
				
				<div class="mb-3">
					<label for="employee_id" class="form-label">Employee</label>
					<select class="form-select form-select-sm  @error('employee_id') is-invalid @enderror" name="employee_id" aria-label=".form-select-sm example">
						<option value="0" {{ old('employee_id') ? '' : 'selected' }}>Please select Employee</option>
						@foreach ($employees as $key => $item)
							<option value="{{ $key }}" {{ old('employee_id') == $key ? 'selected' : '' }}>{{ $item }}</option>
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
					<textarea class="form-control form-control-sm @error('description') is-invalid @enderror" name="description" id="description" rows="3">{{ old('description') }}</textarea>
					@error('description')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
					@enderror
				</div>

				<div class="mb-3">
					<label for="attachments" class="form-label">Attachments</label>
					<input class="form-control" type="file" name="attachments[]" id="attachments" multiple>
				</div>

				<div class="text-right float-end">
					<button type="submit" class="btn btn-success">Submit</button>
					<a href="{{ route('position.index') }}" class="btn btn-primary">Cancel</a>
				</div>
			</form>
		</div>
	</div>

@endsection