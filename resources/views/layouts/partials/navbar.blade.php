<!-- resources/views/layouts/partials/navbar.blade.php -->
<nav class="navbar navbar-expand-lg navbar-dark bg-gradient-custom fixed-top shadow-lg">
    <div class="container-fluid">
        <!-- Logo/Brand com ícone animado -->
        <a class="navbar-brand d-flex align-items-center" href="/">
            <i class="fas fa-tools animate-spin me-2"></i>
            Tech Care
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <!-- Barra de Pesquisa -->
                <li class="nav-item">
                    <form class="d-flex" action="/product/procurar" method="GET">
                        <input class="form-control me-2 search-input" type="search" placeholder="Pesquisar produtos..." name="query">
                        <button class="btn btn-outline-light" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <!-- Links da navbar -->
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

                @auth
                    <!-- Dropdown de Usuário -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ auth()->user()->profile_photo ? asset('storage/' . auth()->user()->profile_photo) : asset('images/default-profile.png') }}"
                                 alt="Foto de Perfil" class="rounded-circle" width="30" height="30"
                                 style="object-fit: cover; margin-right: 8px;">
                            <span class="ms-1">{{ auth()->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark">
                        <li>
    <a class="dropdown-item" href="{{ route(auth()->user()->role == 1 ? 'admin.dashboard' : (auth()->user()->role == 2 ? 'vendor.dashboard' : 'user.dashboard')) }}">
        <i class="fas fa-tachometer-alt me-1"></i> Dashboard
    </a>
</li>
                        <li><a class="dropdown-item" href="/perfil"><i class="fas fa-user-circle me-1"></i> Meu Perfil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-1"></i> Sair
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>

                    <!-- Dropdown de Admin -->
                    @if(auth()->user()->role === '1')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-shield me-1"></i> Admin
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item" href="/admin/dashboard">Dashboard</a></li>
                                <li><a class="dropdown-item" href="/admin/settings">Configurações</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="/admin/manage/users">Gerir Utilizadores</a></li>
                                <li><a class="dropdown-item" href="/admin/manage/stores">Gerir Lojas</a></li>
                            </ul>
                        </li>
                    @endif

                    <!-- Dropdown de Vendor -->
                    @if(auth()->user()->role === '2')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="vendorDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-store me-1"></i> Vendor
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item" href="/vendor/dashboard">Dashboard</a></li>
                                <li><a class="dropdown-item" href="/vendor/product/create">Criar Produto</a></li>
                                <li><a class="dropdown-item" href="/vendor/product/manage">Gerir Produtos</a></li>
                            </ul>
                        </li>
                    @endif
                @else
                    <!-- Botões Login e Registro -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i> Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">
                            <i class="fas fa-user-plus me-1"></i> Registrar
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<style>
    .bg-gradient-custom {
        background: linear-gradient(90deg, #0d0d0d 0%, #1c1c1c 100%);
        color: #f8f9fa;
    }
    .search-input {
        background-color: #2c2c2c;
        border: 1px solid #444;
        color: #fff;
    }
    .search-input::placeholder {
        color: #bbb;
    }
    .btn-outline-light {
        border-color: #aaa;
        color: #fff;
    }
    .btn-outline-light:hover {
        background-color: #fff;
        color: #000;
    }
    .dropdown-menu-dark {
        background-color: #1a1a1a;
        border: 1px solid #333;
        border-radius: 0.5rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.6);
    }
    .dropdown-item {
        color: #f8f9fa;
    }
    .dropdown-item:hover {
        background-color: #343a40;
        color: #fff;
    }
    .navbar .rounded-circle {
        border: 2px solid #ddd;
    }
    .navbar-brand, .nav-link, .dropdown-item {
        text-shadow: 0 0 3px rgba(255, 255, 255, 0.2);
    }
    .animate-spin {
        animation: spin 2s linear infinite;
        color: #0dcaf0;
        text-shadow: 0 0 6px rgba(13, 202, 240, 0.7);
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    </style>
