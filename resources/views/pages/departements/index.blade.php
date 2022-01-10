@extends('layouts.main')

@section('contents')

	<h2>Departements</h2>
	<br>
	<div class="card mb-3">
		<div class="card-header text-white bg-success">
			<div class="row">
				<div class="col-auto me-auto pt-1">List Departements</div>
				<div class="col-auto">
					<a href="{{ route('departement.create') }}" class="btn btn-sm btn-outline-light" data-bs-toggle="tooltip" data-bs-placement="left" title="Add New Departement"><i class="fas fa-plus-square"></i></a>
				</div>
			</div>
		</div>
		<div class="card-body">
			@if (count($departements))
				<table class="table table-sm table-striped table-hover">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Name</th>
							<th scope="col">Created</th>
							<th scope="col">Status</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($departements as $key => $item)
							<tr>
								<th scope="row">{{ $departements->firstItem() + $key }}</th>
								<td>{{ $item->name }}</td>
								<td>{{ $item->created_at->Format('d F Y') }}</td>
								<td>
									@if ($item->status == 1)
										<span class="badge bg-success">Active</span>
									@else
										<span class="badge bg-danger">Inactive</span>
									@endif
								</td>
								<td>
									<a href="{{ route('departement.edit', [$item->id]) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> </a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>

				<div class="d-flex justify-content-end">
					{{ $departements->links() }}
				</div>
			@else
				Data Not Found!
			@endif
			
		</div>
	</div>

@endsection