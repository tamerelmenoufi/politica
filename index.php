<?php
include "lib/includes.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Politica TESTE</title>
    <meta charset="UTF-8">
    <meta name="description" content="Sistema de Gerenciamento">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow">
    <?php include "lib/header.php"; ?>
</head>

<body>

</body>

<script src="<?= $caminho_vendor; ?>/jquery/jquery.min.js"></script>

<script src="<?= $caminho_vendor; ?>/bootstrap4/js/bootstrap.bundle.min.js"></script>
<script src="<?= $caminho_vendor; ?>/startbootstrap-sb-admin-2/js/sb-admin-2.min.js"></script>
<script>
    $(function () {
        $('body').load('autenticacao/login.php');
    });
</script>
</html>
