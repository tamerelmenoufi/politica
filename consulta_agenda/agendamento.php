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

?>

<style>
    #calendar a {
        text-decoration: none;
        color: #858796;
    }
</style>

<nav class="navbar navbar-light bg-light bg-white mb-4 static-top shadow py-3">
    <a class="navbar-brand mr-4 voltar" href="#" style="font-size: 1.2em">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
</nav>

<div class="col-md-12">
    <div class="row">

        <div class="col-md-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Dados</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 font-weight-bold">
                            Tipo de serviço
                        </div>
                        <div class="col-md-10">
                            <?= $d->st_tipo; ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2 font-weight-bold">
                            Local
                        </div>
                        <div class="col-md-10">
                            <?= $d->descricao; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-6 my-2">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Calendario</h6>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>

        <div class="col-md-6 my-2">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Serviços agendados</h6>
                </div>
                <div class="card-body" style="min-height:300px">

                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function () {

        var calendarEl = document.getElementById('calendar');
        console.log(calendarEl);
        var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'pt-br'
        });
        calendar.render();

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
