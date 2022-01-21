<?php
include "config_oficios.php";

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
        $query = "UPDATE oficios SET {$attr} WHERE codigo = '{$codigo}'";
    } else {
        $query = "INSERT INTO oficios SET {$attr}";
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
    $query = "SELECT * FROM oficios WHERE codigo = '{$codigo}'";
    $result = mysql_query($query);
    $d = mysql_fetch_object($result);
}

?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb shadow bg-gray-custom">
        <li class="breadcrumb-item"><a href="#" url="content.php">Início</a></li>
        <li class="breadcrumb-item" aria-current="page">
            <a href="#" url="<?= $urlOficios; ?>/index.php">Ofícios</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            <?= $codigo ? 'Alterar' : 'Cadastrar'; ?>
        </li>
    </ol>
</nav>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">
            <?= $codigo ? 'Alterar' : 'Cadastrar'; ?> Ofícios
        </h6>
    </div>
    <div class="card-body">
        <form id="form-oficios">

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

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="esfera">
                            Esfera <i class="text-danger">*</i>
                        </label>
                        <select
                                class="form-control"
                                id="esfera"
                                name="esfera"
                                required
                        >
                            <option value=""></option>
                            <?php
                            foreach (getEsfera() as $value): ?>
                                <option
                                    <?= ($codigo and $d->esfera == $value) ? 'selected' : ''; ?>
                                        value="<?= $value; ?>">
                                    <?= $value; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="secretaria">
                            Secretaria <i class="text-danger">*</i>
                        </label>
                        <div id="container-secretaria">
                            <select
                                    class="form-control secretaria"
                                    id="secretaria"
                                    name="secretaria"
                                    data-live-search="true"
                                    data-none-selected-text="Selecione"
                                    required
                            >
                                <option value=""></option>
                                <?php
                                if ($codigo):
                                    $query = "SELECT * FROM secretarias WHERE esfera = '{$d->esfera}' ORDER BY descricao";
                                    $result = mysql_query($query);

                                    while ($s = mysql_fetch_object($result)): ?>
                                        <option
                                            <?= ($codigo and $d->secretaria == $s->codigo) ? 'selected' : ''; ?>
                                                value="<?= $s->codigo ?>">
                                            <?= $s->descricao; ?>
                                        </option>
                                    <?php
                                    endwhile;
                                endif;
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
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
                            <option value=""></option>
                            <?php
                            foreach (getSituacao() as $key => $value): ?>
                                <option
                                    <?= ($codigo and $d->situacao == $key) ? 'selected' : ''; ?>
                                        value="<?= $key; ?>">
                                    <?= $value; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
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
        $("#assessor").selectpicker();

        $(".secretaria").selectpicker();

        $('#form-oficios').validate();

        $('#form-oficios').submit(function (e) {
            e.preventDefault();

            if (!$(this).valid()) return false;

            var codigo = $('#codigo').val();
            var dados = $(this).serializeArray();

            if (codigo) {
                dados.push({name: 'codigo', value: codigo})
            }

            $.ajax({
                url: '<?= $urlOficios; ?>/form.php',
                method: 'POST',
                data: dados,
                success: function (response) {
                    let retorno = JSON.parse(response);

                    if (retorno.status) {
                        tata.success('Sucesso', retorno.msg);

                        $.ajax({
                            url: '<?= $urlOficios; ?>/visualizar.php',
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

        $('#esfera').change(function () {
            var valor = $(this).val();

            $.ajax({
                url: '<?= $urlOficios; ?>/select_secretarias.php',
                data: {esfera: valor},
                success: function (response) {
                    console.log(response);
                    $('#container-secretaria').html(response);
                }
            })

        });
    });
</script>



