<?php
require_once __DIR__ . '/../data/conection.php';

function conectMYSQL(){
    return conection::conectar();
}

function desconectMYSQL(&$pdo){
    $pdo = null;
}

function autorizarCpf($pdo, $cpf){
    $stmt = $pdo->prepare("INSERT INTO atl_authorized (cpf_atl) VALUES (:cpf)");
    $stmt->execute(['cpf' => $cpf]);
}

//========================================================================//
//                                CÓDIGO
//========================================================================//

$cpf = $_POST['cpf'] ?? null;

if (!$cpf) {
    header('Location: painel.php?erro=cpf_vazio');
    exit();
}

$pdo = conectMYSQL();
autorizarCpf($pdo, $cpf);
desconectMYSQL($pdo);

header('Location: painel.php?sucesso=cpf_autorizado');
exit();