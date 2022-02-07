<?php
include '../lib/includes.php';

$codigo = $_GET['codigo'];

$query = "SELECT s.*, b.nome AS b_nome, cpf,nome_mae, telefone, lf.descricao AS lf_descricao FROM servicos s "
    . "LEFT JOIN beneficiados b ON b.codigo = s.beneficiado "
    . "LEFT JOIN local_fontes lf ON lf.codigo = s.local_fonte "
    . "WHERE s.codigo = '{$codigo}'";

$result = mysql_query($query);

$d = mysql_fetch_object($result);
?>


<div class="container-fluid">

    <div>
        <h5 class="card-title text-gray-800">Informações do beneficiado</h5>

        <div class="row">
            <div class="col-md-3">
                <span class="font-weight-bold">Nome</span>
            </div>
            <div class="col-md-9">
                <?= $d->b_nome; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <span class="font-weight-bold">Nome da mãe</span>
            </div>
            <div class="col-md-9">
                <?= $d->nome_mae; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <span class="font-weight-bold">Contato</span>
            </div>
            <div class="col-md-9">
                <?= $d->telefone; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <span class="font-weight-bold">CPF</span>
            </div>
            <div class="col-md-9">
                <?= $d->cpf; ?>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <h5 class="card-title text-gray-800">Informações do serviço</h5>

        <div class="row">
            <div class="col-md-3">
                <span class="font-weight-bold">Especialista</span>
            </div>
            <div class="col-md-9">
                <?= $d->especialista; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <span class="font-weight-bold">Local/Fonte</span>
            </div>
            <div class="col-md-9">
                <?= $d->lf_descricao; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <span class="font-weight-bold">Data da agenda</span>
            </div>
            <div class="col-md-9">
                <?= formata_datahora($d->data_agenda, DATA_HM) ?>
            </div>
        </div>

    </div>
</div>

<hr>

<div class="float-right">
    <button class="btn btn-info btn-sm">
        <i class="fa-solid fa-print"></i> Imprimir
    </button>
</div>