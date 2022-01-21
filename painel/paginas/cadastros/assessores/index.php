<?php
include "config_assessores.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' and $_POST['acao'] === 'excluir') {
    $codigo = $_POST['codigo'];
    $query = "DELETE FROM assessores WHERE codigo = '{$codigo}'";

    if (mysql_query($query)) {
        echo json_encode(["status" => true, "msg" => "Registro excluído com sucesso"]);
    } else {
        echo json_encode(["status" => false, "msg" => "Error ao tentar excluír"]);
    }
    exit;
}

$query = "SELECT * FROM assessores";
$result = mysql_query($query);

?>

<!--<h1 class="h3 mb-2 text-gray-800">Assessores</h1>-->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb shadow bg-gray-custom">
        <li class="breadcrumb-item"><a href="#" url="content.php">Início</a></li>
        <li class="breadcrumb-item active" aria-current="page">Assessores</li>
    </ol>
</nav>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">
            Assessores
        </h6>

        <button type="button" class="btn btn-success btn-sm" url="paginas/cadastros/assessores/form.php">
            <i class="fa-solid fa-plus"></i> Novo
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">

            <table id="datatable" class="table" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th class="mw-20">Ações</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($d = mysql_fetch_object($result)): ?>
                    <tr id="linha-<?= $d->codigo; ?>">
                        <td><?= $d->nome ?></td>
                        <td><?= $d->cpf; ?></td>
                        <td>
                            <button
                                    class="btn btn-sm btn-link"
                                    url="<?= $urlAssessores ?>/visualizar.php?codigo=<?= $d->codigo ?>"
                            >
                                <i class="fa-regular fa-eye text-info"></i>
                            </button>
                            <button
                                    class="btn btn-sm btn-link"
                                    url="<?= $urlAssessores ?>/form.php?codigo=<?= $d->codigo; ?>"
                            >
                                <i class="fa-solid fa-pencil text-warning"></i>
                            </button>
                            <button
                                    class="btn btn-sm btn-link btn-excluir"
                                    data-codigo="<?= $d->codigo ?>"
                            >
                                <i class="fa-regular fa-trash-can text-danger"></i>
                            </button>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>

            </table>
        </div>
    </div>
</div>

<script>
    $(function () {
        $("#datatable").DataTable();

        $('.btn-excluir').click(function () {
            var codigo = $(this).data('codigo');

            $.confirm({
                title: 'Aviso',
                content: 'Deseja excluir este registro?',
                type: 'red',
                icon: 'fa fa-warning',
                buttons: {
                    sim: {
                        text: 'Sim',
                        btnClass: 'btn-red',
                        action: function () {
                            $.ajax({
                                url: '<?= $urlAssessores;?>/index.php',
                                method: 'POST',
                                data: {
                                    acao: 'excluir',
                                    codigo
                                },
                                success: function (response) {
                                    let retorno = JSON.parse(response);

                                    if (retorno.status) {
                                        tata.success('Sucesso', retorno.msg);
                                    } else {
                                        tata.error('Error', retorno.msg);
                                    }

                                    $(`#linha-${codigo}`).remove();
                                }
                            })
                        }
                    },
                    nao: {
                        text: 'Não'
                    }
                }
            })
        });
    });
</script>