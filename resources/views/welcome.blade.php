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
        body {
            background-color: #000;
            color: #ddd;
            padding-top: 70px; /* altura do navbar fixo */
        }

        footer {
            background-color: #111;
            color: #bbb;
            text-align: center;
            padding: 15px 0;
            margin-top: 60px;
        }

        .features {
            text-align: center;
            margin: 80px auto;
            max-width: 1200px;
        }

        .features h2 {
            color: #fff;
            font-size: 2.5rem;
            margin-bottom: 40px;
            text-shadow: 0 2px 4px rgba(255,255,255,0.1);
        }

        .features .feature-item {
            background-color: #1a1a1a;
            color: #fff;
            border-radius: 12px;
            padding: 30px 20px;
            box-shadow: 0 4px 12px rgba(255,255,255,0.05);
            transition: transform 0.3s ease-in-out;
            margin: 0 auto;
            margin-bottom: 30px;
            max-width: 300px;
            width: 100%;
        }

        .features .feature-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(0, 255, 255, 0.3);
        }

        .features .feature-item i {
            font-size: 48px;
            color: #0dcaf0;
            margin-bottom: 15px;
        }

        .banner {
            position: relative;
            width: 100%;
            overflow: hidden;
            padding: 20px 0;
        }

        .banner img {
            max-height: 400px;
            object-fit: cover;
            width: 100%;
        }

        .banner-text {
            text-align: center;
            color: #fff;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .banner-text h2 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #0dcaf0;
            margin-bottom: 15px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
        }

        .banner-text p {
            font-size: 1.5rem;
            font-style: italic;
            color: #ddd;
        }

        .banner-button {
            position: relative;
            display: inline-block;
            margin: 20px auto 0;
            padding: 10px 20px;
            background-color: #0dcaf0;
            color: #000;
            font-weight: bold;
            font-size: 1rem;
            border: none;
            border-radius: 20px;
            text-transform: uppercase;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(0, 255, 255, 0.3);
        }

        .banner-button:hover {
            background-color: #0dcaf0;
            color: #fff;
        }

        .techicon-logo {
            position: relative;
            height: 100vh;
            width: 100%;
            background-image: url('{{ asset('admin_asset/img/techicon3.png') }}');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            background-color: #000;
            opacity: 0;
            animation: fadeIn 2s ease-out forwards;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding-top: 20px;
        }

        .logo-text {
            text-align: center;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
        }

        .logo-text h1 {
            font-size: 4rem;
            font-weight: bold;
            margin-bottom: 10px;
            letter-spacing: 2px;
        }

        .logo-text p {
            font-size: 1.5rem;
            font-style: italic;
        }

        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .banner-text h2 {
                font-size: 1.8rem;
            }
            .banner-text p {
                font-size: 1.2rem;
            }
            .banner img {
                max-height: 300px;
            }
            .banner-button {
                font-size: 0.9rem;
                padding: 8px 16px;
            }
            .features .feature-item {
                width: 100%;
            }
            .logo-text h1 {
                font-size: 2.5rem;
            }
            .logo-text p {
                font-size: 1.2rem;
            }
        }

        @media (max-width: 576px) {
            .features h2 {
                font-size: 2rem;
            }
            .features .feature-item {
                padding: 20px 15px;
            }
            .banner-text h2 {
                font-size: 1.5rem;
            }
            .banner-text p {
                font-size: 1rem;
            }
            .banner img {
                max-height: 250px;
            }
            .banner-button {
                font-size: 0.8rem;
                padding: 6px 12px;
            }
            .logo-text h1 {
                font-size: 2rem;
            }
            .logo-text p {
                font-size: 1rem;
            }
        }

        @media (max-width: 400px) {
            .banner-button {
                font-size: 0.7rem;
                padding: 5px 10px;
            }
        }
    </style>

    @livewireStyles
</head>
<body>
    @include('layouts.partials.navbar')

    <div class="techicon-logo">
        <div class="logo-text">
            <h1>TECH CARE</h1>
            <p>A qualidade dos Líderes</p>
        </div>
    </div>

    <div class="banner container">
        <div class="row align-items-center">
            <!-- Coluna para a Imagem -->
            <div class="col-md-6">
                <img src="{{ asset('admin_asset/img/banner3.png') }}" alt="Banner da Loja" class="img-fluid">
            </div>
            <!-- Coluna para o Texto e Botão -->
            <div class="col-md-6 banner-text">
                <h2>⚡ REPARAÇÃO DE COMPUTADORES ⚡</h2>
                <p>Venha connosco e descubra a diferença!</p>
                <a href="{{ auth()->check() ? route('agendamento.create') : route('login') }}" class="banner-button">Agendar Agora</a>
            </div>
        </div>
    </div>

    <div class="container features">
        <h2>Porquê a TECH CARE?</h2>
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="feature-item text-center">
                    <i class="fas fa-tools"></i>
                    <h4> Melhores Técnicos </h4>
                    <p>Profissionais altamente qualificados o rigor da qualidade.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-item text-center">
                    <i class="fas fa-users"></i>
                    <h4>+1 Milhão de Clientes</h4>
                    <p>Clientes satisfeitos, confiabilidade absoluta nos serviços prestados.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-item text-center">
                    <i class="fas fa-map-marker-alt"></i>
                    <h4>Número 1 </h4>
                    <p>Líderes incontestáveis. <br> Taxa de satisfação de 99,9%.</p>
                </div>
            </div>
        </div>
    </div>

    <footer>
        © {{ date('Y') }} Tech Care - Todos os direitos reservados.
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
</body>
</html>
