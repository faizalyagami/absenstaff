@extends('layouts.main')

@section('contents')

	<h2>Departements</h2>
	<br>
	<div class="card mb-3">
		<div class="card-header text-white bg-success">
			Edit Departement
		</div>
		<div class="card-body">
			<form action="{{ route('departement.update', [$departement]) }}" method="post" name="departement-form" id="departement-form">
				@csrf
				<input type="hidden" name="id" value="{{ $departement->id }}">
				<div class="mb-3">
					<label for="name" class="form-label">Name</label>
					<input type="text" value="{{ $departement->name }}" class="form-control form-control-sm @error('name') is-invalid @enderror" id="name" name="name" autocomplete="off">
					@error('name')
						<div class="invalid-feedback">
							{{ $message }}
						</div>
					@enderror
				</div>

				<div class="mb-3">
					<label for="Status" class="form-label">Status</label><br>
					@foreach ($status as $key => $item)
						<div class="form-check form-check-inline">
							<input class="form-check-input" {{ $key == $departement->status ? 'checked' : '' }} type="radio" name="status" id="status-{{ $key }}" value="{{ $key }}">
							<label class="form-check-label" for="status-{{ $key }}">
								{{ $item }}
							</label>
						</div>
					@endforeach
				</div>
				<div class="text-right float-end">
					<button type="submit" class="btn btn-success">Submit</button>
					<a href="{{ route('departement.index') }}" class="btn btn-primary">Cancel</a>
				</div>
			</form>
		</div>
	</div>

@endsection