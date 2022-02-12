<?php
include "config_oficios.php";


$codigo = $_GET['codigo'];

if ($codigo) {
    $d = ListaLogs('oficios', $codigo);
    $d = $d[0];
}

?>
<style>
    .jconfirm .jconfirm-box div.jconfirm-closeIcon{
        right:35px;
    }
</style>
<div class="card shadow mb-4">

    <div class="card-body">
        <form id="form-oficios" enctype="multipart/form-data">

            <div class="form-group">
                <label for="numero">
                    Número <i class="text-danger">*</i>
                </label>
                <input
                        type="text"
                        name="numero"
                        id="numero"
                        class="form-control"
                        value="<?=$d['numero']?>"
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
                    <option value="novo">Novo Cadastro</option>
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
                                    <?= ($codigo and $d['esfera'] == $value) ? 'selected' : ''; ?>
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
                                    $query = "SELECT * FROM secretarias WHERE esfera = '{$d['esfera']}' ORDER BY descricao";
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

            <div class="form-group">
                <label for="descricao">Descrição</label>
                <textarea
                        id="descricao"
                        name="descricao"
                        class="form-control"
                        rows="5"
                ><?= $d['descricao']; ?></textarea>
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

        $("#numero").mask("999/99");
        $("#assessor").selectpicker();
        $(".secretaria").selectpicker();
        $("select, input, textarea").attr("disabled","disabled");


    });
</script>



