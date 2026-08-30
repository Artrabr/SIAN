<?php
require_once __DIR__ . '/../data/conection.php';

function conectMYSQL(){
    return conection::conectar();
}

function desconectMYSQL(&$pdo){
    $pdo = null;
}

function sanitizeCpf($cpf) {
    return preg_replace('/\D+/', '', (string) $cpf);
}

function cpfauthorizated($pdo, $cpf) {
    $stmt = $pdo->prepare("SELECT cpf_atl FROM atl_authorized WHERE cpf_atl = :cpf");
    $stmt->execute(['cpf' => $cpf]);
    return $stmt->fetchColumn() !== false;
}

function authorizationCpf($pdo, $cpf){ //envia os dados para o banco de dados (tabela atl_authorized)
    $stmt = $pdo->prepare("INSERT INTO atl_authorized (cpf_atl) VALUES (:cpf)");
    $stmt->execute(['cpf' => $cpf]);
}

//========================================================================//
//                                CÓDIGO
//========================================================================//

$cpf = sanitizeCpf($_POST['cpf'] ?? '');

if ($cpf === '' || strlen($cpf) !== 11) { // ve se tem 11 carqcteres 
    header('Location: ../../frontend/authorization.php?erro=cpf_invalido');
    exit();
}

$pdo = conectMYSQL();

if (cpfauthorizated($pdo, $cpf)) {
    desconectMYSQL($pdo);
    header('Location: ../../frontend/authorization.php?erro=cpf_ja_autorizado');
    exit();
}

authorizationCpf($pdo, $cpf);
desconectMYSQL($pdo);

header('Location: ../../frontend/authorization.php?sucesso=cpf_autorizado');
exit();