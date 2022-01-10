@extends('layouts.main')

@section('contents')

	<h2>Users</h2>
	<br>
	<div class="card mb-3">
		<div class="card-header text-white bg-success">
			<div class="row">
				<div class="col-auto me-auto pt-1">List Users</div>
				<div class="col-auto">
					<a href="{{ route('user.create') }}" class="btn btn-sm btn-outline-light" data-bs-toggle="tooltip" data-bs-placement="left" title="Add New User"><i class="fas fa-plus-square"></i></a>
				</div>
			</div>
		</div>
		<div class="card-body">
			@if (count($users))
				<table class="table table-sm table-striped table-hover">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Username</th>
							<th scope="col">Employee</th>
							<th scope="col">Level</th>
							<th scope="col">Status</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($users as $key => $item)
							<tr>
								<th scope="row">{{ $users->firstItem() + $key }}</th>
								<td>{{ $item->username }}</td>
								<td>{{ $item->employee ? $item->employee->first_name .' '. $item->employee->last_name : '' }}</td>
								<td>{{ $levels[$item->level] }}</td>
								<td>
									@if ($item->status == 1)
										<span class="badge bg-success">Active</span>
									@else
										<span class="badge bg-danger">Inactive</span>
									@endif
								</td>
								<td>
									<a href="{{ route('user.edit', [$item->id]) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> </a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>

				<div class="d-flex justify-content-end">
					{{ $users->links() }}
				</div>
			@else
				Data Not Found!
			@endif
			
		</div>
	</div>

@endsection