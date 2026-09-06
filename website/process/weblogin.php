<?php

ini_set('session.use_strict_mode', '1');
session_set_cookie_params([
    'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    'httponly' => true,
    'samesite' => 'Lax',
]);
session_start();

require_once __DIR__ . '/../../backsistem/backend/data/conection.php';

function checkData($data, array $value){ 

    for($i = 0; $i < count($value); $i++){
        if(empty($data[$value[$i]])){
            return false;
        }
    }
    return true; 
}

function conectMYSQL(){ 
    return conection::conectar();
}

function desconectMYSQL(&$pdo){ 
    $pdo = null;
}

function sanitizeCpf($cpf) {
    return preg_replace('/\D+/', '', (string) $cpf);
}

function checkLogin($pdo, $cpf, $password){  //REQUIRED verifyDataMatch 
    $stmt = $pdo->prepare("SELECT id_atl, cpf_atl, password_atl FROM athlete WHERE cpf_atl = :cpf");
    $stmt->execute(['cpf' => $cpf]);
    $user = $stmt->fetch();

    if (!$user) {
        error_log('Login recusado: CPF nao encontrado.');
        return false;
    }

    $continueToLogin = verifyDataMatch($user, $cpf, $password); //retorna se ta correto ou nao o login e senha

    if($continueToLogin){ //lança a resposta
        return $user;
    }

    error_log('Login recusado: senha invalida para CPF cadastrado.');
    return false;
}

function verifyDataMatch(array $data, $user, $password){ //criada para apoio da funcao checklogin
    if(
        password_verify($password, $data['password_atl']) == true &&
        $data['cpf_atl'] == $user
    ){
        return true;
    }else{
        return false;
    }
}

function redirectPage($locate){
    header('Location: ' . $locate);
    exit();
}

function giveSession(array $client){
    session_regenerate_id(true);
    $_SESSION['id_atl'] = (int) $client['id_atl'];
}

//========================================================================//
//                                CÓDIGO
//========================================================================//

try {
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !checkData($_POST, ['cpf', 'password'])) {
    redirectPage('../index.php?login=invalid01');
}

$cpf = sanitizeCpf($_POST['cpf']);
if (strlen($cpf) !== 11 || preg_match('/^(\d)\1{10}$/', $cpf)) {
    redirectPage('../index.php?login=invalid02');
}

if (checkData($_POST, ['cpf', 'password'])) {
    $pdo = conectMYSQL();

    $continueLogin = checkLogin($pdo, $cpf, $_POST['password']); //verifica se o login ta certo e retorna true

    if($continueLogin !== false){
        giveSession($continueLogin);
        desconectMYSQL($pdo);
        redirectPage('../clientArea.php');
    }

    desconectMYSQL($pdo);
    redirectPage('../index.php?login=invalid');
}
} catch (Throwable $e) {
    error_log('Falha no login: ' . $e->getMessage());
    if (isset($pdo)) {
        desconectMYSQL($pdo);
    }
    redirectPage('../index.php?login=error');
}