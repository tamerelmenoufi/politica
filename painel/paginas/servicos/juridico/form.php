<?php
include "config_servicos.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    $attr = [];

    $codigo = $data['codigo'] ?: null;

    unset($data['codigo']);

    foreach ($data as $name => $value) {
        $attr[] = "{$name} = '" . mysql_real_escape_string($value) . "'";
    }

    $attr = implode(', ', $attr);

    if ($codigo) {
        $query = "UPDATE servicos SET {$attr} WHERE codigo = '{$codigo}'";
    } else {
        $query = "INSERT INTO servicos SET {$attr}";
    }

    if (mysql_query($query)) {
        $codigo = $codigo ?: mysql_insert_id();

        echo json_encode([
            'status' => true,
            'msg' => 'Dados salvo com sucesso',
            'codigo' => $codigo,
        ]);
    } else {
        echo json_encode([
            'status' => false,
            'msg' => 'Erro ao salvar',
            'codigo' => $codigo,
            'mysql_error' => mysql_error(),
        ]);
    }

    exit;
}

$codigo = $_GET['codigo'];

if ($codigo) {
    $query = "SELECT * FROM servicos WHERE codigo = '{$codigo}'";
    $result = mysql_query($query);
    $d = mysql_fetch_object($result);
}

?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb shadow bg-gray-custom">
        <li class="breadcrumb-item"><a href="#" url="content.php">Início</a></li>
        <li class="breadcrumb-item" aria-current="page">
            <a href="#" url="<?= $urlServicos; ?>/index.php">Serviços</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            <?= $codigo ? 'Alterar' : 'Cadastrar'; ?>
        </li>
    </ol>
</nav>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">
            <?= $codigo ? 'Alterar' : 'Cadastrar'; ?> Jurídico
        </h6>
    </div>
    <div class="card-body">
        <form id="form-servicos">

            <input type="hidden" id="tipo" name="tipo" value="7"/>

            <?php
                $query = "SELECT * FROM especialidades where servico_tipo = '7' ORDER BY descricao";
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
                            <?= ($codigo and $d->especialidade == $b->codigo) ? 'selected' : ''; ?>
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
                            <?= ($codigo and $d->beneficiado == $b->codigo) ? 'selected' : ''; ?>
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
                        value="<?= $d->contato; ?>"
                        required
                >

            </div>

            <div class="form-group">
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

            </div>

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
                            <?= ($codigo and $d->assessor == $a->codigo) ? 'selected' : ''; ?>
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
                    $query = "SELECT * FROM local_fontes where servico_tipo = '7' ORDER BY descricao";
                    $result = mysql_query($query);

                    while ($l = mysql_fetch_object($result)): ?>
                        <option
                            <?= ($codigo and $d->local_fonte == $l->codigo) ? 'selected' : ''; ?>
                                value="<?= $l->codigo ?>">
                            <?= $l->descricao; ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="data_agenda">Data de Agenda <i class="text-danger">*</i></label>
                        <input
                                type="datetime-local"
                                class="form-control"
                                id="data_agenda"
                                name="data_agenda"
                                value="<?= $codigo ? strftime('%Y-%m-%dT%H:%M:%S', strtotime($d->data_agenda)) : ''; ?>"
                                required
                        >

                    </div>
                </div>
            </div>

            <input type="hidden" id="codigo" value="<?= $codigo; ?>">

            <button type="submit" class="btn btn-success">Salvar</button>
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

        $('#form-servicos').submit(function (e) {
            e.preventDefault();

            if (!$(this).valid()) return false;

            var codigo = $('#codigo').val();
            var dados = $(this).serializeArray();

            if (codigo) {
                dados.push({name: 'codigo', value: codigo})
            }

            $.ajax({
                url: '<?= $urlServicos; ?>/form.php',
                method: 'POST',
                data: dados,
                success: function (response) {
                    let retorno = JSON.parse(response);

                    if (retorno.status) {
                        tata.success('Sucesso', retorno.msg);

                        $.ajax({
                            url: '<?= $urlServicos; ?>/visualizar.php',
                            data: {codigo: retorno.codigo},
                            success: function (response) {
                                $('#palco').html(response);
                            }
                        })
                    } else {
                        tata.error('Error', retorno.msg);
                    }
                }
            })
        });
    });
</script>



