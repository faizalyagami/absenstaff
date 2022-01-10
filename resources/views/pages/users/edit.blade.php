@extends('layouts.main')

@section('contents')

	<h2>Users</h2>
	<br>
	<div class="card mb-3">
		<div class="card-header text-white bg-success">
			Edit User
		</div>
		<div class="card-body">
			<form action="{{ route('user.update', [$user]) }}" method="post" name="user-form" id="user-form">
				@csrf
				<div class="mb-3">
					<label for="username" class="form-label">Username</label>
					<input type="text" value="{{ $user->username }}" name="username" class="form-control form-control-sm @error('username') is-invalid @enderror" placeholder="Username" aria-label="Username">
					@error('username')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
					@enderror
				</div>

				<div class="mb-3">
					<label for="employee_id" class="form-label">Employee</label>
					<select class="form-select form-select-sm  @error('employee_id') is-invalid @enderror" name="employee_id" aria-label=".form-select-sm example">
						<option value="0" {{ $user->employee_id ? '' : 'selected' }}>Please select Employee</option>
						@foreach ($employees as $key => $item)
							<option value="{{ $key }}" {{ $user->employee_id == $key ? 'selected' : '' }}>{{ $item }}</option>
						@endforeach
					</select>
					@error('employee_id')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
					@enderror
				</div>

				<div class="mb-3">
					<label for="password" class="form-label">Password</label>
					<input type="password" value="" name="password" class="form-control form-control-sm @error('password') is-invalid @enderror" placeholder="Password" aria-label="Password">
					@error('password')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
					@enderror
				</div>

				<div class="mb-3">
					<label for="password_confirmation" class="form-label">Confirmation Password</label>
					<input type="password" value="" name="password_confirmation" class="form-control form-control-sm @error('password_confirmation') is-invalid @enderror" placeholder="Confirmation Password" aria-label="Confirmation Password">
					@error('password_confirmation')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
					@enderror
				</div>

				<div class="mb-3">
					<label for="level" class="form-label">Level</label>
					<select class="form-select form-select-sm  @error('level') is-invalid @enderror" name="level" aria-label=".form-select-sm example">
						@foreach ($levels as $key => $item)
							<option value="{{ $key }}" {{ $user->level == $key ? 'selected' : '' }}>{{ $item }}</option>
						@endforeach
					</select>
					@error('level')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
					@enderror
				</div>

				<div class="mb-3">
					<label for="Status" class="form-label">Status</label><br>
					@foreach ($status as $key => $item)
						<div class="form-check form-check-inline">
							<input class="form-check-input" {{ $key == 1 ? 'checked' : '' }} type="radio" name="status" id="status-{{ $key }}" value="{{ $key }}">
							<label class="form-check-label" for="status-{{ $key }}">
								{{ $item }}
							</label>
						</div>
					@endforeach
				</div>
				<div class="text-right float-end">
					<button type="submit" class="btn btn-success">Submit</button>
					<a href="{{ route('user.index') }}" class="btn btn-primary">Cancel</a>
				</div>
			</form>
		</div>
	</div>

@endsection