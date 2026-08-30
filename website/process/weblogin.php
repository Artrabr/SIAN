<?php

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
    $stmt = $pdo->prepare("SELECT cpf_atl, password_atl FROM athlete WHERE cpf_atl = :cpf");
    $stmt->execute(['cpf' => $cpf]);
    $user = $stmt->fetch();

    if (!$user) {
        return false;
    }

    $continueToLogin = verifyDataMatch($user, $cpf, $password); //retorna se ta correto ou nao o login e senha

    if($continueToLogin){ //lança a resposta
        return true;
    }
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
    header('Location:' . $locate);
}

function giveSession($client){
    $_SESSION['user'] = $client;
}

//========================================================================//
//                                CÓDIGO
//========================================================================//

if (checkData($_POST, ['cpf','password'] )) {
    $pdo = conectMYSQL();

    $cpf = sanitizeCpf($_POST['cpf']);
    $continueLogin = checkLogin($pdo, $cpf, $_POST['password']); //verifica se o login ta certo e retorna true

    if($continueLogin == true){
        giveSession($cpf);
        desconectMYSQL($pdo);
        redirectPage('clientArea.php');
        exit();
    }

    desconectMYSQL($pdo);
    redirectPage('../index.php');
    exit();
}