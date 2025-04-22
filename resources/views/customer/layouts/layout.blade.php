<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin & Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />
    <link rel="canonical" href="https://demo-basic.adminkit.io/pages-blank.html" />
    <title>@yield('customer_page_title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="{{asset('admin_asset/css/app.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />    
    <script src="https://cdn.jsdelivr.net/npm/feather-icons"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.css" rel="stylesheet">

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
            color:rgb(223, 223, 223) !important;
        }

        .navbar .navbar-toggler-icon {
            background-color: white !important;
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
            display: none;
        }

        .dropdown-menu.show {
            display: block;
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

        /* Estilos para o menu responsivo */
        @media (max-width: 991.98px) {
            .nav-links {
                display: none !important;
            }
            .mobile-nav-links {
                display: block !important;
            }
        }

        @media (min-width: 992px) {
            .mobile-nav-links {
                display: none !important;
            }
        }

        /* Estilo para animação do ícone */
        .animate-spin {
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <nav id="sidebar" class="sidebar js-sidebar">
            <div class="sidebar-content js-simplebar">
                <a class="sidebar-brand" href="{{route('user.dashboard')}}">
                    <span class="align-middle">Customer Dashboard</span>
                </a>

                <ul class="sidebar-nav">
                    <li class="sidebar-header">
                        Main
                    </li>

                    <li class="sidebar-item{{request()->routeIs('dashboard')?'active':''}}">
                        <a class="sidebar-link" href="{{route('user.dashboard')}}">
                            <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-item{{request()->routeIs('user.order.history')?'active':''}}">
                        <a class="sidebar-link" href="{{route('user.order.history')}}">
                            <i class="align-middle" data-feather="clipboard"></i> <span class="align-middle">Order History</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="main">
            <!-- Nova barra de navegação superior -->
            <nav class="navbar navbar-expand navbar-light navbar-bg">
                <a class="sidebar-toggle js-sidebar-toggle">
                    <i class="hamburger align-self-center"></i>
                </a>
                <!-- Logo/Brand com ícone animado -->
                <a class="navbar-brand d-flex align-items-center" href="/">
                    <i class="fas fa-tools animate-spin me-2"></i>
                    Tech Care
                </a>
                <div class="navbar-collapse collapse">
                    <!-- Links de navegação (visíveis em desktop) -->
                    <ul class="navbar-nav nav-links">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">
                                <i class="fas fa-home me-1"></i> Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('catalogo') ? 'active' : '' }}" href="/catalogo">
                                <i class="fas fa-list me-1"></i> Catálogo
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('agendamento*') ? 'active' : '' }}" href="/agendamento">
                                <i class="fas fa-calendar-alt me-1"></i> Agendamento
                            </a>
                        </li>
                    </ul>

                    <ul class="navbar-nav ms-auto navbar-align">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ auth()->user()->profile_photo ? asset('storage/' . auth()->user()->profile_photo) : asset('images/default-profile.png') }}" alt="Foto de Perfil" class="rounded-circle" width="30" height="30" style="object-fit: cover; margin-right: 8px;">
                                <span class="ms-1">{{ auth()->user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="userDropdown">
                                <!-- Links de navegação (visíveis em mobile) -->
                                <div class="mobile-nav-links">
                                    <li><a class="dropdown-item {{ request()->is('/') ? 'active' : '' }}" href="/">
                                        <i class="fas fa-home me-1"></i> Home
                                    </a></li>
                                    <li><a class="dropdown-item {{ request()->is('catalogo') ? 'active' : '' }}" href="/catalogo">
                                        <i class="fas fa-list me-1"></i> Catálogo
                                    </a></li>
                                    <li><a class="dropdown-item {{ request()->is('agendamento*') ? 'active' : '' }}" href="/agendamento">
                                        <i class="fas fa-calendar-alt me-1"></i> Agendamento
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                </div>
                                <li><a class="dropdown-item" href="/perfil">
                                    <i class="fas fa-user-circle me-1"></i> Meu Perfil
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-1"></i> Sair
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="content">
                <div class="container-fluid p-0">
                    @yield('customer_layout')
                </div>
            </main>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-6 text-start">
                            <p class="mb-0">
                                <a class="text-muted" target="_blank"><strong>Tech Care</strong></a> - <a class="text-muted"target="_blank"><strong>2025</strong></a> &copy;
                            </p>
                        </div>
                        <div class="col-6 text-end">
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="{{asset('admin_asset/js/app.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.js"></script>
    
    <!-- Botão de Home (Ícone de Casa) -->
    <a href="/" class="btn btn-primary rounded-circle position-fixed bottom-0 end-0 m-3" style="font-size: 24px; background-color: #444; color: white; z-index: 999;">
        <i data-feather="home"></i>
    </a>

    <!-- Script para garantir que os ícones sejam carregados -->
    <script>
        feather.replace();
        
        // Controle manual do dropdown
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownToggle = document.querySelector('.dropdown-toggle');
            const dropdownMenu = document.querySelector('.dropdown-menu');
            
            if(dropdownToggle && dropdownMenu) {
                dropdownToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    // Fecha todos os outros dropdowns abertos
                    document.querySelectorAll('.dropdown-menu.show').forEach(function(openMenu) {
                        if(openMenu !== dropdownMenu) {
                            openMenu.classList.remove('show');
                        }
                    });
                    
                    // Alterna o menu atual
                    dropdownMenu.classList.toggle('show');
                });
                
                // Fecha o dropdown ao clicar fora
                document.addEventListener('click', function(e) {
                    if(!dropdownMenu.contains(e.target) {
                        dropdownMenu.classList.remove('show');
                    }
                });
            }
        });
    </script>
</body>
</html>