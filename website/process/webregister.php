<?php
require_once __DIR__ . '/../../backsistem/backend/data/conection.php';

function checkData($data, array $value){ 

    for($i = 0; $i < count($value); $i++){
        if(empty($data[$value[$i]])){
            return false;
        }
    }
    return true; 
}

function nameofthefunction(){
    //code    
}

function nameofthefunction(){
    //code
}

function cpfAutorizado($pdo, $cpf){ // retorna o cpf ['cpf_atl' = '123.123.123-09'] ou retorna false
    $stmt = $pdo->prepare("SELECT cpf_atl FROM atl_authorized WHERE cpf_atl = :cpf");
    $stmt->execute(['cpf' => $cpf]);
    return (bool) $stmt->fetch();
}


//========================================================================//
//                                CÓDIGO
//========================================================================//

if(checkData($_POST, [])){

}