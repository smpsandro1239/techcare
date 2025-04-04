<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agendamento</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome (adicionado para ícones na navbar) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background-color: #000;
            color: #ddd;
        }
        .container {
            background-color: #111;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }
        #calendar {
            max-width: 100%;
            margin: 20px auto;
            height: 500px;
        }
        #eventModal {
            max-width: 400px;
            width: 90%;
            background: #222;
            color: #ddd;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }
        .btn {
            border-radius: 10px;
        }
        .btn-primary { background-color: #28a745; border: none; }
        .btn-primary:hover { background-color: #218838; }
        .btn-secondary { background-color: #555; border: none; }
        .btn-secondary:hover { background-color: #444; }
        .btn-danger { background-color: #dc3545; border: none; }
        .btn-danger:hover { background-color: #c82333; }
        .fc-daygrid-day-number, .fc-event-title, .fc-col-header-cell-cushion {
            color: white !important;
        }
    </style>

    @livewireStyles
</head>
<body>
    @include('layouts.partials.navbar')

    <div class="container mt-5">
        <h1 class="text-center text-success">Agendar Serviço</h1>

        <div class="text-center my-3">
            <button onclick="changeView('dayGridMonth')" class="btn btn-primary">Mensal</button>
            <button onclick="changeView('timeGridWeek')" class="btn btn-secondary">Semanal</button>
            <button onclick="changeView('timeGridDay')" class="btn btn-danger">Diário</button>
        </div>

        <div id="calendar"></div>
    </div>

    <!-- Modal para seleção de hora e serviço -->
    <div id="eventModal" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1000;">
        <h2>Escolha o Horário e Serviço</h2>
        <form id="agendamentoForm" method="POST" action="{{ route('agendamento.store') }}">
            @csrf
            <div class="mb-3">
                <label for="nome_cliente" class="form-label">Nome do Cliente</label>
                <input type="text" name="nome_cliente" id="nome_cliente" value="{{ auth()->check() ? auth()->user()->name : old('nome_cliente') }}" class="form-control" placeholder="Digite seu nome (opcional)">
            </div>
            <input type="hidden" name="data" id="selectedDate">
            <div class="mb-3">
                <label for="horaSelect" class="form-label">Hora</label>
                <select name="hora" id="horaSelect" class="form-select" required>
                    <!-- Opções de hora serão preenchidas dinamicamente -->
                </select>
            </div>
            <div class="mb-3">
                <label for="servicoSelect" class="form-label">Serviço</label>
                <select name="servico" id="servicoSelect" class="form-select" required>
                    <option value="">Selecione um serviço</option>
                    <option value="Instalação de Windows|2">Instalação de Windows (2 horas)</option>
                    <option value="Manutenção de Hardware|1">Manutenção de Hardware (1 hora)</option>
                    <option value="Configuração de Rede|1.5">Configuração de Rede (1h30)</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Agendar</button>
            <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancelar</button>
        </form>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <script>
        let calendar; // Declarar a variável global de calendário

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            // Instanciar o calendário
            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                selectable: true,
                events: '{{ route('agendamento.json') }}',
                slotMinTime: '09:00:00',
                slotMaxTime: '19:00:00',
                businessHours: {
                    daysOfWeek: [1, 2, 3, 4, 5], // Seg-Sex
                    startTime: '09:00',
                    endTime: '19:00'
                },
                hiddenDays: [0, 6], // Esconder Sábado e Domingo
                validRange: {
                    start: '{{ \Carbon\Carbon::today()->toDateString() }}',
                },
                eventClick: function(info) {
                    Swal.fire({
                        title: 'Detalhes do Agendamento',
                        html: `<strong>Cliente:</strong> ${info.event.extendedProps.description} <br>
                               <strong>Serviço:</strong> ${info.event.title}`,
                        icon: 'info',
                        confirmButtonText: 'OK'
                    });
                },
                dateClick: function(info) {
                    openModal(info.dateStr);
                },
                views: {
                    timeGridWeek: {
                        slotDuration: '00:30:00', // Mostrar intervalos de 30 minutos
                    },
                    timeGridDay: {
                        slotDuration: '00:30:00', // Mostrar intervalos de 30 minutos
                    }
                }
            });

            calendar.render(); // Renderizar o calendário
        });

        // Função para trocar a visualização do calendário
        function changeView(viewType) {
            if (calendar) {
                calendar.changeView(viewType); // Alterar para o tipo de visualização desejado
            }
        }

        function openModal(dateStr) {
            // Lógica para abrir o modal e preencher os horários
            document.getElementById('selectedDate').value = dateStr;
            var modal = document.getElementById('eventModal');
            modal.style.display = 'block';

            // Preencher o select de horários
            populateHorarios(dateStr);
        }

        function closeModal() {
            var modal = document.getElementById('eventModal');
            modal.style.display = 'none';
        }

        // Função para preencher os horários
        function populateHorarios(dateStr) {
            var horaSelect = document.getElementById('horaSelect');
            var selectedService = document.getElementById('servicoSelect').value;
            var duracao = selectedService ? parseFloat(selectedService.split('|')[1]) : 1;
            var horarios = [];
            for (var h = 9; h < 19; h++) {
                horarios.push(h + ':00', h + ':30');
            }

            var occupiedSlots = []; // Aqui você pode carregar eventos já agendados para aquele dia (caso haja)

            // Limpar opções anteriores
            horaSelect.innerHTML = '';

            // Adicionar opções de horário
            horarios.forEach(function(hora) {
                var horaInicio = new Date(dateStr + 'T' + hora + ':00');
                var horaFim = new Date(horaInicio.getTime() + duracao * 60 * 60 * 1000);
                var isOccupied = occupiedSlots.some(function(event) {
                    var eventStart = new Date(event.start);
                    var eventEnd = event.end ? new Date(event.end) : new Date(event.start);
                    return (horaInicio >= eventStart && horaInicio < eventEnd) ||
                           (horaFim > eventStart && horaFim <= eventEnd);
                });
                if (!isOccupied) {
                    var option = document.createElement('option');
                    option.value = hora;
                    option.text = hora;
                    horaSelect.appendChild(option);
                }
            });
        }
    </script>

    @livewireScripts
</body>
</html>
