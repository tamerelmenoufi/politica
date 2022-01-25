<?php
include "config_usuarios.php";

$codigo = $_GET['codigo'];
$query = "SELECT u.* FROM usuarios u "
    . "WHERE u.codigo = '{$codigo}'";
$result = mysql_query($query);
$d = mysql_fetch_object($result);

?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb shadow bg-gray-custom">
        <li class="breadcrumb-item"><a href="#" url="content.php">Início</a></li>
        <li class="breadcrumb-item" aria-current="page">
            <a href="#" url="<?= $urlUsuarios; ?>/index.php">Usuários</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            Visualizar
        </li>
    </ol>
</nav>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-md-row flex-column align-items-center justify-content-md-between">
        <h6 class="m-0 font-weight-bold text-primary">
            Visualizar
        </h6>
        <div class="d-md-flex justify-content-xl-center">
            <button
                    type="button"
                    class="btn btn-success btn-sm float-left"
                    url="<?= $urlUsuarios ?>/form.php"
                    style="margin-right: 2px"
            >
                <i class="fa-solid fa-plus"></i> Novo
            </button>
            <button
                    type="button"
                    class="btn btn-warning btn-sm float-left"
                    url="<?= $urlUsuarios ?>/form.php?codigo=<?= $codigo; ?>"
                    style="margin-right: 2px"
            >
                <i class="fa-solid fa-pencil"></i> Editar
            </button>
            <button
                    type="button"
                    class="btn btn-danger btn-excluir btn-sm float-left"
                    data-codigo="<?= $codigo; ?>"
            >
                <i class="fa-regular fa-trash-can"></i> Excluir
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 font-weight-bold">Nome</div>
            <div class="col-md-8"><?= $d->nome; ?></div>
        </div>
        <div class="row">
            <div class="col-md-4 font-weight-bold">Usuário</div>
            <div class="col-md-8"><?= $d->usuario; ?></div>
        </div>
        <div class="row">
            <div class="col-md-4 font-weight-bold">Criado em</div>
            <div class="col-md-8"><?= formata_datahora($d->data_cadastro, DATA_HM); ?></div>
        </div>
        <div class="row">
            <div class="col-md-4 font-weight-bold">Status</div>
            <div class="col-md-8"><?= getSituacaoOptions($d->status); ?></div>
        </div>
    </div>
</div>

<script>
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
                            url: '<?= $urlUsuarios;?>/index.php',
                            method: 'POST',
                            data: {
                                acao: 'excluir',
                                codigo
                            },
                            success: function (response) {
                                let retorno = JSON.parse(response);

                                if (retorno.status) {
                                    tata.success('Sucesso', retorno.msg);

                                    $.ajax({
                                        url: '<?= $urlUsuarios; ?>/index.php',
                                        success: function (response) {
                                            $('#palco').html(response);
                                        }
                                    });
                                } else {
                                    tata.error('Error', retorno.msg);
                                }
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
</script>
