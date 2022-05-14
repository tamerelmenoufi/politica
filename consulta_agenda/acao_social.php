<?php

$eventos[] = [
    'id' => 1,
    'title' => 'Ação do Evento 1',
    'start' => '2022-05-01',
];
$eventos[] = [
    'id' => 4,
    'title' => 'Ação do Evento 1.1',
    'start' => '2022-05-01',
];

$eventos[] = [
    'id' => 2,
    'title' => 'Ação do Evento 2',
    'start' => '2022-05-15',
];

$eventos[] = [
    'id' => 3,
    'title' => 'Ação do Evento 3',
    'start' => '2022-05-29',
];


?>

<style>
    .day-highlight {
        background-color: #dcedc8 !important;
    }
    .btn-visualizar{
        width:100%;
        cursor:pointer;
    }
</style>

<div id="acao_social">
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow flex-row justify-content-between align-items-center">
        <div>
            <a class="navbar-brand mr-4 voltar text-gray-700" href="#" style="font-size: 1.2em">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
        </div>
        <div class="text-gray-700 h4 font-weight-bold mb-0">
            Ação Social
        </div>
        <div></div>
    </nav>


    <div class="col-md-12">
        <div class="row">

            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Consulta de Agendamentos</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-5">
                                <div id="calendar"></div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-7">
                                <div id="resultado"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){


        var date = new Date();

        let dateString = date.getFullYear() + '-' + ('0' + (date.getMonth() + 1)).slice(-2) + '-' + ('0' + date.getDate()).slice(-2);

        // consulta_agenda(dateString, servico_tipo);

        var calendarEl = document.getElementById('calendar');

        calendar = new FullCalendar.Calendar(calendarEl, {
            height: 'auto',
            contentHeight: 'auto',
            locale: 'pt-br',
            timeZone: 'America/Manaus',
            initialView: 'dayGridMonth',
            fixedWeekCount: false,
            showNonCurrentDates: false,
            dayMaxEvents: 0,
            events: <?= json_encode($eventos); ?>,
            headerToolbar: {
                right: 'prev,next today',
            },
            moreLinkContent: function (arg) {
                let italicEl = document.createElement('i')

                let html = `<span class="badge badge-info text-right float-right">${arg.shortText}</span>`;
                italicEl.innerHTML = html;

                let arrayOfDomNodes = [italicEl];

                return {
                    domNodes: arrayOfDomNodes
                }
            },
            eventContent: function (arg) {
                let italicEl = document.createElement('i')
                let dados = arg.event._def;
                let html = `<span class="btn-visualizar" data-codigo="${dados.publicId}" style="font-style: normal;">${dados.title}</span>`;

                italicEl.innerHTML = html;

                let arrayOfDomNodes = [italicEl]
                return {
                    domNodes: arrayOfDomNodes
                }
            },
            dateClick: function (info) {
                console.log(info);
                $(".day-highlight").removeClass("day-highlight");
                $(info.dayEl).addClass("day-highlight");
                //calendar.gotoDate(date)
                alert(info.dateStr);
                // consulta_agenda(info.dateStr, servico_tipo);
            },
        });

        calendar.render();





        $('#acao_social').on('click', '.btn-visualizar', function () {
            var codigo = $(this).data('codigo');

            alert(codigo);

        });


        $(".voltar").click(function(){

            $.ajax({
                url: 'form_acesso.php',
                success: function (response) {
                    $('#palco-agenda').html(response);
                }
            })

        });
    })
</script>