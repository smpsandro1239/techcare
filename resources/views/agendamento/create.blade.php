<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agendamento</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <style>
        #calendar {
            max-width: 70%; /* Reduzido para 50% */
            margin: 20px auto;
            height: 500px; /* Reduzido para 400px */
        }
        #eventModal {
            max-width: 400px;
            width: 90%;
        }
        body {
            padding-top: 56px; /* Espaço para a navbar fixa */
        }
    </style>
</head>
<body>
    <!-- Incluir a navbar -->
    @include('layouts.partials.navbar')

    <div class="container mt-4">
        <h1 class="text-center">Agendar Serviço</h1>
        <div id="calendar"></div>
    </div>

    <!-- Modal para seleção de hora e serviço -->
    <div id="eventModal" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; border: 1px solid #ccc; z-index: 1000;">
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

    <!-- Bootstrap JS e FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var feriados = [
                @foreach (['2025-01-01', '2025-04-18', '2025-04-20', '2025-04-25', '2025-05-01', '2025-06-10', '2025-08-15', '2025-10-05', '2025-11-01', '2025-12-01', '2025-12-08', '2025-12-25'] as $feriado)
                    '{{ $feriado }}',
                @endforeach
            ];

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                selectable: true,
                events: '{{ route('agendamento.json') }}',  // Aqui carregamos os agendamentos do servidor
                slotMinTime: '09:00:00',
                slotMaxTime: '19:00:00',
                businessHours: {
                    daysOfWeek: [1, 2, 3, 4, 5],
                    startTime: '09:00',
                    endTime: '19:00'
                },
                hiddenDays: [0, 6],
                validRange: {
                    start: '{{ \Carbon\Carbon::today()->toDateString() }}',
                },
                eventClick: function(info) {
                    alert('Agendamento existente: ' + info.event.title + '\nCliente: ' + info.event.extendedProps.description);
                },
                dateClick: function(info) {
                    if (feriados.includes(info.dateStr)) {
                        alert('Não é possível agendar em feriados.');
                        return;
                    }
                    var dayOfWeek = new Date(info.dateStr).getDay();
                    if (dayOfWeek === 0 || dayOfWeek === 6) {
                        alert('Não é possível agendar em fins de semana.');
                        return;
                    }
                    var today = new Date('{{ \Carbon\Carbon::today()->toDateString() }}');
                    var selectedDate = new Date(info.dateStr);
                    if (selectedDate < today) {
                        alert('Não é possível agendar em dias passados.');
                        return;
                    }
                    openModal(info.dateStr);
                }
            });
            calendar.render();

            function openModal(dateStr) {
                // Obtendo os agendamentos de forma dinâmica
                fetch('{{ route('agendamento.json') }}', {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    credentials: 'same-origin'
                })
                .then(response => response.json())
                .then(events => {
                    document.getElementById('selectedDate').value = dateStr;
                    var modal = document.getElementById('eventModal');
                    var horaSelect = document.getElementById('horaSelect');
                    horaSelect.innerHTML = '';  // Limpar as opções de horário

                    var horarios = [];
                    for (var h = 9; h < 12; h++) horarios.push(h + ':00', h + ':30');
                    for (var h = 13; h < 19; h++) horarios.push(h + ':00', h + ':30');

                    var selectedService = document.getElementById('servicoSelect').value;
                    var duracao = selectedService ? parseFloat(selectedService.split('|')[1]) : 1;
                    var occupiedSlots = events.filter(event => event.start && event.start.startsWith(dateStr));

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

                    if (horaSelect.options.length === 0) {
                        alert('Não há horários disponíveis neste dia para o serviço selecionado.');
                        closeModal();
                        return;
                    }
                    modal.style.display = 'block';
                })
                .catch(error => {
                    console.error('Erro ao carregar eventos:', error);
                    alert('Erro ao verificar horários disponíveis. Tente novamente.');
                });
            }

            function closeModal() {
                document.getElementById('eventModal').style.display = 'none';
            }

            window.onclick = function(event) {
                var modal = document.getElementById('eventModal');
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            };

            document.getElementById('servicoSelect').addEventListener('change', function() {
                var selectedDate = document.getElementById('selectedDate').value;
                if (selectedDate) {
                    openModal(selectedDate);
                }
            });
        });
    </script>
</body>
</html>
