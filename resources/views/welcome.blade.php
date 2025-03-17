<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech Care</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
        /* Estilo geral do site */
        body {
            background-color: #000; /* Fundo ainda mais escuro */
            color: #ddd; /* Texto mais claro para contraste */
        }

        /* Navbar extremamente escura */
        .navbar {
            background-color: #111 !important; 
        }

        .navbar a {
            color: #bbb !important; /* Cinza claro para melhor contraste */
        }

        .navbar a:hover {
            color: #28a745 !important; /* Verde para hover */
        }

        /* Input de busca (mantido o mesmo) */
        .form-control {
            background-color: #333;
            color: white;
            border: 1px solid #555;
        }

        /* Botão de busca (mantido o mesmo) */
        .btn-outline-success {
            border-color: #28a745;
            color: #28a745;
        }

        .btn-outline-success:hover {
            background-color: #28a745;
            color: white;
        }

        /* Rodapé ainda mais escuro */
        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #111; /* Fundo ainda mais escuro */
            color: #bbb; /* Texto cinza claro */
            text-align: center;
            padding: 10px 0;
        }

        /* Estilo da Seção de Destaques */
        .features {
            text-align: center;
            margin-top: 50px;
            margin-bottom: 50px;
        }

        .features h2 {
            color: #28a745;
            font-size: 36px;
            margin-bottom: 40px;
            color: white; /* Título da seção em branco */
        }

        .features .feature-item {
            display: inline-block;
            margin: 20px;
            padding: 20px;
            background-color: #222;
            color: white; /* Texto dentro dos itens da feature em branco */
            border-radius: 10px;
            width: 250px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease-in-out;
        }

        .features .feature-item:hover {
            transform: translateY(-10px);
        }

        .features .feature-item i {
            font-size: 50px;
            margin-bottom: 15px;
            color: white; /* Ícones em branco */
        }

        /* Imagem de Banner com efeito */
        .banner {
            position: relative;
            width: 100%;
            height: auto;
        }

        .banner img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        /* Estilo do botão sobre a imagem */
        .banner-button {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            padding: 15px 30px;
            background-color: #555;
            color: white;
            font-size: 1.2rem;
            border: none;
            border-radius: 30px; /* Bordas arredondadas */
            text-transform: uppercase;
            width: auto;
            text-align: center; /* Garantindo que o texto do botão esteja centralizado */
        }

        .banner-button:hover {
            background-color: #28a745;
            color: white;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        /* Responsividade: Ajustes para telas menores */
        @media (max-width: 768px) {
            .banner-button {
                font-size: 1rem;
                padding: 12px 25px;
                width: auto; /* Ajuste do tamanho do botão */
            }
        }

        /* Animação para o logo techicon */
        .techicon-logo {
            opacity: 0;
            animation: fadeIn 2s ease-out forwards;
        }

        /* Adicionando um efeito de animação para a imagem techicon */
        .techicon-logo img {
            width: 100%;
            max-height: 600px;
            object-fit: cover;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

    </style>

    @livewireStyles
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand text-success" href="{{ url('/') }}">Tech Care</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto">
            <li class="nav-item active">
                <a class="nav-link" href="{{ url('/') }}">Início</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('catalogo') }}">Catálogo</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.agendamento.create') }}">Agende sua Reparação</a>
            </li>
        </ul>
        <form class="form-inline mx-auto" action="{{ route('product.procurar') }}" method="GET">
            <input class="form-control mr-sm-2" type="search" placeholder="Procurar" name="search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Procurar</button>
        </form>
        <ul class="navbar-nav">
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Registrar</a>
                </li>
            @endguest
            @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @endauth
        </ul>
    </div>
</nav>

<!-- Imagem Tech Care Logo com animação -->
<div class="container-fluid p-0 techicon-logo">
    <img src="{{ asset('admin_asset/img/techicon.png') }}" alt="Tech Care Logo">
</div>

<!-- Banner com imagem e botão -->
<div class="banner">
    <img src="{{ asset('admin_asset/img/banner2.png') }}" alt="Banner da Loja">
    <a href="{{ route('admin.agendamento.create') }}" class="banner-button">Agende Agora</a>
</div>

<!-- Seção de Destaques -->
<div class="features">
    <h2>Porque Escolher-nos?</h2>
    <div class="feature-item">
        <i class="fas fa-tools"></i>
        <h4>Melhores Técnicos</h4>
        <p>Profissionais altamente qualificados prontos para ajudar.</p>
    </div>
    <div class="feature-item">
        <i class="fas fa-users"></i>
        <h4>Mais de 1 milhão de clientes satisfeitos</h4>
        <p>Temos uma base de clientes fiel e satisfeita com nossos serviços.</p>
    </div>
    <div class="feature-item">
        <i class="fas fa-map-marker-alt"></i>
        <h4>Número 1 no Norte</h4>
        <p>Nosso serviço é o mais procurado na região norte.</p>
    </div>
</div>

<!-- Rodapé -->
<footer>
    &copy; {{ date('Y') }} Tech Care - Todos os direitos reservados.
</footer>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@livewireScripts
</body>
</html>
