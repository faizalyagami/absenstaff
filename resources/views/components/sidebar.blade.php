<nav id="sidebar" class="sidebar p-3">
	<div class="sidebar-header">
		<h3>Bootstrap</h3>
	</div>

	<ul class="list-unstyled components">
		<p>Jobs</p>
		<li class="{{ $active == 'activities' ? 'active' : '' }}">
			<a href="{{ route('daily-activity.index') }}"><i class="nav-icon fas fa-clipboard-list"></i> Daily Jobs</a>
		</li>
		{{-- <li>
			<a href="#pageSubmenu" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample" aria-expanded="false" class="dropdown-toggle"><i class="nav-icon fas fa-tachometer-alt"></i> Pages</a>
			<ul class="collapse list-unstyled" id="collapseWidthExample">
				<li>
					<a href="#">Page 1</a>
				</li>
				<li>
					<a href="#">Page 2</a>
				</li>
				<li>
					<a href="#">Page 3</a>
				</li>
			</ul>
		</li> --}}
		@can('admin')
			<p>Administrations</p>
			<li class="{{ $active == 'departements' ? 'active' : '' }}">
				<a href="{{ route('departement.index') }}"><i class="nav-icon fas fa-calendar"></i> Departements</a>
			</li>
			<li class="{{ $active == 'positions' ? 'active' : '' }}">
				<a href="{{ route('position.index') }}"><i class="nav-icon fas fa-chalkboard-teacher"></i> Positions</a>
			</li>
			<li class="{{ $active == 'employees' ? 'active' : '' }}">
				<a href="{{ route('employee.index') }}"><i class="nav-icon fas fa-id-card"></i> Employees</a>
			</li>
			<li class="{{ $active == 'users' ? 'active' : '' }}">
				<a href="{{ route('user.index') }}"><i class="nav-icon fas fa-user"></i> Users</a>
			</li>
		@endcan
	</ul>

	{{-- <div class="container-fluid fixed-bottom">
		<a class="navbar-brand" href="#">@2022</a>
	</div> --}}
</nav>