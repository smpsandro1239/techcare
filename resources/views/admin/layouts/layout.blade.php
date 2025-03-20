<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/pages-blank.html" />

	<title>@yield('admin_page_title')</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
	integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link href="{{asset('admin_asset/css/app.css')}}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	<!-- Feather Icons -->
<script src="https://cdn.jsdelivr.net/npm/feather-icons"></script>
	<style>
		/* Cor de fundo preto e texto branco para toda a página */
* {
    background-color: black !important;
    color: white !important;
}

/* Estilos específicos para a Barra Lateral */
.sidebar {
    background-color: black !important;
    color: white !important;
}

/* Links da barra lateral */
.sidebar .sidebar-link, .sidebar .sidebar-brand span, .sidebar .sidebar-header {
    color: white !important;
}

/* Estilo quando passar o mouse na barra lateral */
.sidebar .sidebar-item:hover {
    background-color: #333 !important;
}

/* Navbar (barra superior) */
.navbar {
    background-color: black !important;
    color: white !important;
}

/* Links da navbar */
.navbar .nav-link, .navbar .nav-item .nav-link {
    color: white !important;
}

/* Estilo dos links quando passar o mouse */
.navbar .nav-link:hover, .navbar .nav-item .nav-link:hover {
    color:rgb(223, 223, 223) !important; /* Alteração de cor do link ao passar o mouse */
}

.navbar .navbar-toggler-icon {
    background-color: white !important; /* Ícone de abrir a navbar em dispositivos móveis */
}

/* Conteúdo principal */
.content, .main, .wrapper {
    background-color: black !important;
    color: white !important;
}

/* Rodapé */
.footer {
    background-color: black !important;
    color: white !important;
}

/* Links e texto do rodapé */
.footer .text-muted, .footer a {
    color: white !important;
}

/* Dropdowns (menus suspensos) */
.dropdown-menu {
    background-color: black !important;
    border-color: #444 !important;
}

.dropdown-item {
    color: white !important;
}

.dropdown-item:hover {
    background-color: #333 !important;
}

/* Itens ativos na barra lateral */
.sidebar-item.active .sidebar-link {
    background-color: #444 !important; /* Fundo mais escuro para o item ativo */
}

/* Estilo de botões */
.btn-primary, .btn-warning {
    background-color:rgb(80, 79, 79) !important;
    color: white !important;
}

.btn-primary:hover, .btn-warning:hover {
    background-color:rgba(65, 61, 61, 0) !important;
    color: white !important;
}

/* Itens da lista */
.list-group-item {
    background-color: black !important;
    color: white !important;
}

.list-group-item:hover {
    background-color: #333 !important;
}

/* Mudando estilo de conteúdo CTA (Call to Action) */
.sidebar-cta-content {
    background-color: #333 !important;
    color: white !important;
}


	</style>
</head>

<body>
	<div class="wrapper">
		<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="{{route('admin')}}">
          <span class="align-middle">Admin Dashboard</span>
        </a>

				<ul class="sidebar-nav">
					<li class="sidebar-header">
						Main
					</li>

					<li class="sidebar-item{{request()->routeIs('admin')?'active':''}}">
						<a class="sidebar-link" href="{{route('admin')}}">
              <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
            </a>
					</li>

					<li class="sidebar-header">
						Category
					</li>

					<li class="sidebar-item{{request()->routeIs('category.create')?'active':''}}">
						<a class="sidebar-link" href="{{route('category.create')}}">
              <i class="align-middle" data-feather="plus"></i> <span class="align-middle">Create</span>
            </a>
					</li>

					<li class="sidebar-item{{request()->routeIs('category.manage')?'active':''}}">
						<a class="sidebar-link" href="{{route('category.manage')}}">
              <i class="align-middle" data-feather="list"></i> <span class="align-middle">Manage</span>
            </a>
					</li>

					
					<li class="sidebar-header">
						Sub Category
					</li>

					<li class="sidebar-item{{request()->routeIs('subcategory.create')?'active':''}}">
						<a class="sidebar-link" href="{{route('subcategory.create')}}">
              <i class="align-middle" data-feather="plus"></i> <span class="align-middle">Create</span>
            </a>
					</li>

					<li class="sidebar-item{{request()->routeIs('subcategory.manage')?'active':''}}">
						<a class="sidebar-link" href="{{route('subcategory.manage')}}">
              <i class="align-middle" data-feather="list"></i> <span class="align-middle">Manage</span>
            </a>
					</li>

					
					<li class="sidebar-header">
						Attribute
					</li>

					<li class="sidebar-item{{request()->routeIs('product_attribute.create')?'active':''}}">
						<a class="sidebar-link" href="{{route('product_attribute.create')}}">
              <i class="align-middle" data-feather="plus"></i> <span class="align-middle">Create</span>
            </a>
					</li>

					<li class="sidebar-item{{request()->routeIs('product_attribute.manage')?'active':''}}">
						<a class="sidebar-link" href="{{route('product_attribute.manage')}}">
              <i class="align-middle" data-feather="list"></i> <span class="align-middle">Manage</span>
            </a>
					</li>
					<li class="sidebar-header">
						Product
					</li>

					<li class="sidebar-item{{request()->routeIs('product.manage')?'active':''}}">
						<a class="sidebar-link" href="{{route('product.manage')}}">
              <i class="align-middle" data-feather="shopping-bag"></i> <span class="align-middle">Manage Product</span>
            </a>
					</li>

					<li class="sidebar-item{{request()->routeIs('product.review.manage')?'active':''}}">
						<a class="sidebar-link" href="{{route('product.review.manage')}}">
              <i class="align-middle" data-feather="star"></i> <span class="align-middle">Manage Review</span>
            </a>
					</li>
					<li class="sidebar-item">
						<a class="sidebar-link" href="pages-profile.html">
              <i class="align-middle" data-feather="user"></i> <span class="align-middle">Profile</span>
            </a>
					</li>

					<li class="sidebar-header">
						History
					</li>

					<li class="sidebar-item{{request()->routeIs('admin.cart.history')?'active':''}}">
						<a class="sidebar-link" href="{{route('admin.cart.history')}}">
              <i class="align-middle" data-feather="shopping-cart"></i> <span class="align-middle">Cart</span>
            </a>
					</li>

					<li class="sidebar-item{{request()->routeIs('admin.order.history')?'active':''}}">
						<a class="sidebar-link" href="{{route('admin.order.history')}}">
              <i class="align-middle" data-feather="list"></i> <span class="align-middle">Order</span>
            </a>
					</li>
					<li class="sidebar-item{{request()->routeIs('admin.settings')?'active':''}}">
						<a class="sidebar-link" href="{{route('admin.settings')}}">
              <i class="align-middle" data-feather="user"></i> <span class="align-middle">Settings</span>
            </a>
					</li>


					</ul>
			</div>
		</nav>

		<div class="main">
			<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle js-sidebar-toggle">
          <i class="hamburger align-self-center"></i>
        </a>

				<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align">
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
								<div class="position-relative">
									<i class="align-middle" data-feather="bell"></i>
									<span class="indicator">4</span>
								</div>
							</a>
							<div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="alertsDropdown">
								<div class="dropdown-menu-header">
									4 New Notifications
								</div>
								<div class="list-group">
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<i class="text-danger" data-feather="alert-circle"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">Update completed</div>
												<div class="text-muted small mt-1">Restart server 12 to complete the update.</div>
												<div class="text-muted small mt-1">30m ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<i class="text-warning" data-feather="bell"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">Lorem ipsum</div>
												<div class="text-muted small mt-1">Aliquam ex eros, imperdiet vulputate hendrerit et.</div>
												<div class="text-muted small mt-1">2h ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<i class="text-primary" data-feather="home"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">Login from 192.186.1.8</div>
												<div class="text-muted small mt-1">5h ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<i class="text-success" data-feather="user-plus"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">New connection</div>
												<div class="text-muted small mt-1">Christina accepted your request.</div>
												<div class="text-muted small mt-1">14h ago</div>
											</div>
										</div>
									</a>
								</div>
								<div class="dropdown-menu-footer">
									<a href="#" class="text-muted">Show all notifications</a>
								</div>
							</div>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle" href="#" id="messagesDropdown" data-bs-toggle="dropdown">
								<div class="position-relative">
									<i class="align-middle" data-feather="message-square"></i>
								</div>
							</a>
							<div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="messagesDropdown">
								<div class="dropdown-menu-header">
									<div class="position-relative">
										4 New Messages
									</div>
								</div>
								<div class="list-group">
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<img src="img/avatars/avatar-5.jpg" class="avatar img-fluid rounded-circle" alt="Vanessa Tucker">
											</div>
											<div class="col-10 ps-2">
												<div class="text-dark">Vanessa Tucker</div>
												<div class="text-muted small mt-1">Nam pretium turpis et arcu. Duis arcu tortor.</div>
												<div class="text-muted small mt-1">15m ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<img src="img/avatars/avatar-2.jpg" class="avatar img-fluid rounded-circle" alt="William Harris">
											</div>
											<div class="col-10 ps-2">
												<div class="text-dark">William Harris</div>
												<div class="text-muted small mt-1">Curabitur ligula sapien euismod vitae.</div>
												<div class="text-muted small mt-1">2h ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<img src="img/avatars/avatar-4.jpg" class="avatar img-fluid rounded-circle" alt="Christina Mason">
											</div>
											<div class="col-10 ps-2">
												<div class="text-dark">Christina Mason</div>
												<div class="text-muted small mt-1">Pellentesque auctor neque nec urna.</div>
												<div class="text-muted small mt-1">4h ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<img src="img/avatars/avatar-3.jpg" class="avatar img-fluid rounded-circle" alt="Sharon Lessman">
											</div>
											<div class="col-10 ps-2">
												<div class="text-dark">Sharon Lessman</div>
												<div class="text-muted small mt-1">Aenean tellus metus, bibendum sed, posuere ac, mattis non.</div>
												<div class="text-muted small mt-1">5h ago</div>
											</div>
										</div>
									</a>
								</div>
								<div class="dropdown-menu-footer">
									<a href="#" class="text-muted">Show all messages</a>
								</div>
							</div>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                <i class="align-middle" data-feather="settings"></i>
              </a>

							<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                <img src="img/avatars/avatar.jpg" class="avatar img-fluid rounded me-1" alt="Charles Hall" /> <span class="text-dark">Charles Hall</span>
              </a>
							<div class="dropdown-menu dropdown-menu-end">
								<a class="dropdown-item" href="pages-profile.html"><i class="align-middle me-1" data-feather="user"></i> Profile</a>
								<a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="pie-chart"></i> Analytics</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="index.html"><i class="align-middle me-1" data-feather="settings"></i> Settings & Privacy</a>
								<a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="help-circle"></i> Help Center</a>
								<div class="dropdown-divider"></div>
								<form action="{{ route('logout') }}" method="POST">
                                  @csrf
                                <input type="submit" value="Logout" class="ms-3 btn btn-warning">
                               </form>								
							</div>
						</li>
					</ul>
				</div>
			</nav>

			<main class="content">
				<div class="container-fluid p-0">

					@yield('admin_layout')

				</div>
			</main>

			<footer class="footer">
				<div class="container-fluid">
					<div class="row text-muted">
						<div class="col-6 text-start">
							<p class="mb-0">
							<a class="text-muted" target="_blank"><strong>Tech Care</strong></a> - <a class="text-muted"  target="_blank"><strong>2025</strong></a>								&copy;
							</p>
						</div>
					</div>
				</div>
			</footer>
		</div>
	</div>
	
	<!-- Botão de Home (Ícone de Casa) -->
<a href="/" class="btn btn-primary rounded-circle position-fixed bottom-0 end-0 m-3" style="font-size: 24px; background-color: #444; color: white; z-index: 999;">
    <i data-feather="home"></i> <!-- Corrigido para usar o atributo correto do Feather Icons -->
</a>

<!-- Script para garantir que os ícones sejam carregados -->
<script>
  feather.replace(); // Este comando substitui todos os elementos <i data-feather="..."> com os ícones adequados
</script>
	<script src="{{asset('admin_asset/js/app.js')}}"></scrip>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>