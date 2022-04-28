<?php
include "config_beneficiados.php";

$column = [
    'nome',
    'cpf',
    'municipio'
];

$query = "SELECT b.*, m.municipio AS municipio FROM beneficiados b "
    . "LEFT JOIN municipios m ON m.codigo = b.municipio "
    . "WHERE b.deletado = '0' ";

$result = mysql_query($query);

if (isset($_POST["search"]["value"])) {
    $valor = trim($_POST["search"]["value"]);

    $query .= "AND (b.nome LIKE '%{$valor}%' "
        . "OR b.cpf LIKE '%{$valor}%' "
        . "OR m.municipio LIKE '%{$valor}%') ";
}

if (isset($_POST['order'])) {
    $query .= 'ORDER BY ' . $column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';
} else {
    $query .= ' ORDER BY b.codigo DESC ';
}

$query1 = '';

if ($_POST['length'] != -1) $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];

$result = mysql_query($query);

$number_filter_row = mysql_num_rows($result);

$result1 = mysql_query($query . $query1);

$data = [];

while ($row = mysql_fetch_array($result1)) {
    $sub_array = [];

    $btn_acoes = '<button class="btn btn-sm btn-link" url="' . $urlBeneficiados . '/visualizar.php?codigo=' . $row['codigo'] . '">
                        <i class="fa-regular fa-eye text-info"></i>
                   </button>';

    if (in_array('Beneficiados - Editar', $ConfPermissoes)) {
        $btn_acoes .= '<button class="btn btn-sm btn-link" url="' . $urlBeneficiados . '/form.php?codigo=' . $row['codigo'] . '">
                        <i class="fa-solid fa-pencil text-warning"></i>
                    </button>';
    }

    if (in_array('Beneficiados - Excluir', $ConfPermissoes)) {
        $btn_acoes .= '<button class="btn btn-sm btn-link btn-excluir" data-codigo="' . $row['codigo'] . '">
                        <i class="fa-regular fa-trash-can text-danger"></i>
                   </button>';
    }

    $sub_array[] = $row['nome'];
    $sub_array[] = $row['cpf'];
    $sub_array[] = $row['municipio'];
    $sub_array[] = $btn_acoes;

    $data[] = $sub_array;
}

// @formatter:off
$output = [
    "draw"            => intval($_POST["draw"]),
    "recordsTotal"    => count_all_data(),
    "recordsFiltered" => $number_filter_row,
    "data"            => $data
];
// @formatter:on

echo json_encode($output);
exit();

function count_all_data()
{
    $query = "SELECT COUNT(codigo) FROM beneficiados WHERE deletado != '1'";
    $result = mysql_query($query);
    list($qtd) = mysql_fetch_row($result);
    return $qtd;
}