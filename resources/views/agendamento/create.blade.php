@extends('layouts.app')

@section('content')
<div class="container bg-dark text-light p-4 rounded shadow-lg">
    @if(session('erro'))
        <div class="alert alert-danger">{{ session('erro') }}</div>
    @elseif(session('sucesso'))
        <div class="alert alert-success">{{ session('sucesso') }}</div>
    @endif

    <!-- Calendário -->
    <div id="calendar" class="calendar-container mb-4"></div>

    <!-- Formulário de Agendamento -->
    <div id="agendamento-panel" class="agendamento-panel">
        <h3 class="text-center text-light">Detalhes do Agendamento</h3>
        <form action="{{ route('admin.agendamento.store') }}" method="POST" id="agendamento-form">
            @csrf

            <div class="form-group">
                <label for="nome_cliente" class="text-white">Nome do Cliente</label>
                <input type="text" name="nome_cliente" class="form-control bg-black text-light border border-white" id="nome_cliente" required>
            </div>

            <div class="form-group">
                <label for="data" class="text-white">Data do Agendamento</label>
                <input type="date" name="data" class="form-control bg-black text-light border border-white" id="data" required>
            </div>

            <div class="form-group">
                <label for="hora" class="text-white">Hora do Agendamento</label>
                <input type="time" name="hora" class="form-control bg-black text-light border border-white" id="hora" required>
            </div>

            <div class="form-group">
                <label for="servico" class="text-white">Serviço</label>
                <input type="text" name="servico" class="form-control bg-black text-light border border-white" id="servico" required>
            </div>

            <button type="submit" class="btn btn-success w-100">Agendar</button>
            <button type="button" id="cancel-agendamento" class="btn btn-danger w-100 mt-2">Cancelar</button>
        </form>
    </div>
</div>

<!-- Links para os estilos do FullCalendar -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.css" rel="stylesheet">

<!-- Estilos personalizados -->
<style>
    /* Estilo do calendário */
    #calendar {
        background-color: #000; /* Cor de fundo totalmente preta */
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5);
        font-family: 'Roboto', sans-serif;
        width: 100%; /* Garante que o calendário ocupe toda a largura */
    }

    /* Estilo para os números e dias do calendário */
    .fc-daygrid-day-number {
        color: #fff; /* Cor dos números dos dias */
    }

    .fc-daygrid-day.fc-day:hover {
        background-color: rgba(255, 255, 255, 0.3); /* Cor de fundo suave (branco com transparência) */
        color: #fff; /* O texto continua branco */
        cursor: pointer;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    /* Estilo para os dias de fim de semana */
    .fc-daygrid-day.fc-day-saturday:hover, .fc-daygrid-day.fc-day-sunday:hover {
        background-color: rgba(255, 255, 255, 0.4); /* Fim de semana com uma leve cor mais forte */
    }

    .fc-daygrid-day.fc-day-past {
        background-color: #444;
        color: #555;
        pointer-events: none; /* Bloqueia interação com dias passados */
    }

    /* Alterar a cor dos nomes dos dias (Dom, Seg, Ter...) */
    .fc-col-header-cell {
        color: #fff; /* Tornar os nomes dos dias brancos */
    }

    /* Estilo do painel lateral de agendamento movido para a esquerda */
    .agendamento-panel {
        background-color: #000; /* Fundo do painel totalmente preto */
        color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
        position: fixed; /* Fixa o painel à esquerda */
        top: 0;
        left: 0; /* Move o painel para a esquerda */
        width: 100%;
        max-width: 400px; /* Limita a largura máxima */
        height: 100%;
        transform: translateX(-100%);
        transition: transform 0.3s ease;
        z-index: 9999; /* Garantir que o painel fique acima do calendário */
        overflow-y: auto;
    }

    .agendamento-panel.active {
        transform: translateX(0);
    }

    /* Estilo do formulário */
    .form-control {
        font-family: 'Roboto', sans-serif;
        font-size: 1rem;
        color: #fff; /* Garantir que o texto do campo seja branco */
        background-color: #333; /* Cor de fundo escura para o campo */
        border: 2px solid #fff; /* Borda branca e um pouco mais grossa */
    }

    /* Garantir que o campo de data tenha o mesmo estilo */
    #data {
        background-color: #333 !important; /* Cor de fundo escura */
        color: #fff !important; /* Texto branco */
        border: 2px solid #fff !important; /* Borda branca */
    }

    .form-control:focus {
        background-color: #444; /* Cor de fundo mais escura quando o campo é focado */
        border-color: #17a2b8; /* Cor de borda ao focar nos campos */
        box-shadow: 0 0 5px rgba(23, 162, 184, 0.5); /* Sombras para destacar o campo */
    }

    .btn-success {
        background-color: #17a2b8;
        border-color: #17a2b8;
    }

    .btn-success:hover {
        background-color: #28a745;
        border-color: #28a745;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .btn-danger:hover {
        background-color: #c82333;
        border-color: #c82333;
    }

    /* Estilo para os dias da semana */
    .fc-col-header-cell-cushion {
        color: #fff; /* Cor do texto das colunas de dias da semana */
    }

    /* Responsividade */
    @media (max-width: 767px) {
        /* Ajusta o calendário para ocupar toda a largura na tela pequena */
        #calendar {
            width: 100%;
            padding: 10px;
        }

        /* O painel de agendamento se ajusta em dispositivos móveis */
        .agendamento-panel {
            width: 100%;
            max-width: 100%; /* O painel ocupa toda a tela */
        }
    }

    @media (max-width: 991px) and (min-width: 768px) {
        /* Ajusta o painel lateral e calendário para telas médias */
        .agendamento-panel {
            width: 80%; /* Painel ocupa 80% da tela */
        }

        #calendar {
            padding: 15px;
        }
    }

    /* Ajuste para telas grandes */
    @media (min-width: 992px) {
        .agendamento-panel {
            width: 400px; /* Limita a largura para telas grandes */
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var agendamentoPanel = document.getElementById('agendamento-panel');
        var cancelBtn = document.getElementById('cancel-agendamento');
        var horaInput = document.getElementById('hora');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'pt', // Definindo o idioma para português
            events: function(info, successCallback, failureCallback) {
                fetch('/agendamentos/api') // Chama a rota que retorna os agendamentos
                    .then(response => response.json())
                    .then(data => {
                        var events = data.map(agendamento => ({
                            title: agendamento.servico,
                            start: agendamento.data + 'T' + agendamento.hora, // Formato de data e hora no FullCalendar
                            description: agendamento.servico,
                            color: '#1a73e8', // Cor do evento
                        }));
                        successCallback(events);
                    })
                    .catch(err => failureCallback(err));
            },
            dateClick: function(info) {
                // Desabilita a seleção de dias passados
                if (info.date < moment().startOf('day')) {
                    return; // Ignora clique em dias passados
                }

                // Exibe o painel lateral de agendamento ao clicar em uma data
                agendamentoPanel.classList.add('active');
                document.getElementById('data').value = info.dateStr;

                // Define a hora mínima como a hora atual se for o dia atual
                var now = moment();
                if (info.date.isSame(now, 'day')) {
                    var currentHour = now.format('HH:mm');
                    horaInput.setAttribute('min', currentHour);
                    horaInput.value = currentHour; // Define a hora atual como padrão
                } else {
                    horaInput.setAttribute('min', '09:00'); // Define a hora mínima para dias futuros
                    horaInput.value = '09:00'; // Define um valor padrão
                }

                // Atualiza as opções de hora
                updateHourOptions();
            },
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth'
            }
        });

        calendar.render();

        // Função para atualizar as opções de hora
        function updateHourOptions() {
            var now = moment();
            var selectedDate = document.getElementById('data').value;

            if (selectedDate === now.format('YYYY-MM-DD')) {
                var currentHour = now.hour();
                for (let i = 0; i < 24; i++) {
                    let hour = (i < 10 ? '0' : '') + i + ':00';
                    if (i < currentHour) {
                        horaInput.querySelector(`option[value="${hour}"]`).disabled = true;
                    } else {
                        horaInput.querySelector(`option[value="${hour}"]`).disabled = false;
                    }
                }
            } else {
                // Para dias futuros, habilita todas as horas
                for (let i = 0; i < 24; i++) {
                    let hour = (i < 10 ? '0' : '') + i + ':00';
                    horaInput.querySelector(`option[value="${hour}"]`).disabled = false;
                }
            }
        }

        // Atualiza as opções de hora quando a data é alterada
        document.getElementById('data').addEventListener('change', updateHourOptions);

        // Fechar painel de agendamento
        cancelBtn.addEventListener('click', function() {
            agendamentoPanel.classList.remove('active');
        });
    });
</script>
@endsection