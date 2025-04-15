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
    <!-- Luxon para manipulação de fusos horários -->
    <script src="https://cdn.jsdelivr.net/npm/luxon@3.4.4/build/global/luxon.min.js"></script>

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
    <a href="{{ route('agendamento.index') }}" class="btn btn-outline-light">Ver Agendamentos</a>

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
        <form id="agendamentoForm" method="POST">
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
        const { DateTime } = luxon; // Usar Luxon para manipulação de fusos horários

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
                    // Obter a data e hora de início do evento
                    const startDateTime = new Date(info.event.start);
                    // Formatar a data e hora para o fuso horário local (Europe/Lisbon)
                    const formattedStart = startDateTime.toLocaleString('pt-PT', {
                        timeZone: 'Europe/Lisbon',
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });

                    // Obter a data e hora de fim (se disponível)
                    const endDateTime = info.event.end ? new Date(info.event.end) : null;
                    const formattedEnd = endDateTime ? endDateTime.toLocaleString('pt-PT', {
                        timeZone: 'Europe/Lisbon',
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    }) : 'Não especificado';

                    // Exibir o popup com data, hora, cliente e serviço
                    Swal.fire({
                        title: 'Detalhes do Agendamento',
                        html: `<strong>Data e Hora de Início:</strong> ${formattedStart} <br>
                               <strong>Data e Hora de Fim:</strong> ${formattedEnd} <br>
                               <strong>Cliente:</strong> ${info.event.extendedProps.description} <br>
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
                },
                timeZone: 'local', // Usar o fuso horário local (já ajustado no backend)
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    meridiem: false
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
            console.log('Data selecionada (info.dateStr):', dateStr);
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

        // Enviar o formulário via AJAX
        document.getElementById('agendamentoForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Impedir o envio tradicional do formulário

            var selectedDate = document.getElementById('selectedDate').value;
            var selectedHour = document.getElementById('horaSelect').value;

            // Criar um objeto DateTime com o fuso horário Europe/Lisbon
            const localDateTime = DateTime.fromFormat(
                `${selectedDate} ${selectedHour}`,
                'yyyy-MM-dd HH:mm',
                { zone: 'Europe/Lisbon' }
            );
            // Converter para UTC
            const utcDateTime = localDateTime.toUTC();
            // Formatar a data e hora em UTC
            const utcDate = utcDateTime.toFormat('yyyy-MM-dd');
            const utcTime = utcDateTime.toFormat('HH:mm');

            // Preparar os dados do formulário
            const formData = new FormData(document.getElementById('agendamentoForm'));
            formData.set('data', utcDate);
            formData.set('hora', utcTime);

            // Enviar o formulário via AJAX
            fetch('{{ route('agendamento.store') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'error') {
                    // Exibir popup de erro (feriado)
                    Swal.fire({
                        title: 'Erro ao Agendar',
                        text: data.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                } else if (data.status === 'success') {
                    // Exibir popup de sucesso e redirecionar
                    Swal.fire({
                        title: 'Sucesso!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = data.redirect;
                    });
                }
            })
            .catch(error => {
                console.error('Erro ao enviar o formulário:', error);
                Swal.fire({
                    title: 'Erro!',
                    text: 'Ocorreu um erro ao processar o agendamento. Tente novamente.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        });
    </script>

    @livewireScripts
</body>
</html>
