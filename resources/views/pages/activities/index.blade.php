@extends('layouts.main')

@section('contents')

	<h2>Daily Activities</h2>
	<br>
	<div class="card mb-3">
		<div class="card-header text-white bg-success">
			<div class="row">
				<div class="col-auto me-auto pt-1">List Daily Activities</div>
				<div class="col-auto">
					<a href="{{ route('daily-activity.create') }}" class="btn btn-sm btn-outline-light" data-bs-toggle="tooltip" data-bs-placement="left" title="Add New Activity"><i class="fas fa-plus-square"></i></a>
				</div>
			</div>
		</div>
		<div class="card-body">
			@if (count($activities))
				<table class="table table-sm table-striped table-hover">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Title</th>
							<th scope="col">Employee</th>
							<th scope="col">Created</th>
							<th scope="col">Attachments</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($activities as $key => $item)
							<tr>
								<th scope="row">{{ $activities->firstItem() + $key }}</th>
								<td>{{ $item->name }}</td>
								<td>{{ $item->employee->first_name .' '. $item->employee->last_name }}</td>
								<td>{{ $item->created_at->Format('d F Y') }}</td>
								<td>
									@if (count($item->dailyActivityAttachments))
										@foreach ($item->dailyActivityAttachments as $attach)
											<a href="/uploads/{{ $attach->file_name }}" download><span class="badge rounded-pill bg-info text-dark">{{ $attach->file_name }} </span></a>
										@endforeach
									@endif
								</td>
								<td>
									@if (date("Y-m-d", strtotime($item->created_at)) === \Carbon\Carbon::now()->format("Y-m-d"))
										@if (auth()->user()->level != 3)
											<a href="{{ route('daily-activity.edit', [$item->id]) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> </a>
										@endif
									@endif
									<a href="{{ route('daily-activity.show', [$item->id]) }}" class="btn btn-sm btn-success"><i class="fas fa-search"></i> </a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>

				<div class="d-flex justify-content-end">
					{{ $activities->links() }}
				</div>
			@else
				Data Not Found!
			@endif
			
		</div>
	</div>

@endsection