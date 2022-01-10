<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<div class="container-fluid">
		<button type="button" id="sidebarCollapse" class="btn btn-success">
			<i class="fas fa-align-left"></i>
		</button>
		<div class="collapse navbar-collapse" id="navbarScroll">
			<ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
					
			</ul>
			<div class="dropdown ms-auto">
				<a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
				  	<img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
				</a>
				<ul class="dropdown-menu dropdown-menu-lg-end" aria-labelledby="dropdownUser1">
					<li><a class="dropdown-item" href="javascript:void(0)">Welcome, {{ auth()->user()->username }}</a></li>
					<li><hr class="dropdown-divider"></li>
					<li>
						<form action="/logout" method="post">
							@csrf
							<button type="submit" class="dropdown-item">Logout</button>
						</form>
					</li>
				</ul>
			</div>
		</div>
	</div>
</nav>