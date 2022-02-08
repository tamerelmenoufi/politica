<?php
include '../lib/includes.php';

$data = $_POST['data'];
$servico_tipo = $_SESSION['servico_tipo'];
$filtro = $_POST['filtro'];

$query = "SELECT s.*, b.nome AS b_nome FROM servicos s "
    . "LEFT JOIN beneficiados b ON b.codigo = s.beneficiado ";

$whereGeral = "WHERE s.data_agenda LIKE '%{$data}%' AND s.tipo = '{$servico_tipo}' ORDER BY data_agenda";
$result = mysql_query($query . $whereGeral);

$mes = date('m', strtotime($data));
$whereMes = "WHERE DATE_FORMAT(s.data_agenda, \"%m\") = '{$mes}' AND s.tipo = '{$servico_tipo}' ORDER BY data_agenda";
$resultMes = mysql_query($query . $whereMes);

$mesArray = [
    '01' => 'Janeiro',
    '02' => 'Fevereiro',
    '03' => 'Março',
    '04' => 'Abril',
    '05' => 'Maio',
    '06' => 'Junho',
    '07' => 'Julho',
    '08' => 'Agosto',
    '09' => 'Setembro',
    '10' => 'Outubro',
    '11' => 'Novembro',
    '12' => 'Dezembro'
];
?>
<br>
<h1 class="h5 text-gray-800 my-1 mt-2">
    <?= date('d', strtotime($data)); ?> de <?= $mesArray[date('m', strtotime($data))]; ?>
</h1>

<div class="table-responsive mb-2" style="min-height: 140px;border: 1px solid #e3e6f0">

    <table class="table table-sm table-hover" style="font-size: .9rem;">
        <thead>
        <tr>
            <th class="text-center">Horário</th>
            <th class="text-center">Beneficiado</th>
            <th class="text-center">Especialista</th>
            <th class="text-center">Situação</th>
            <th class="text-center">Ações</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if (mysql_num_rows($result)):
            while ($d = mysql_fetch_object($result)):
                $data = formata_datahora($d->data_agenda, DATA_HM);
                ?>
                <tr>
                    <td class="text-center"><?= $data; ?></td>
                    <td class="text-center"><?= $d->b_nome; ?></td>
                    <td class="text-center"><?= $d->especialista; ?></td>
                    <td class="text-center"><?= $d->situacao; ?></td>
                    <td>
                        <button
                                type="button"
                                class="btn btn-sm btn-link btn-visualizar"
                                data-codigo="<?= $d->codigo; ?>"
                        >
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </td>
                </tr>
            <?php endwhile; ?>

        <?php else:
            echo '<tr><td colspan="6">Nenhum agendamento encontrado na data de hoje</td></tr>';
            ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<br>
<h1 class="h5 text-gray-800">Mês de <?= $mesArray[date('m', strtotime($data))]; ?></h1>

<div class="table-responsive" style="min-height: 140px;border: 1px solid #e3e6f0">
    <table class="table table-sm table-hover" style="font-size: .9rem;">
        <thead>
        <tr>
            <th class="text-center">Horário</th>
            <th class="text-center">Beneficiado</th>
            <th class="text-center">Especialista</th>
            <th class="text-center">Situação</th>
            <th class="text-center">Ações</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if (mysql_num_rows($resultMes)):
            while ($d = mysql_fetch_object($resultMes)):
                $data = formata_datahora($d->data_agenda, DATA_HM);
                ?>
                <tr>
                    <td class="text-center"><?= $data; ?></td>
                    <td class="text-center"><?= $d->b_nome; ?></td>
                    <td class="text-center"><?= $d->especialista; ?></td>
                    <td class="text-center"><?= $d->situacao; ?></td>
                    <td>
                        <button
                                type="button"
                                class="btn btn-sm btn-link btn-visualizar"
                                data-codigo="<?= $d->codigo; ?>"
                        >
                            <i class="fa-regular fa-eye"></i>
                        </button>
                    </td>
                </tr>
            <?php endwhile; ?>

        <?php else:
            echo '<tr><td colspan="6">Nenhum agendamento encontrado</td></tr>';
            ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
    $(function () {
        $('.btn-visualizar').click(function () {
            var codigo = $(this).data('codigo');

            $.dialog({
                title: false,
                content: `url: visualizar.php?codigo=${codigo}`,
                theme: 'bootstrap',
                columnClass: 'large'
            });
        });
    });
</script>