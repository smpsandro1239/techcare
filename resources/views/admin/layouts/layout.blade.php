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
    <link href="{{ asset('admin_asset/css/app.css') }}" rel="stylesheet">
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
        .sidebar .sidebar-link,
        .sidebar .sidebar-brand span,
        .sidebar .sidebar-header {
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
        .navbar .nav-link,
        .navbar .nav-item .nav-link {
            color: white !important;
        }

        /* Estilo dos links quando passar o mouse */
        .navbar .nav-link:hover,
        .navbar .nav-item .nav-link:hover {
            color: rgb(223, 223, 223) !important;
        }

        .navbar .navbar-toggler-icon {
            background-color: white !important;
        }

        /* Conteúdo principal */
        .content,
        .main,
        .wrapper {
            background-color: black !important;
            color: white !important;
        }

        /* Rodapé */
        .footer {
            background-color: black !important;
            color: white !important;
        }

        /* Links e texto do rodapé */
        .footer .text-muted,
        .footer a {
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
            background-color: #444 !important;
        }

        /* Estilo de botões */
        .btn-primary,
        .btn-warning {
            background-color: rgb(80, 79, 79) !important;
            color: white !important;
        }

        .btn-primary:hover,
        .btn-warning:hover {
            background-color: rgba(65, 61, 61, 0) !important;
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
                <a class="sidebar-brand" href="{{ route('admin.dashboard') }}">
                    <span class="align-middle">Admin Dashboard</span>
                </a>

                <ul class="sidebar-nav">
                    <li class="sidebar-header">
                        Main
                    </li>

                    <li class="sidebar-item {{ request()->routeIs('admin') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('admin.dashboard') }}">
                            <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                        </a>
                    </li>

                    <li class="sidebar-header">
                        Category
                    </li>

                    <li class="sidebar-item {{ request()->routeIs('category.create') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('admin.category.create') }}">
                            <i class="align-middle" data-feather="plus"></i> <span class="align-middle">Create</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{ request()->routeIs('category.manage') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('admin.category.manage') }}">
                            <i class="align-middle" data-feather="list"></i> <span class="align-middle">Manage</span>
                        </a>
                    </li>

                    <li class="sidebar-header">
                        Sub Category
                    </li>

                    <li class="sidebar-item {{ request()->routeIs('subcategory.create') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('admin.subcategory.create') }}">
                            <i class="align-middle" data-feather="plus"></i> <span class="align-middle">Create</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{ request()->routeIs('subcategory.manage') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('admin.subcategory.manage') }}">
                            <i class="align-middle" data-feather="list"></i> <span class="align-middle">Manage</span>
                        </a>
                    </li>

                    <li class="sidebar-header">
                        Product
                    </li>

                    <li class="sidebar-item {{ request()->routeIs('admin.product.create') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('admin.product.create') }}">
                            <i class="align-middle" data-feather="shopping-bag"></i> <span class="align-middle">Create Product</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{ request()->routeIs('admin.product.manage') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('admin.product.manage') }}">
                            <i class="align-middle" data-feather="shopping-bag"></i> <span class="align-middle">Manage Products</span>
                        </a>
                    </li>

                    <li class="sidebar-header">
                        History
                    </li>
                    <li class="sidebar-item {{ request()->routeIs('admin.order.history') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('admin.order.history') }}">
                            <i class="align-middle" data-feather="list"></i> <span class="align-middle">Order</span>
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
                            <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
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
                                <a class="text-muted" target="_blank"><strong>Tech Care</strong></a> - <a class="text-muted" target="_blank"><strong>2025</strong></a> &copy;
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
        feather.replace();
    </script>

    <script src="{{ asset('admin_asset/js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
