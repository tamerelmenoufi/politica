<?php
include "../lib/includes.php";

$servico_tipo = $_POST['servico_tipo'];
$senha = mysql_real_escape_string($_POST['senha']);

$_SESSION['servico_tipo'] = $servico_tipo;

$query = "SELECT lf.*, st.tipo AS st_tipo FROM local_fontes lf "
    . "INNER JOIN servico_tipo st ON st.codigo = lf.servico_tipo "
    . "WHERE lf.servico_tipo = '{$servico_tipo}' AND lf.senha = '{$senha}' AND lf.deletado = '0' ";
$result = mysql_query($query);

if (!@mysql_num_rows($result)) {
    echo 0;
    exit();
}

$d = mysql_fetch_object($result);

$queryEventos = "SELECT s.*, b.nome AS b_nome, c.descricao AS c_descricao FROM servicos s "
    . "LEFT JOIN beneficiados b ON b.codigo = s.beneficiado "
    . "LEFT JOIN categorias c ON c.codigo = s.categoria "
    . "WHERE s.tipo = '{$servico_tipo}' AND s.data_agenda > 0 AND s.deletado = '0'";


$resultEventos = mysql_query($queryEventos);

$eventos = [];

while ($dadosEventos = mysql_fetch_object($resultEventos)):
    $eventos[] = [
        'id' => $dadosEventos->codigo,
        'title' => formata_datahora($dadosEventos->data_agenda, HORA_MINUTO) . ' - ' . $dadosEventos->b_nome . " (" . ($dadosEventos->c_descricao ?: 'Outros') . ")",
        'start' => date('Y-m-d', strtotime($dadosEventos->data_agenda)),
    ];
endwhile;

?>

<style>
    #calendar a {
        text-decoration: none;
        color: #858796;
    }

    .fc-basic-view .fc-body .fc-row {
        min-height: .1em;
    }

    /* ===== Full calendar ===== */

    div.fc-day-content div {
        max-height: 20px;
        overflow: hidden;
    }

    .fc .fc-daygrid-body-natural .fc-daygrid-day-events {
        margin-bottom: 0;
    }

    .fc-daygrid-day-frame {
        cursor: pointer;
    }

    .day-highlight {
        background-color: #dcedc8 !important;
    }

    /* ===== Full calendar ===== */

    /* ===== Scrollbar CSS ===== */
    /* Firefox */
    #calendar {
        scrollbar-width: auto;
        scrollbar-color: #858585 #ffffff;
    }

    /* Chrome, Edge, and Safari */
    #calendar *::-webkit-scrollbar {
        width: 5px;
    }

    #calendar *::-webkit-scrollbar-track {
        background: #ffffff;
    }

    #calendar *::-webkit-scrollbar-thumb {
        background-color: #858585;
        border-radius: 2px;
        border: 1px none #ffffff;
    }

    .btn-visualizar {
        cursor: pointer;
    }
</style>

<div id="agendamento">
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow flex-row justify-content-between align-items-center">
        <div>
            <a class="navbar-brand mr-4 voltar text-gray-700" href="#" style="font-size: 1.2em">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
        </div>
        <div class="text-gray-700 h4 font-weight-bold mb-0"><?= $d->st_tipo; ?></div>

        <div>
            <ul class="navbar-nav ml-auto">
                <?php
                $querySemAgenda = "SELECT lf.*, st.tipo AS st_tipo, b.nome AS b_nome, s.codigo AS s_codigo FROM local_fontes lf "
                    . "INNER JOIN servico_tipo st ON st.codigo = lf.servico_tipo "
                    . "INNER JOIN servicos s ON s.local_fonte = lf.codigo "
                    . "INNER JOIN beneficiados b ON b.codigo = s.beneficiado "
                    . "WHERE lf.servico_tipo = '{$servico_tipo}' AND lf.senha = '{$senha}' "
                    . "AND s.data_agenda = 0 AND lf.deletado = '0' ";
                #echo $querySemAgenda;
                $resultSemAgenda = mysql_query($querySemAgenda);

                $numSemAgenda = mysql_num_rows($resultSemAgenda);
                ?>
                <li class="nav-item dropdown no-arrow mx-1">
                    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                       data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-bell fa-fw"></i>
                        <!-- Counter - Alerts -->
                        <span class="badge badge-danger badge-counter"><?= $numSemAgenda ?: '0' ?>+</span>
                    </a>

                    <!-- Dropdown - Alerts -->
                    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                         aria-labelledby="alertsDropdown">
                        <h6 class="dropdown-header">
                            Agendamento sem data
                        </h6>
                        <?php if ($numSemAgenda): ?>
                            <?php while ($dadosSemAgenda = mysql_fetch_object($resultSemAgenda)): ?>
                                <a
                                        class="dropdown-item d-flex align-items-center sem-agenda"
                                        href="#"
                                        id="sem_agenda_<?= $dadosSemAgenda->s_codigo; ?>"
                                        data-cod_servico="<?= $dadosSemAgenda->s_codigo; ?>"
                                >
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500"><?= $dadosSemAgenda->descricao; ?></div>
                                        <span class="font-weight-bold"><?= $dadosSemAgenda->b_nome; ?></span>
                                    </div>
                                </a>
                            <?php endwhile; ?>
                            <!-- <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>-->
                        <?php else: ?>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div>
                                    <span class="font-weight-bold text-gray-500">Nenhum agendamento encontrado</span>
                                </div>
                            </a>
                        <?php endif; ?>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="col-md-12">
        <div class="row">

            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Agendamentos</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-5 my-2">
                                <div id="calendar"></div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-7 my-2">
                                <div id="resultado"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input
            type="hidden"
            id="servico_tipo"
            value="<?= $servico_tipo ?>"
    >
</div>

<script>

    $(document).ready(function () {
        var servico_tipo = $('#servico_tipo').val();

        var date = new Date();
        let dateString = date.getFullYear() + '-' + ('0' + (date.getMonth() + 1)).slice(-2) + '-' + ('0' + date.getDate()).slice(-2);

        consulta_agenda(dateString, servico_tipo);

        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            height: 'auto',
            contentHeight: 'auto',
            locale: 'pt-br',
            timeZone: 'America/Manaus',
            headerToolbar: {
                right: 'prev,next today',
            },
            initialView: 'dayGridMonth',

            fixedWeekCount: false,
            showNonCurrentDates: false,
            dayMaxEvents: 0,
            events: <?= json_encode($eventos); ?>,
            moreLinkContent: function (arg) {
                let italicEl = document.createElement('i')

                let html = `<span class="badge badge-info text-right float-right">${arg.shortText}</span>`;
                italicEl.innerHTML = html;

                let arrayOfDomNodes = [italicEl];

                return {domNodes: arrayOfDomNodes}
            },
            eventContent: function (arg) {
                let italicEl = document.createElement('i')
                let dados = arg.event._def;
                let html = `<span class="btn-visualizar" data-codigo="${dados.publicId}" style="font-style: normal;">${dados.title}</span>`;

                italicEl.innerHTML = html;

                let arrayOfDomNodes = [italicEl]
                return {domNodes: arrayOfDomNodes}
            },
            dateClick: function (info) {
                $(".day-highlight").removeClass("day-highlight");
                $(info.dayEl).addClass("day-highlight");
                calendar.gotoDate(date)
                consulta_agenda(info.dateStr, servico_tipo);
            },
        });

        calendar.render();

        function consulta_agenda(data, servico_tipo) {
            $.ajax({
                url: 'resultado.php',
                method: 'POST',
                data: {
                    data,
                    servico_tipo
                },
                success: function (response) {
                    $('#resultado').html(response);
                }
            });
        }

        $('.fc-prev-button').click(function () {
            var date = calendar.getDate();
            consulta_agenda(date.toISOString().slice(0, 10));
        });

        $('.fc-next-button').click(function () {
            var date = calendar.getDate();
            consulta_agenda(date.toISOString().slice(0, 10));
        });

    });

    $(function () {
        $('.voltar').click(function (e) {
            e.preventDefault();

            $.ajax({
                url: 'content.php',
                success: function (response) {
                    $('#palco-agenda').html(response);
                }
            })
        });

        $('#agendamento').on('click', '.btn-visualizar', function () {
            var codigo = $(this).data('codigo');

            $.dialog({
                title: false,
                content: `url: visualizar.php?codigo=${codigo}`,
                theme: 'bootstrap',
                columnClass: 'large'
            });
        });

        $('.sem-agenda').click(function () {
            var cod_servico = $(this).data('cod_servico');

            dialogDefineData = $.dialog({
                title: 'Definir data do agendamento',
                content: `url: form_definir_data.php?cod_servico=${cod_servico}`,
                theme: 'bootstrap',
                columnClass: 'medium'
            });
        });
    });

</script>
