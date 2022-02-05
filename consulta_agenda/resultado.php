<?php
include '../lib/includes.php';

$data = $_POST['data'];
$servico_tipo = $_POST['servico_tipo'];

$query = "SELECT s.*, b.nome AS b_nome FROM servicos s "
    . "LEFT JOIN beneficiados b ON b.codigo = s.beneficiado "
    . "WHERE s.data_agenda LIKE '%{$data}%' AND s.tipo = '{$servico_tipo}' ORDER BY data_agenda";

$result = mysql_query($query);


?>
<h1 class="h4 text-gray-600 my-1 mb-2">
    <?= date('d/m/Y', strtotime($data)); ?>
</h1>
<br>
<table class="table table-striped table-hover" style="font-size: .9rem;">
    <thead>
    <tr>
        <td>Horário</td>
        <td>Beneficiado</td>
        <td>Especialista</td>
        <td>Contato</td>
        <td>Situação</td>
        <td>Ações</td>
    </tr>
    </thead>
    <tbody>
    <?php
    if (mysql_num_rows($result)):
        while ($d = mysql_fetch_object($result)):
            $data = date('h:i', strtotime($d->data_agenda));
            ?>
            <tr>
                <td><?= $data; ?></td>
                <td class="text-center"><?= $d->b_nome; ?></td>
                <td class="text-center"><?= $d->especialista; ?></td>
                <td><?= $d->contato; ?></td>
                <td><?= $d->situacao; ?></td>
                <td>
                    <button type="button" class="btn btn-sm btn-link">
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
