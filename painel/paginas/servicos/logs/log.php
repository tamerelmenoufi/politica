<?php
include "config_logs.php";

$codigo = $_GET['codigo'];
$indice = $_GET['indice'];

if ($codigo) {
    $d = ListaLogs('servicos', $codigo);
    $D = $d[$indice];
    $d = $D[3];
}

?>

<style>
    .jconfirm .jconfirm-box div.jconfirm-closeIcon{
        right:35px;
    }
</style>

<div class="card shadow mb-4">
    <div class="card-body">

        <table class="table">
            <tr><td><b>Data:</b></td><td><?=$D[0]?></td></tr>
            <tr><td><b>Operação:</b></td><td><?=$D[1]?></td></tr>
            <tr><td><b>Usuário:</b></td><td><?=$D[2]?></td></tr>
        </table>

        <form id="form-servicos">

            <?php
                $query = "SELECT * FROM especialidades where servico_tipo = '1' ORDER BY descricao";
                $result = mysql_query($query);
                if(mysql_num_rows($result)){
            ?>

            <div class="form-group">
                <label for="especialidade">
                    Especialidade <i class="text-danger">*</i>
                </label>
                <select
                        class="form-control"
                        id="especialidade"
                        name="especialidade"
                        data-live-search="true"
                        data-none-selected-text="Selecione"
                        required
                >
                    <option value=""></option>
                    <?php

                    while ($b = mysql_fetch_object($result)): ?>
                        <option
                            <?= ($codigo and $d['especialidade'] == $b->codigo) ? 'selected' : ''; ?>
                                value="<?= $b->codigo ?>">
                            <?= $b->descricao; ?>
                        </option>
                    <?php endwhile; ?>
                </select>

            </div>
            <?php
                }
            ?>


            <div class="form-group">
                <label for="beneficiado">
                    Beneficiado <i class="text-danger">*</i>
                </label>
                <select
                        class="form-control"
                        id="beneficiado"
                        name="beneficiado"
                        data-live-search="true"
                        data-none-selected-text="Selecione"
                        required
                >
                    <option value=""></option>
                    <?php
                    $query = "SELECT * FROM beneficiados ORDER BY nome";
                    $result = mysql_query($query);

                    while ($b = mysql_fetch_object($result)): ?>
                        <option
                            <?= ($codigo and $d['beneficiado'] == $b->codigo) ? 'selected' : ''; ?>
                                value="<?= $b->codigo ?>">
                            <?= $b->nome; ?>
                        </option>
                    <?php endwhile; ?>
                </select>

            </div>

            <div class="form-group">
                <label for="contato">
                    Contato <i class="text-danger">*</i>
                </label>
                <input
                        type="text"
                        class="form-control"
                        id="contato"
                        name="contato"
                        value="<?= $d['contato']; ?>"
                        required
                >

            </div>

            <!-- <div class="form-group">
                <label for="especialista">
                    Especialista <i class="text-danger">*</i>
                </label>
                <input
                        type="text"
                        class="form-control"
                        id="especialista"
                        name="especialista"
                        value="<?= $d->especialista; ?>"
                        required
                >

            </div> -->

            <div class="form-group">
                <label for="assessor">
                    Assessor <i class="text-danger">*</i>
                </label>
                <select
                        class="form-control"
                        id="assessor"
                        name="assessor"
                        data-live-search="true"
                        data-none-selected-text="Selecione"
                        required
                >
                    <option value=""></option>
                    <?php
                    $query = "SELECT * FROM assessores ORDER BY nome";
                    $result = mysql_query($query);

                    while ($a = mysql_fetch_object($result)): ?>
                        <option
                            <?= ($codigo and $d['assessor'] == $a->codigo) ? 'selected' : ''; ?>
                                value="<?= $a->codigo ?>">
                            <?= $a->nome; ?>
                        </option>
                    <?php endwhile; ?>
                </select>

            </div>
            <div class="form-group">
                <label for="local_fonte">
                    Fonte Local <i class="text-danger">*</i>
                </label>
                <select
                        class="form-control"
                        id="local_fonte"
                        name="local_fonte"
                        data-live-search="true"
                        data-none-selected-text="Selecione"
                        required
                >
                    <option value=""></option>
                    <?php
                    $query = "SELECT * FROM local_fontes where servico_tipo = '1' ORDER BY descricao";
                    $result = mysql_query($query);

                    while ($l = mysql_fetch_object($result)): ?>
                        <option
                            <?= ($codigo and $d['local_fonte'] == $l->codigo) ? 'selected' : ''; ?>
                                value="<?= $l->codigo ?>">
                            <?= $l->descricao; ?>
                        </option>
                    <?php endwhile; ?>
                </select>

            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="data_agenda">Data de Agenda <i class="text-danger">*</i></label>
                        <input
                                type="datetime-local"
                                class="form-control"
                                id="data_agenda"
                                name="data_agenda"
                                value="<?= $codigo ? strftime('%Y-%m-%dT%H:%M:%S', strtotime($d['data_agenda'])) : ''; ?>"
                                required
                        >
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="situacao">
                            Situação <i class="text-danger">*</i>
                        </label>
                        <select
                                class="form-control"
                                id="situacao"
                                name="situacao"
                                required
                        >
                            <?php
                            foreach (getSituacao() as $key => $value): ?>
                                <option
                                    <?= ($codigo and $d['situacao'] == $key) ? 'selected' : ''; ?>
                                        value="<?= $key; ?>">
                                    <?= $value; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(function () {
        //$('#contato').mask('(99) 99999-9999');

        $("#assessor").selectpicker();
        $("#beneficiado").selectpicker();
        $("#especialidade").selectpicker();
        $("#local_fonte").selectpicker();
        $('#form-servicos').validate();
        $("select, input, textarea").attr("disabled","disabled");

    });
</script>



