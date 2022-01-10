@extends('layouts.main')

@section('contents')

	<h2>Employees</h2>
	<br>
	<div class="card mb-3">
		<div class="card-header text-white bg-success">
			<div class="row">
				<div class="col-auto me-auto pt-1">List Employees</div>
				<div class="col-auto">
					<a href="{{ route('employee.create') }}" class="btn btn-sm btn-outline-light" data-bs-toggle="tooltip" data-bs-placement="left" title="Add New Employee"><i class="fas fa-plus-square"></i></a>
				</div>
			</div>
		</div>
		<div class="card-body">
			@if (count($employees))
				<table class="table table-sm table-striped table-hover">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">NIK</th>
							<th scope="col">Full Name</th>
							<th scope="col">Gender</th>
							<th scope="col">Departement</th>
							<th scope="col">Position</th>
							<th scope="col">Status</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($employees as $key => $item)
							<tr>
								<th scope="row">{{ $employees->firstItem() + $key }}</th>
								<td>{{ $item->nik }}</td>
								<td>{{ $item->first_name .' '. $item->last_name }}</td>
								<td>{{ $genders[$item->gender] }}</td>
								<td>{{ $item->departement->name }}</td>
								<td>{{ $item->position->name }}</td>
								<td>
									@if ($item->status == 1)
										<span class="badge bg-success">Active</span>
									@else
										<span class="badge bg-danger">Inactive</span>
									@endif
								</td>
								<td>
									<a href="{{ route('employee.edit', [$item->id]) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> </a>
									<a href="{{ route('employee.show', [$item->id]) }}" class="btn btn-sm btn-primary"><i class="fas fa-search"></i> </a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>

				<div class="d-flex justify-content-end">
					{{ $employees->links() }}
				</div>
			@else
				Data Not Found!
			@endif
			
		</div>
	</div>

@endsection