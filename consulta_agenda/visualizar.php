<?php
include '../lib/includes.php';

$codigo = $_GET['codigo'];

$query = "SELECT s.*, b.nome AS b_nome, cpf,nome_mae, data_nascimento, telefone, lf.descricao AS lf_descricao, st.tipo AS st_tipo FROM servicos s "
    . "LEFT JOIN beneficiados b ON b.codigo = s.beneficiado "
    . "LEFT JOIN local_fontes lf ON lf.codigo = s.local_fonte "
    . "LEFT JOIN servico_tipo st ON st.codigo = s.tipo "
    . "WHERE s.codigo = '{$codigo}'";

$result = mysql_query($query);

$d = mysql_fetch_object($result);
?>


<div class="container-fluid">

    <div class="row">
        <div class="col-md-12 my-2">
            <div class="float-right">
                <button class="btn btn-info btn-sm">
                    <i class="fa-solid fa-print"></i> Imprimir
                </button>
            </div>
        </div>
    </div>
    <hr>
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
                <span class="font-weight-bold">CPF</span>
            </div>
            <div class="col-md-9">
                <?= $d->cpf; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <span class="font-weight-bold">Data de nasc.</span>
            </div>
            <div class="col-md-9">
                <?= formata_datahora($d->data_nascimento, DATA); ?>
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
    </div>

    <div class="mt-4 mb-4">
        <h5 class="card-title text-gray-800">Informações do Agendamento</h5>

        <div class="row">
            <div class="col-md-3">
                <span class="font-weight-bold">Tipo de serviço</span>
            </div>
            <div class="col-md-9">
                <?= $d->st_tipo; ?>
            </div>
        </div>

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

        <div class="row">
            <div class="col-md-3">
                <span class="font-weight-bold">Situação</span>
            </div>
            <div class="col-md-9">
                <?= ucfirst($d->situacao); ?>
            </div>
        </div>

        <?php if ($d->detalhes): ?>
            <div class="row">
                <div class="col-md-3">
                    <span class="font-weight-bold">Detalhes</span>
                </div>
                <div class="col-md-9">
                    <?= ucfirst($d->detalhes); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
