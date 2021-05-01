<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Web UI Kit &amp; Dashboard Template based on Bootstrap">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, web ui kit, dashboard template, admin template">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="shortcut icon" href="/img/icons/icon-48x48.png" />

    <title>@hasSection('level2') @yield('level2') | @endif Panorama</title>
	<link href="/css/app.css" rel="stylesheet">
	<link href="/admin/css/app.css" rel="stylesheet">
    @stack('css')
</head>

<body>
	<div class="wrapper">
		<nav id="sidebar" class="sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="/">
                    <img src="/img/logo-removebg-preview.png" style="width: 100%; position: relative; left: -15px;">
                </a>
                <ul class="sidebar-nav">
                    <li class="sidebar-item {{ (request()->is('dashboard')) ? 'active' : '' }}">
                        <a class="sidebar-link" href="/dashboard">
                            <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard </span>
                        </a>
                    </li>
                    <li class="sidebar-header">
                        Transaction
                    </li>
                    <li class="sidebar-item {{ (request()->is('event*')) ? 'active' : '' }}">
                        <a class="sidebar-link" href="/event">
                            <i class="align-middle" data-feather="cast"></i> <span class="align-middle">Event</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ (request()->is('rental*')) ? 'active' : '' }}">
                        <a class="sidebar-link" href="/rental">
                            <i class="align-middle" data-feather="credit-card"></i> <span class="align-middle">Rental</span>
                        </a>
                    </li>
                    <li class="sidebar-header">
                        Master
                    </li>
                    <li class="sidebar-item {{ (request()->is('equipment') || request()->is('item')) ? 'active' : '' }}">
                        <a href="#ui" data-toggle="collapse" class="sidebar-link collapsed">
                            <i class="align-middle" data-feather="briefcase"></i> <span class="align-middle">Equipment Items</span>
                        </a>
                        <ul id="ui" class="sidebar-dropdown list-unstyled collapse {{ (request()->is('equipment') || request()->is('item')) ? 'show' : '' }}" data-parent="#sidebar">
                            <li class="sidebar-item {{ (request()->is('equipment')) ? 'active' : '' }}">
                                <a class="sidebar-link" href="/equipment">Equipment</a>
                            </li>
                            <li class="sidebar-item {{ (request()->is('item')) ? 'active' : '' }}">
                                <a class="sidebar-link" href="/item">Item</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item {{ (request()->is('operator') || request()->is('vendor')) ? 'active' : '' }}">
                        <a href="#forms" data-toggle="collapse" class="sidebar-link collapsed">
                            <i class="align-middle" data-feather="check-circle"></i> <span class="align-middle">Services</span>
                        </a>
                        <ul id="forms" class="sidebar-dropdown list-unstyled collapse {{ (request()->is('operator') || request()->is('vendor')) ? 'show' : '' }}" data-parent="#sidebar">
                            <li class="sidebar-item {{ (request()->is('operator')) ? 'active' : '' }}">
                                <a class="sidebar-link" href="/operator">Operator</a>
                            </li>
                            <li class="sidebar-item {{ (request()->is('vendor')) ? 'active' : '' }}">
                                <a class="sidebar-link" href="/vendor">Vendor Event</a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item {{ (request()->is('client')) ? 'active' : '' }}">
                        <a class="sidebar-link" href="/client">
                            <i class="align-middle" data-feather="user-check"></i> <span class="align-middle">Client Rental</span>
                        </a>
                    </li>

                    <li class="sidebar-header">
                        User
                    </li>
                    <li class="sidebar-item {{ (request()->is('user')) ? 'active' : '' }}">
                        <a class="sidebar-link" href="/user">
                            <i class="align-middle" data-feather="users"></i> <span class="align-middle">User List</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ (request()->is('profile')) ? 'active' : '' }}">
                        <a class="sidebar-link" href="/profile">
                            <i class="align-middle" data-feather="user"></i> <span class="align-middle">Profile</span>
                        </a>
                    </li>
                </ul>
			    {{-- <div class="sidebar-cta">
					<div class="sidebar-cta-content">
						<strong class="d-inline-block mb-2">Help Center</strong>
						<div class="mb-3 text-sm">
							Are you need <code>help</code> ?
						</div>
						<a href="https://ariusdev.bins.co.id" target="_blank" class="btn btn-outline-primary btn-block">Contact Me</a>
					</div>
				</div> --}}
			</div>
		</nav>

		<div class="main">
			<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle d-flex">
                    <i class="hamburger align-self-center"></i>
                </a>

				{{-- <form class="form-inline d-none d-sm-inline-block mb-0">
					<div class="input-group input-group-navbar">
						<input type="text" class="form-control" placeholder="Search Transaction" aria-label="Search">
						<div class="input-group-append">
							<button class="btn" type="button">
                                <i class="align-middle" data-feather="search"></i>
                            </button>
						</div>
					</div>
				</form> --}}

				<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align">
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-toggle="dropdown">
								<div class="position-relative" style="top: 5px;">
									<i class="align-middle" data-feather="bell"></i>
									<span class="indicator">5</span>
								</div>
							</a>
							<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right py-0" aria-labelledby="alertsDropdown">
								<div class="dropdown-menu-header">
									5 Last Logs
								</div>
								<div class="list-group">
                                    @foreach (logsLastest() as $item)
                                    <a href="#" class="list-group-item">
										<div class="row no-gutters align-items-center">
											<div class="col-2">
												<i class="text-{{ $item->icon->color }}" data-feather="{{ $item->icon->data }}" style="width: 24px; height: 24px;"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">{{ $item->user->name }}</div>
												<div class="text-muted small mt-1"> {{ $item->content }} | {{ $item->method }}</div>
												<div class="text-muted small mt-1">{{ $item->created_at->diffforhumans() }}</div>
											</div>
										</div>
									</a>
                                    @endforeach
								</div>
							</div>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-toggle="dropdown">
                                <i class="align-middle" data-feather="settings"></i>
                            </a>

							<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-toggle="dropdown">
                                <img src="/img/avatars/1.jpg" class="avatar img-fluid rounded mr-1" alt="{{ auth()->user()->name }}" /> <span class="text-dark">{{ auth()->user()->name }}</span>
                            </a>
							<div class="dropdown-menu dropdown-menu-right">
								<a class="dropdown-item" href="/user"><i class="align-middle mr-1" data-feather="users"></i> Users</a>
								<a class="dropdown-item" href="/profile"><i class="align-middle mr-1" data-feather="user"></i> Profile</a>
								{{-- <div class="dropdown-divider"></div>
								<a class="dropdown-item" href="https://ariusdev.bins.co.id" target="_blank"><i class="align-middle mr-1" data-feather="help-circle"></i> Help Center</a> --}}
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="/logout"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Log out
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
							</div>
						</li>
					</ul>
				</div>
			</nav>

			<main class="content">
				<div class="container-fluid p-0">
					<div class="row mb-2 mb-xl-3">
						<div class="col-auto d-none d-sm-block">
							<h3>@yield('title')</h3>
						</div>
						<div class="col-auto ml-auto text-right mt-n1">
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb bg-transparent p-0 mt-1 mb-0">
                                    @hasSection('level1')
									<li class="breadcrumb-item"><a href="#" style="color: #e88507;">@yield('level1')</a></li>
                                    @endif
                                    @hasSection('level2')
									<li class="breadcrumb-item active" aria-current="page">@yield('level2')</li>
                                    @endif
								</ol>
							</nav>
						</div>
					</div>

					@yield('content')


				</div>
			</main>

			<footer class="footer">
				<div class="container-fluid">
					<div class="row text-muted">
						<div class="col-6 text-left">
							<p class="mb-0">
								<a href="https://ariusdev.com/" class="text-muted" target="_blank"><strong>Powered by Arius DEV</strong></a>
							</p>
						</div>
						<div class="col-6 text-right">
							<ul class="list-inline">
								<li class="list-inline-item">
                                    <a class="text-muted" href="#">&copy; 2021 | Panorama </a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</footer>
		</div>
	</div>

	{{-- <script src="js/vendor.js"></script> --}}
	<script src="admin/js/app.js"></script>
	<script src="/js/app.js"></script>
    <script>
        $('.select2').select2();
    </script>
    @stack('scripts')

</body>

</html>
