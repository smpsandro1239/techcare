@extends('admin.layouts.layout')
@section('admin_page_title')
    Dashboard - Admin Panel
@endsection
@section('admin_layout')
@include('layouts.partials.navbar')

    <div class="container mt-5">
        <h3 class="mb-5 text-center text-white" style="font-weight: 600; letter-spacing: 1px;">Admin Dashboard</h3>

        <!-- Cards com Métricas -->
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card text-white bg-gradient-primary dashboard-card animate__animated animate__fadeIn" style="animation-delay: 0.1s;">
                    <div class="card-header">Administradores</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $numAdmins }}</h5>
                        <i class="fas fa-user-shield"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card text-white bg-gradient-success dashboard-card animate__animated animate__fadeIn" style="animation-delay: 0.2s;">
                    <div class="card-header">Vendedores</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $numVendors }}</h5>
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card text-white bg-gradient-info dashboard-card animate__animated animate__fadeIn" style="animation-delay: 0.3s;">
                    <div class="card-header">Clientes</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $numCustomers }}</h5>
                        <i class="fas fa-user"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card text-white bg-gradient-secondary dashboard-card animate__animated animate__fadeIn" style="animation-delay: 0.4s;">
                    <div class="card-header">Produtos</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $numProducts }}</h5>
                        <i class="fas fa-box"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card text-white bg-gradient-warning dashboard-card animate__animated animate__fadeIn" style="animation-delay: 0.5s;">
                    <div class="card-header">Valor Total dos Produtos</div>
                    <div class="card-body">
                        <h5 class="card-title">€ {{ number_format($totalProductValue, 2, ',', '.') }}</h5>
                        <i class="fas fa-euro-sign"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card text-white bg-gradient-danger dashboard-card animate__animated animate__fadeIn" style="animation-delay: 0.6s;">
                    <div class="card-header">Total de Agendamentos</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $numAgendamentos }}</h5>
                        <i class="fas fa-calendar-check"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card text-white bg-gradient-dark dashboard-card animate__animated animate__fadeIn" style="animation-delay: 0.7s;">
                    <div class="card-header">Total de Pedidos</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $numOrders }}</h5>
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráficos -->
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="chart-container animate__animated animate__fadeIn" style="animation-delay: 0.8s;">
                    <h4>Distribuição de Utilizadores</h4>
                    <div class="chart-wrapper">
                        <canvas id="userDistributionChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="chart-container animate__animated animate__fadeIn" style="animation-delay: 0.9s;">
                    <h4>Agendamentos por Mês</h4>
                    <div class="chart-wrapper">
                        <canvas id="agendamentosChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Adicionando Animate.css para animações -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        /* Ajustes para os cards */
        .dashboard-card {
            border: 1px solid rgba(255, 255, 255, 0.2) !important; /* Borda branca fina */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 15px;
            overflow: hidden;
            position: relative;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(255, 255, 255, 0.1), 0 0 15px rgba(255, 255, 255, 0.2) !important; /* Efeito de brilho */
        }

        .dashboard-card .card-header {
            font-weight: 600;
            font-size: 1.1rem;
            padding: 15px;
            background: linear-gradient(45deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.2)) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2) !important;
        }

        .dashboard-card .card-body {
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .dashboard-card .card-title {
            font-size: 1.6rem;
            font-weight: 700;
            margin: 0;
        }

        .dashboard-card i {
            font-size: 2.2rem;
            opacity: 0.9;
        }

        /* Ajuste para os gráficos */
        .chart-container {
            background: #1a1a1a !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important; /* Borda branca fina */
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(255, 255, 255, 0.05) !important;
            transition: box-shadow 0.3s ease;
        }

        .chart-container:hover {
            box-shadow: 0 5px 15px rgba(255, 255, 255, 0.1), 0 0 10px rgba(255, 255, 255, 0.15) !important; /* Efeito de brilho */
        }

        .chart-container h4 {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: #fff !important;
            letter-spacing: 0.5px;
        }

        .chart-wrapper {
            position: relative;
            width: 100%;
            height: 300px; /* Altura fixa para ambos os gráficos */
        }

        .chart-wrapper canvas {
            width: 100% !important;
            height: 100% !important;
        }
    </style>

    <!-- Scripts para Gráficos -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Gráfico de Pizza - Distribuição de Utilizadores
        var ctxPie = document.getElementById('userDistributionChart').getContext('2d');
        var userDistributionChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: {!! json_encode(array_keys($userDistribution)) !!},
                datasets: [{
                    data: {!! json_encode(array_values($userDistribution)) !!},
                    backgroundColor: ['#1e90ff', '#32cd32', '#00ced1'], // Cores mais vibrantes
                    borderColor: '#fff',
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                size: 14,
                                weight: 'bold',
                            },
                            color: '#fff',
                            padding: 15,
                        },
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleFont: { size: 14, weight: 'bold' },
                        bodyFont: { size: 12 },
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: '#fff',
                        borderWidth: 1,
                        cornerRadius: 5,
                    },
                },
                animation: {
                    animateScale: true,
                    animateRotate: true,
                },
            }
        });

        // Gráfico de Barras - Agendamentos por Mês
        var ctxBar = document.getElementById('agendamentosChart').getContext('2d');
        var agendamentosChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: {!! json_encode($meses) !!},
                datasets: [{
                    label: 'Agendamentos',
                    data: {!! json_encode($agendamentosData) !!},
                    backgroundColor: 'rgba(255, 69, 96, 0.7)', // Vermelho vibrante
                    borderColor: '#ff4560',
                    borderWidth: 1,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)',
                            borderColor: 'rgba(255, 255, 255, 0.2)',
                        },
                        ticks: {
                            color: '#fff',
                            font: {
                                size: 12,
                                weight: 'bold',
                            },
                        },
                    },
                    x: {
                        grid: {
                            display: false,
                        },
                        ticks: {
                            color: '#fff',
                            font: {
                                size: 12,
                                weight: 'bold',
                            },
                        },
                    },
                },
                plugins: {
                    legend: {
                        labels: {
                            font: {
                                size: 14,
                                weight: 'bold',
                            },
                            color: '#fff',
                        },
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleFont: { size: 14, weight: 'bold' },
                        bodyFont: { size: 12 },
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: '#fff',
                        borderWidth: 1,
                        cornerRadius: 5,
                    },
                },
                animation: {
                    duration: 1500,
                    easing: 'easeOutBounce',
                },
            }
        });
    </script>
@endsection
