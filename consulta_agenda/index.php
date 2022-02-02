<?php
include "../lib/includes.php";
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Consultar agenda</title>
    <?php include "../lib/header.php"; ?>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9 mt-5">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body">
                    <h1 class="h3 text-gray-800 text-center">Consultar agendamentos</h1>
                    <hr class="mb-5">

                    <form id="form-consulta" action="">

                        <div class="form-group row">
                            <label for="nome" class="col-lg-2 col-form-label">Tipo de serviço</label>
                            <div class="col-lg-10">
                                <select
                                        class="form-control"
                                        id="tipo_servico"
                                >
                                    <option value=""></option>
                                    <?php
                                    $query = "SELECT * FROM servico_tipo WHERE deletado = '0' ORDER BY tipo";
                                    $result = mysql_query($query);

                                    while ($d = mysql_fetch_object($result)): ?>
                                        <option value="<?= $d->codigo ?>"><?= $d->tipo; ?></option>
                                    <?php endwhile; ?>
                                </select>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nome" class="col-lg-2 col-form-label">Chave de Acesso</label>
                            <div class="col-lg-10">
                                <input
                                        type="text"
                                        class="form-control"
                                        id="senha"
                                        name="senha"
                                >
                            </div>
                        </div>

                        <div class="form-group float-right mt-4">
                            <button type="submit" class="btn btn-success">Consultar</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
