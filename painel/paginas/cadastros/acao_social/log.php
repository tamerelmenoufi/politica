<?php
include "config_acao_social.php";

$codigo = $_GET['codigo'];

if ($codigo) {
    $d = ListaLogs('acao_social', $codigo);
    $d = $d[0];
}

?>
<div class="card shadow mb-4">
    <div class="card-body">
        <form id="form-acao-social">

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
                <label for="local">Local <i class="text-danger">*</i></label>
                <input
                        type="text"
                        class="form-control"
                        id="local"
                        name="local"
                        value="<?= $d['local']; ?>"
                        maxlength="255"
                        required
                >

            </div>

            <div class="form-group">
                <label for="servicos">Serviços <i class="text-danger">*</i></label>

                <?php
                $queryServicos = "SELECT * FROM acao_social_tipo ORDER BY tipo";
                $resultServico = mysql_query($queryServicos);

                $servicos_check = explode(',', $d->servicos);

                while ($dados_servico = mysql_fetch_object($resultServico)):
                    $isChecked = (@in_array($dados_servico->codigo, $servicos_check));
                    ?>
                    <div class="form-check">
                        <input
                                class="form-check-input servicos"
                                type="checkbox"
                                id="servicos-<?= $dados_servico->codigo; ?>"
                                value="<?= $dados_servico->codigo; ?>"
                            <?= $isChecked ? 'checked' : ''; ?>

                        >
                        <label class="form-check-label" for="servicos-<?= $dados_servico->codigo; ?>">
                            <?= $dados_servico->tipo; ?>
                        </label>
                    </div>
                <?php endwhile; ?>

            </div>

            <div class="form-group">
                <label for="descricao">Descrição<i class="text-danger">*</i></label>
                <textarea id="descricao" name="descricao" class="form-control"><?= $d['descricao'] ?></textarea>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="data">Data <i class="text-danger">*</i></label>
                        <input
                                type="datetime-local"
                                class="form-control"
                                id="data"
                                name="data"
                                value="<?= $codigo ? strftime('%Y-%m-%dT%H:%M:%S', strtotime($d['data'])) : ''; ?>"
                                required
                        >

                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(function () {
        $("#assessor").selectpicker();

        $('#form-acao-social').validate();

    });
</script>


