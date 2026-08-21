<?php

require_once __DIR__ . "/../../data/conection.php";

function validateFormData($data) {
    return !empty($data['name'])
        && !empty($data['gender'])
        && !empty($data['contact'])
        && !empty($data['birthDate'])
        && !empty($data['position'])
        && !empty($data['city'])
        && !empty($data['hight'])
        && !empty($data['instagram']);
}

function conectar() {
    return conection::conectar();
}

function enviarDadosMYSQL($pdo, $name, $gender, $contact, $birthDate, $position, $city, $hight, $instagram) {
    $stmt = $pdo->prepare("INSERT INTO candidates (name_cdt, gender_cdt, contact_cdt, birthDate_cdt, position_cdt, city_cdt, hight_cdt, instagram_cdt)
    VALUES (:name, :gender, :contact, :birthDate, :position, :city, :hight, :instagram)");

    $stmt->execute([
        ':name'      => $name,
        ':gender'    => $gender,
        ':contact'   => $contact,
        ':birthDate' => $birthDate,
        ':position'  => $position,
        ':city'      => $city,
        ':hight'     => $hight,
        ':instagram' => $instagram
    ]);
}
//========================================================================//
//                                CÓDIGO
//========================================================================//

if (validateFormData($_POST)) {
    $name       = $_POST['name'];
    $gender     = $_POST['gender'];
    $contact    = $_POST['contact'];
    $birthDate  = $_POST['birthDate'];
    $position   = $_POST['position'];
    $city       = $_POST['city'];
    $hight      = $_POST['hight'];
    $instagram  = $_POST['instagram'];

    $pdo = conectar();
    enviarDadosMYSQL($pdo, $name, $gender, $contact, $birthDate, $position, $city, $hight, $instagram);
    $pdo = null;
} else {
    header("Location: ../../../../website/index.php?error=invalid_data");
    exit();
}

header("Location: ../../../../website/index.php?success=1");
exit();