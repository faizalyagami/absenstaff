@extends('layouts.main')

@section('contents')
	<div class="container-fluid">
		<h2>Dasboard</h2>
		<br>
		<div class="card mb-3">
			<div class="card-header text-white bg-success">
				<div class="row">
					<div class="col-auto me-auto pt-1">Featured</div>
					<div class="col-auto">
						<button type="button" class="btn btn-sm btn-outline-light" data-bs-toggle="tooltip" data-bs-placement="left" title="Add New"><i class="fas fa-plus-square"></i></button>
						<a href="/" class="btn btn-sm btn-outline-light" data-bs-toggle="tooltip" data-bs-placement="left" title="Add New"><i class="fas fa-plus-square"></i></a>
					</div>
				</div>
			</div>
			<div class="card-body">
				<form class="needs-validation was-validated" novalidate>
					<div class="mb-3">
						<div class="row">
							<div class="col">
								<label for="exampleInputEmail1" class="form-label">First Name</label>
							 	<input type="text" class="form-control" placeholder="First name" aria-label="First name">
							</div>
							<div class="col">
								<label for="exampleInputEmail1" class="form-label">Last Name</label>
							  	<input type="text" class="form-control" placeholder="Last name" aria-label="Last name">
							</div>
						</div>
					</div>
					<div class="mb-3">
						<label for="exampleInputEmail1" class="form-label">Email address</label>
						<input type="email" class="form-control form-control-sm" id="exampleInputEmail1" aria-describedby="emailHelp" required>
						<div class="invalid-feedback">
							Please enter a message in the textarea.
						</div>
					</div>
					<div class="mb-3">
						<label for="exampleInputPassword1" class="form-label">Password</label>
						<input type="password" class="form-control form-control-sm" id="exampleInputPassword1">
					</div>
					<div class="mb-3 form-check">
						<input type="checkbox" class="form-check-input" id="exampleCheck1">
						<label class="form-check-label" for="exampleCheck1">Check me out</label>
					</div>
					<div class="mb-3">
						<label for="exampleInputPassword1" class="form-label">Select</label>
						<select class="form-select form-select-sm" aria-label=".form-select-sm example">
							<option selected>Open this select menu</option>
							<option value="1">One</option>
							<option value="2">Two</option>
							<option value="3">Three</option>
						</select>
					</div>
					<div class="mb-3">
						<label for="exampleInputPassword1" class="form-label">Radio</label><br>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
							<label class="form-check-label" for="flexRadioDefault1">
								Default radio
							</label>
						  </div>
						  <div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
							<label class="form-check-label" for="flexRadioDefault2">
								Default checked radio
							</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3" value="option3" disabled>
							<label class="form-check-label" for="exampleRadios3">
							  Disabled radio
							</label>
						</div>
					</div>
					<div class="mb-3">
						<label for="exampleFormControlTextarea1" class="form-label">Example textarea</label>
						<textarea class="form-control form-control-sm" id="exampleFormControlTextarea1" rows="3"></textarea>
					</div>
					<button type="submit" class="btn btn-primary">Submit</button>
				</form>
				
			</div>
		</div>
	</div>
@endsection