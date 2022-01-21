<?php
include_once "config_oficios.php";

$esfera = $_GET['esfera'];
$query = "SELECT * FROM secretarias WHERE esfera = '{$esfera}'";
$result = mysql_query($query);

?>

<select
        class="form-control secretaria"
        id="secretaria"
        name="secretaria"
        data-live-search="true"
        data-none-selected-text="Selecione"
        required
>
    <?php while ($d = mysql_fetch_object($result)): ?>

        <option value=""></option>
        <?php
        $query = "SELECT * FROM secretarias WHERE esfera = '{$esfera}' ORDER BY descricao";
        $result = mysql_query($query);

        while ($s = mysql_fetch_object($result)): ?>
            <option
                <?= ($codigo and $d->secretaria == $s->codigo) ? 'selected' : ''; ?>
                    value="<?= $s->codigo ?>">
                <?= $s->descricao; ?>
            </option>
        <?php endwhile; ?>


    <?php endwhile;
    ?>
</select>

<script>
    $(function () {
        $(".secretaria").selectpicker();
    })
</script>

