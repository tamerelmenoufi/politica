<?php
    include "../../../lib/includes.php";


    $query = "SELECT * FROM beneficiados ORDER BY nome";
    $result = mysql_query($query);

    while ($b = mysql_fetch_object($result)): ?>
        <p <?= $b->codigo?>><?= $b->nome; ?></p>
<?php endwhile; ?>
