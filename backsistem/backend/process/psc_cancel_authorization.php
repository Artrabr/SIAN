<?php
require_once __DIR__ . '/../data/conection.php';

function conectMYSQL(){
    return conection::conectar();
}

function desconectMYSQL($pdo){
    $pdo = null;
}

function sanitizeCpf($cpf) {
    return preg_replace('/\D+/', '', (string) $cpf);
}

function cancelarCpf($pdo, $cpf){
    $stmt = $pdo->prepare("UPDATE atl_authorized SET status = 0 WHERE cpf_atl = :cpf");
    $stmt->execute(['cpf' => $cpf]);
}

//========================================================================//
//                                CÓDIGO
//========================================================================//

$cpf = sanitizeCpf($_POST['cpf'] ?? '');

if ($cpf === '' || strlen($cpf) !== 11) {
    header('Location: ../../frontend/authorization.php?erro=cpf_invalido');
    exit();
}

$pdo = conectMYSQL();
cancelarCpf($pdo, $cpf);
desconectMYSQL($pdo);

header('Location: ../../frontend/authorization.php?sucesso=cpf_cancelado');
exit();
