<!doctype html>
<html lang="en">
    <head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Bootstrap CSS -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		  
		<!-- Custom styles for this template -->
		<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

		<!-- Font Awesome JS -->
		<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
		<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

		<title>Hello, world!</title>
    </head>
    <body>
		<div class="row justify-content-center">
			<div class="col-md-5">
				<main class="form-signin">
					<h1 class="h3 mb-3 fw-normal text-center">Please Login</h1>
					<form action="/login" method="post" name="formLogin" id="form-login">
						@csrf
						<div class="form-floating">
							<input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="..." autofocus>
							<label for="username">Username</label>
						</div>
						<div class="form-floating">
							<input type="password" class="form-control" id="password" name="password" placeholder="Password">
							<label for="password">Password</label>
						</div>
						<button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>
						<p class="mt-5 mb-3 text-muted text-center">© 2021–2022</p>
					</form>
				</main>
			</div>
		</div>

		{{-- Notification here --}}
		<div id="global-notificartion">
			@include('components.notifications')
		</div>

		<!-- jQuery CDN - Slim version (=without AJAX) -->
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<!-- Popper.JS -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
		<script src="{{ asset('assets/js/sidebars.js') }}"></script>

    </body>
</html>