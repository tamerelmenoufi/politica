<?php

include "config_beneficiados.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    $attr = [];

    $codigo = $data['codigo'] ?: null;

    unset($data['codigo']);

    if (!$codigo) $data['data_cadastro'] = 'NOW()';

    foreach ($data as $name => $value) {
        $attr[] = "{$name} = '" . mysql_real_escape_string($value) . "'";
    }

    $attr = implode(', ', $attr);

    if ($codigo) {
        $query = "UPDATE beneficiados SET {$attr} WHERE codigo = '{$codigo}'";
    } else {
        $query = "INSERT INTO beneficiados SET {$attr}";
    }

    if (mysql_query($query)) {
        $codigo = $codigo ?: mysql_insert_id();

        sis_logs('beneficiados', $codigo, $query);

        echo json_encode([
            'status' => true,
            'msg' => 'Dados salvo com sucesso',
            'codigo' => $codigo,
        ]);
    } else {
        echo json_encode([
            'status' => false,
            'msg' => 'Erro ao salvar',
            'codigo' => $codigo,
            'mysql_error' => mysql_error(),
        ]);
    }

    exit;
}


?>
        <form id="form-beneficiados">
            <div class="form-group">
                <label for="nome">Nome <i class="text-danger">*</i></label>
                <input
                        type="text"
                        class="form-control"
                        id="nome"
                        name="nome"
                        value="<?= $d->nome; ?>"
                        required
                >
            </div>

            <div class="form-group">
                <label for="nome_mae">Nome da mãe <i class="text-danger">*</i></label>
                <input
                        type="text"
                        class="form-control"
                        id="nome_mae"
                        name="nome_mae"
                        value="<?= $d->nome_mae; ?>"
                        required
                >
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="cpf">CPF <i class="text-danger">*</i></label>
                        <input
                                type="text"
                                class="form-control"
                                id="cpf"
                                name="cpf"
                                value="<?= $d->cpf; ?>"
                                required
                        >

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="data_nascimento">
                            Data de Nascimento <i class="text-danger">*</i>
                        </label>
                        <input
                                type="date"
                                class="form-control"
                                id="data_nascimento"
                                name="data_nascimento"
                                value="<?= $d->data_nascimento; ?>"
                                required
                        >

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="sexo">Sexo <i class="text-danger">*</i></label>
                        <select
                                class="form-control"
                                id="sexo"
                                name="sexo"
                                required
                        >
                            <option value=""></option>
                            <?php foreach (getSexo() as $key => $sexo) : ?>
                                <option
                                    <?= ($codigo and $d->sexo == $key) ? "selected" : ""; ?>
                                        value="<?= $key; ?>"
                                >
                                    <?= $sexo; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="email">
                            E-Mail <i class="text-danger">*</i>
                        </label>
                        <input
                                type="email"
                                class="form-control"
                                id="email"
                                name="email"
                                value="<?= $d->email; ?>"
                                required
                        >

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="telefone">
                            Telefone <i class="text-danger">*</i>
                        </label>
                        <input
                                type="text"
                                class="form-control"
                                id="telefone"
                                name="telefone"
                                value="<?= $d->telefone; ?>"
                                required
                        >

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="municipio">
                            Municipio <i class="text-danger">*</i>
                        </label>
                        <select
                                class="form-control"
                                id="municipio"
                                name="municipio"
                                data-live-search="true"
                                required
                        >
                            <option value=""></option>
                            <?php
                            $query = "SELECT * FROM municipios";
                            $result = mysql_query($query);

                            while ($m = mysql_fetch_object($result)): ?>
                                <option
                                    <?= ($codigo and $d->municipio == $m->codigo) ? 'selected' : ''; ?>
                                        value="<?= $m->codigo ?>">
                                    <?= $m->municipio; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cpf">
                            CEP <i class="text-danger">*</i>
                        </label>
                        <input
                                type="text"
                                class="form-control"
                                id="cep"
                                name="cep"
                                value="<?= $d->cep; ?>"
                                required
                        >

                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="endereco">
                    Endereco <i class="text-danger">*</i>
                </label>
                <input
                        type="text"
                        class="form-control"
                        id="endereco"
                        name="endereco"
                        value=" <?= $d->endereco; ?>"
                        required
                >

            </div>

            <button type="submit" class="btn btn-success">Salvar</button>
        </form>

<script>
    $(function () {
        $('#cpf').mask('999.999.999-99');

        $('#cep').mask('99999-999');

        $('#telefone').mask('(99) 9999-9999');

        $('#municipio').selectpicker();

        $('#form-beneficiados').validate();

        $("#cep").blur(function () {
            var cep = $(this).val().replace(/\D/g, '');

            if (cep != "") {
                //Expressão regular para validar o CEP.
                var validacep = /^[0-9]{8}$/;

                if (validacep.test(cep)) {
                    $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {
                        if (!("erro" in dados)) {
                            $("#endereco").val(`${dados.logradouro}, ${dados.bairro}`);
                        } //end if.
                        else {
                            $("#endereco").val("");
                        }
                    });
                }

            }
        });

        $('#form-beneficiados').submit(function (e) {
            e.preventDefault();

            if (!$(this).valid()) return false;

            var codigo = $('#codigo').val();
            var dados = $(this).serializeArray();

            if (codigo) {
                dados.push({name: 'codigo', value: codigo})
            }

            $.ajax({
                url: '<?= $urlBeneficiados; ?>/form.php',
                method: 'POST',
                data: dados,
                success: function (response) {
                    let retorno = JSON.parse(response);

                    if (retorno.status) {
                        tata.success('Sucesso', retorno.msg);

                        // $.ajax({
                        //     url: '<?= $urlBeneficiados; ?>/visualizar.php',
                        //     data: {codigo: retorno.codigo},
                        //     success: function (response) {
                        //         $('#palco').html(response);
                        //     }
                        // })

                    } else {
                        tata.error('Error', retorno.msg);
                    }
                }
            })
        });
    });
</script>



