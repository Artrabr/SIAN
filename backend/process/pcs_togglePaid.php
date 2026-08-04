<?php

$arquivo = __DIR__ . "/../data/DataAthlete.csv";

if (!file_exists($arquivo)) {
    header("Location: ../../frontend/lists.php?error=csv_missing");
    exit;
}

if (!isset($_POST['id'], $_POST['paid'])) {
    header("Location: ../../frontend/lists.php?error=invalid_request");
    exit;
}

$id = (int) $_POST['id'];
$paid = strtolower($_POST['paid']) === 'true';

$linhas = [];
if (($handle = fopen($arquivo, 'r')) !== false) {
    while (($dados = fgetcsv($handle, 1000, ',')) !== false) {
        $linhas[] = $dados;
    }
    fclose($handle);
}

if (count($linhas) <= 1) {
    header("Location: ../../frontend/lists.php?error=no_data");
    exit;
}

$cabecalho = array_shift($linhas);
$alterado = false;

foreach ($linhas as &$linha) {
    if (isset($linha[0]) && (int) $linha[0] === $id) {
        $linha[6] = $paid ? 'true' : 'false';
        $alterado = true;
        break;
    }
}
unset($linha);

if ($alterado && ($handle = fopen($arquivo, 'w')) !== false) {
    fputcsv($handle, $cabecalho);
    foreach ($linhas as $linha) {
        fputcsv($handle, $linha);
    }
    fclose($handle);
}

header("Location: ../../frontend/lists.php");
exit;
