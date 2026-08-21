<?php
include_once __DIR__ . "/../data/conection.php";

//========================================================================//
//                               FUNÇÕES
//========================================================================//

function validarAlturaEmCm($altura) {
    if (filter_var($altura, FILTER_VALIDATE_INT) === false) {
        return false;
    }

    $altura = (int) $altura;
    return $altura >= 100 && $altura <= 250;
}

function validateFormData($data) {
    return !empty($data['name'])
        && !empty($data['contact'])
        && !empty($data['birthDate'])
        && !empty($data['position'])
        && !empty($data['city'])
        && isset($data['hight'])
        && validarAlturaEmCm($data['hight'])
        && !empty($data['instagram'])
        && !empty($data['cpf'])
        && !empty($data['payMethod'])
        && !empty($data['gender'])
        && !empty($data['team']);
}

function enviarDadosMYSQL($pdo, $data) {
    $stmt = $pdo->prepare("INSERT INTO athlete
        (name_atl, contact_atl, birthDate_atl, position_atl, city_atl,
         hight_atl, instagram_atl, cpf_atl, payMethod_atl, gender_atl, team_atl)
        VALUES (:name, :contact, :birthDate, :position, :city, :hight,
                :instagram, :cpf, :payMethod, :gender, :team)");

    $stmt->execute([
        ':name' => trim($data['name']),
        ':contact' => trim($data['contact']),
        ':birthDate' => $data['birthDate'],
        ':position' => $data['position'],
        ':city' => $data['city'],
        ':hight' => (int) $data['hight'],
        ':instagram' => trim($data['instagram']),
        ':cpf' => trim($data['cpf']),
        ':payMethod' => $data['payMethod'],
        ':gender' => $data['gender'],
        ':team' => $data['team']
    ]);
}

//========================================================================//
//                                CÓDIGO
//========================================================================//

if (!validateFormData($_POST)) {
    header("Location: ../../frontend/registration.php?error=invalid_data");
    exit();
}

enviarDadosMYSQL(conection::conectar(), $_POST);
header("Location: ../../frontend/registration.php?success=1");
exit();