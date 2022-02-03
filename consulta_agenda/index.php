<?php
include "../lib/includes.php";
?>

<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta
            name="viewport"
            content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
    >
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Consultar agenda</title>

    <?php include "../lib/header.php"; ?>
    <link rel="stylesheet" href="<?= $caminho_vendor; ?>/fullcalendar/lib/main.min.css">

    <script src="<?= $caminho_vendor; ?>/jquery/jquery.min.js"></script>
    <script src="<?= $caminho_vendor; ?>/bootstrap4/js/bootstrap.bundle.min.js"></script>
    <script src="<?= $caminho_vendor; ?>/fullcalendar/lib/main.min.js"></script>
    <script src="<?= $caminho_vendor; ?>/fullcalendar/lib/locales-all.min.js"></script>
    <script src="<?= $caminho_vendor; ?>/tata/tata.js"></script>
    <script src="<?= $caminho_vendor; ?>/tata/index.js"></script>
</head>
<body>

<div id="palco-agenda">
    <?php include 'content.php'; ?>
</div>

</body>
</html>
