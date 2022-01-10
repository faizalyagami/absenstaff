@extends('layouts.main')

@section('contents')

	<h2>Employees</h2>
	<br>
	<div class="card mb-3">
		<div class="card-header text-white bg-success">
			Edit Employee
		</div>
		<div class="card-body">
			<form action="{{ route('employee.update', [$employee]) }}" method="post" name="employee-form" id="employee-form">
				@csrf
				<div class="mb-3">
					<label for="nik" class="form-label">NIK</label>
					<input type="text" value="{{ $employee->nik }}" name="nik" class="form-control form-control-sm @error('nik') is-invalid @enderror" placeholder="NIK" aria-label="NIK">
					@error('nik')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
					@enderror
				</div>

				<div class="mb-3">
					<div class="row">
						<div class="col">
							<label for="first_name" class="form-label">First Name</label>
							<input type="text" name="first_name" value="{{ $employee->first_name }}" class="form-control form-control-sm @error('first_name') is-invalid @enderror" placeholder="First name" aria-label="First name">
							@error('first_name')
								<div class="invalid-feedback">
									{{ $message }}
								</div>
							@enderror
						</div>
						<div class="col">
							<label for="last_name" class="form-label">Last Name</label>
							<input type="text" name="last_name" value="{{ $employee->last_name }}" class="form-control form-control-sm @error('last_name') is-invalid @enderror" placeholder="Last name" aria-label="Last name">
							@error('last_name')
								<div class="invalid-feedback">
									{{ $message }}
								</div>
							@enderror
						</div>
					</div>
				</div>

				<div class="mb-3">
					<div class="row">
						<div class="col">
							<label for="born_place" class="form-label">Place Of Birth</label>
							<input type="text" name="born_place" value="{{ $employee->born_place }}" class="form-control form-control-sm @error('born_place') is-invalid @enderror" placeholder="Place Of Birth" aria-label="Place Of Birth">
							@error('born_place')
								<div class="invalid-feedback">
									{{ $message }}
								</div>
							@enderror
						</div>
						<div class="col">
							<label for="born_date" class="form-label">Date Of Birth {{ date("m/d/Y", strtotime($employee->born_date)) }}</label>
							<input type="date" name="born_date" value="{{ date("Y-m-d", strtotime($employee->born_date)) }}" class="form-control form-control-sm @error('born_date') is-invalid @enderror" placeholder="Date Of Birth" aria-label="Date Of Birth">
							@error('born_date')
								<div class="invalid-feedback">
									{{ $message }}
								</div>
							@enderror
						</div>
					</div>
				</div>

				<div class="mb-3">
					<label for="gender" class="form-label">Gender</label><br>
					@foreach ($genders as $key => $item)
						<div class="form-check form-check-inline">
							<input class="form-check-input" {{ $key == $employee->gender ? 'checked' : '' }} type="radio" name="gender" id="gender-{{ $key }}" value="{{ $key }}">
							<label class="form-check-label" for="gender-{{ $key }}">
								{{ $item }}
							</label>
						</div>
					@endforeach
				</div>

				<div class="mb-3">
					<label for="religion" class="form-label">Religion</label>
					<select class="form-select form-select-sm  @error('religion') is-invalid @enderror" name="religion" aria-label=".form-select-sm example">
						@foreach ($religions as $key => $item)
							<option value="{{ $key }}" {{ $key == $employee->religion ? 'selected' : '' }}>{{ $item }}</option>
						@endforeach
					</select>
					@error('religion')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
					@enderror
				</div>

				<div class="mb-3">
					<div class="row">
						<div class="col">
							<label for="phone" class="form-label">Phone</label>
							<input type="text" name="phone" value="{{ $employee->phone }}" class="form-control form-control-sm @error('phone') is-invalid @enderror" placeholder="Phone" aria-label="Phone">
							@error('phone')
								<div class="invalid-feedback">
									{{ $message }}
								</div>
							@enderror
						</div>
						<div class="col">
							<label for="email" class="form-label">Email</label>
							<input type="email" name="email" value="{{ $employee->email }}" class="form-control form-control-sm @error('email') is-invalid @enderror" placeholder="Email" aria-label="Email">
							@error('email')
								<div class="invalid-feedback">
									{{ $message }}
								</div>
							@enderror
						</div>
					</div>
				</div>

				<div class="mb-3">
					<div class="row">
						<div class="col">
							<label for="in_date" class="form-label">Date Join</label>
							<input type="date" name="in_date" value="{{ date("Y-m-d", strtotime($employee->in_date)) }}" class="form-control form-control-sm @error('in_date') is-invalid @enderror" placeholder="Date Join" aria-label="Date Join">
							@error('in_date')
								<div class="invalid-feedback">
									{{ $message }}
								</div>
							@enderror
						</div>
						<div class="col">
							<label for="end_date" class="form-label">Date Resign</label>
							<input type="date" name="end_date" value="{{ $employee->end_date !== null ? date("Y-m-d", strtotime($employee->end_date)) : '' }}" class="form-control form-control-sm @error('end_date') is-invalid @enderror" placeholder="Date Resign" aria-label="Date Resign">
							@error('end_date')
								<div class="invalid-feedback">
									{{ $message }}
								</div>
							@enderror
						</div>
					</div>
				</div>

				<div class="mb-3">
					<label for="departement_id" class="form-label">Departement</label>
					<select class="form-select form-select-sm  @error('departement_id') is-invalid @enderror" name="departement_id" aria-label=".form-select-sm example">
						<option value="0">Please select departement</option>
						@foreach ($departements as $key => $item)
							<option value="{{ $key }}" {{ $employee->departement_id == $key ? 'selected' : '' }}>{{ $item }}</option>
						@endforeach
					</select>
					@error('departement_id')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
					@enderror
				</div>

				<div class="mb-3">
					<label for="position_id" class="form-label">Position</label>
					<select class="form-select form-select-sm  @error('position_id') is-invalid @enderror" name="position_id" aria-label=".form-select-sm example">
						<option value="0">Please select position</option>
						@foreach ($positions as $key => $item)
							<option value="{{ $key }}" {{ $employee->position_id == $key ? 'selected' : '' }}>{{ $item }}</option>
						@endforeach
					</select>
					@error('position_id')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
					@enderror
				</div>

				<div class="mb-3">
					<label for="Status" class="form-label">Status</label><br>
					@foreach ($status as $key => $item)
						<div class="form-check form-check-inline">
							<input class="form-check-input" {{ $key == $employee->status ? 'checked' : '' }} type="radio" name="status" id="status-{{ $key }}" value="{{ $key }}">
							<label class="form-check-label" for="status-{{ $key }}">
								{{ $item }}
							</label>
						</div>
					@endforeach
				</div>
				<div class="text-right float-end">
					<button type="submit" class="btn btn-success">Submit</button>
					<a href="{{ route('employee.index') }}" class="btn btn-primary">Cancel</a>
				</div>
			</form>
		</div>
	</div>

@endsection