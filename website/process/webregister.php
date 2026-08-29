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


//========================================================================//
//                                CÓDIGO
//========================================================================//

if(checkData($_POST, [])){

}