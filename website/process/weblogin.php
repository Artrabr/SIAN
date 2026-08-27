<?php

require_once __DIR__ . '/../../backsistem/backend/data/conection.php';

function checkData($data){
    return !empty($data['name'])
        && !empty($data['gender'])
        && !empty($data['contact'])
        && !empty($data['birthDate'])
        && !empty($data['position'])
        && !empty($data['city'])
        && !empty($data['hight'])
        && !empty($data['instagram']);
}

function conectMYSQL(){
    return conection::conectar();
}

function checkLogin($pdo, $usuario, $senha){
    // Implementar depois que usuario e senha existirem no banco.
    return false;
}

function desconectMYSQL(&$pdo){
    $pdo = null;
}

function verificatePayment($atlId, $pdo){
    // Implementar quando o painel precisar consultar pagamentos.
    return null;
}

function verificateNextTraining($teamId, $pdo){
    // Implementar quando existir a tabela de treinos.
    return null;
}

function createAtlete($data){
    return [
        'nome' => $data['nome'],
        'posicao' => $data['posicao'],
        'equipe' => $data['equipe'],
        'instagram' => $data['instagram']  ?? '',
        'foto' => $data['foto'] ?? '',
        'financeiro' => $data['financeiro'],
        'proximo_treino' => $data['proximo_treino']
    ];
}


//========================================================================//
//                                CÓDIGO
//========================================================================//

if(checkData($_POST)){
    $pdo = conectMYSQL();

    if(checkLogin($pdo, $_POST['usuario'] ?? '', $_POST['senha'] ?? '')){
        createAtlete($_POST);
    }else{
        desconectMYSQL($pdo);
        header('Location: ../index.php?loginerror=0');
        exit();
    }

    desconectMYSQL($pdo);
    header('Location: ../index.php');
    exit();
}

header('Location: ../index.php?loginerror=invalid_data');
exit();