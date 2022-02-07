<?php
include "../lib/includes.php";

$servico_tipo = $_POST['servico_tipo'];
$senha = mysql_real_escape_string($_POST['senha']);

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
    . "WHERE s.tipo = '{$servico_tipo}'";

$resultEventos = mysql_query($queryEventos);

$eventos = [];

while ($dadosEventos = mysql_fetch_object($resultEventos)):
    $eventos[] = [
        'id' => $dadosEventos->codigo,
        'title' => $dadosEventos->c_descricao ?: 'Outros',
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
        min-height: .3em;
    }

    div.fc-day-content div {
        max-height: 50px;
        overflow: hidden;
    }

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
</style>

<nav class="navbar d-block navbar-light bg-light bg-white mb-4 static-top py-3 shadow">
    <a class="navbar-brand mr-4 voltar" href="#" style="font-size: 1.2em">
        <i class="fa-solid fa-arrow-left"></i>
    </a>

    <span><?= $d->st_tipo; ?></span> - <span><?= $d->descricao; ?></span>
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

<script>

    $(document).ready(function () {
        var servico_tipo = $('#servico_tipo').val();

        var date = new Date();
        let dateString = date.getFullYear() + '-' + ('0' + (date.getMonth() + 1)).slice(-2) + '-' + ('0' + date.getDate()).slice(-2);

        consulta_agenda(dateString, servico_tipo);

        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'pt-br',
            timeZone: 'America/Manaus',
            headerToolbar: {
                right: 'prev,next today',
            },
            initialView: 'dayGridMonth',
            themeSystem: 'bootstrap',
            fixedWeekCount: false,
            showNonCurrentDates: false,
            dayMaxEvents: 0,
            moreLinkContent: function (arg) {
                let italicEl = document.createElement('i')

                italicEl.innerHTML = '<span class="badge badge-info text-center d-flex flex-row justify-content-center">' + arg.shortText + '</span>';

                let arrayOfDomNodes = [italicEl]
                return {domNodes: arrayOfDomNodes}
            },
            events: <?= json_encode($eventos); ?>,
            dateClick: function (info) {
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


    });
</script>
