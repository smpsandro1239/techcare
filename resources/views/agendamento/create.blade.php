<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agendamento</title>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
</head>
<body>
    <h1>Agendar Serviço</h1>

    <div id="calendar"></div>

    <!-- Modal para seleção de hora e serviço -->
    <div id="eventModal" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; border: 1px solid #ccc; z-index: 1000;">
        <h2>Escolha o Horário e Serviço</h2>
        <form id="agendamentoForm" method="POST" action="{{ route('admin.agendamento.store') }}">
            @csrf
            <input type="hidden" name="nome_cliente" value="{{ auth()->user()->name }}" readonly>
            <input type="hidden" name="data" id="selectedDate">
            <div>
                <label>Hora</label>
                <select name="hora" id="horaSelect" required>
                    <!-- Opções de hora serão preenchidas dinamicamente -->
                </select>
            </div>
            <div>
                <label>Serviço</label>
                <select name="servico" required>
                    <option value="">Selecione um serviço</option>
                    <option value="Instalação de Windows|2">Instalação de Windows (2 horas)</option>
                    <option value="Manutenção de Hardware|1">Manutenção de Hardware (1 hora)</option>
                    <option value="Configuração de Rede|1.5">Configuração de Rede (1h30)</option>
                </select>
            </div>
            <button type="submit">Agendar</button>
            <button type="button" onclick="closeModal()">Cancelar</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                selectable: true,
                select: function(info) {
                    // Ao selecionar um dia, abre o modal e popula as opções de hora
                    openModal(info.startStr);
                },
                eventClick: function(info) {
                    alert('Agendamento existente: ' + info.event.title + '\nCliente: ' + info.event.extendedProps.description);
                },
                events: '{{ route('agendamentos.json') }}',
                slotMinTime: '09:00:00',
                slotMaxTime: '19:00:00',
                businessHours: {
                    daysOfWeek: [1, 2, 3, 4, 5], // Segunda a sexta
                    startTime: '09:00',
                    endTime: '19:00'
                },
                hiddenDays: [0, 6], // Esconde sábado e domingo
                dateClick: function(info) {
                    // Mesmo comportamento que select, mas para cliques simples
                    openModal(info.dateStr);
                }
            });
            calendar.render();

            function openModal(dateStr) {
                document.getElementById('selectedDate').value = dateStr;
                var modal = document.getElementById('eventModal');
                var horaSelect = document.getElementById('horaSelect');
                horaSelect.innerHTML = ''; // Limpa opções anteriores

                // Horários laborais: 9h-12h e 13h-19h
                var horarios = [];
                for (var h = 9; h < 12; h++) horarios.push(h + ':00', h + ':30');
                for (var h = 13; h < 19; h++) horarios.push(h + ':00', h + ':30');

                // Adiciona opções de hora
                horarios.forEach(function(hora) {
                    var option = document.createElement('option');
                    option.value = hora;
                    option.text = hora;
                    horaSelect.appendChild(option);
                });

                modal.style.display = 'block';
            }

            function closeModal() {
                document.getElementById('eventModal').style.display = 'none';
            }

            // Fechar modal ao clicar fora
            window.onclick = function(event) {
                var modal = document.getElementById('eventModal');
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            };
        });
    </script>
</body>
</html>
