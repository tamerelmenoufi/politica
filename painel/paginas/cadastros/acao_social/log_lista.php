<?php
include "config_acao_social.php";

$codigo = $_GET['codigo'];

if ($codigo) {
    $d = ListaLogs('acao_social', $codigo);
}
print_r($d);
?>
<style>
    .jconfirm .jconfirm-box div.jconfirm-closeIcon{
        right:35px;
    }
</style>
<div class="card shadow mb-4" style="margin:20px;">
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Operação</th>
                    <th>Usuário</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Data</td>
                    <td>Operação</td>
                    <td>Usuário</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(function () {



    });
</script>



