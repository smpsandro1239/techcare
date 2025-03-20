<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech Care</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        /* Estilo geral do site */
        body {
            background-color: #000;
            color: #ddd;
        }

        /* Rodapé */
        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #111;
            color: #bbb;
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
            color: white;
        }

        .features .feature-item {
            display: inline-block;
            margin: 20px;
            padding: 20px;
            background-color: #222;
            color: white;
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
            color: white;
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
            border-radius: 30px;
            text-transform: uppercase;
            width: auto;
            text-align: center;
        }

        .banner-button:hover {
            background-color: #28a745;
            color: white;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .banner-button {
                font-size: 1rem;
                padding: 12px 25px;
                width: auto;
            }
        }

        /* Animação para o logo techicon */
        .techicon-logo {
            opacity: 0;
            animation: fadeIn 2s ease-out forwards;
        }

        .techicon-logo img {
            width: 100%;
            max-height: 600px;
            object-fit: cover;
        }

        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }
    </style>

    @livewireStyles
</head>
<body>
    <!-- Incluir a navbar parcial -->
    @include('layouts.partials.navbar')

    <!-- Imagem Tech Care Logo com animação -->
    <div class="container-fluid p-0 techicon-logo">
        <img src="{{ asset('admin_asset/img/techicon.png') }}" alt="Tech Care Logo">
    </div>

    <!-- Banner com imagem e botão -->
    <div class="banner">
        <img src="{{ asset('admin_asset/img/banner2.png') }}" alt="Banner da Loja">
        <a href="{{ auth()->check() ? route('agendamento.create') : route('login') }}" class="banner-button">Agende Agora</a>
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
        © {{ date('Y') }} Tech Care - Todos os direitos reservados.
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
</body>
</html>
