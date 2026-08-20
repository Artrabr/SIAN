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
}

header("Location: ../../../../website/index.php?success=1");
exit();

/*create database sian;
use sian;
CREATE TABLE athletes (
    id_atl INT PRIMARY KEY AUTO_INCREMENT,
    name_atl VARCHAR(100) NOT NULL,
    gender_atl VARCHAR(12) NOT NULL
    number_atl INT not null,
    birth_atl DATE not null,
    sport_atl VARCHAR(150) not null,
    city_atl varchar(100)
);
CREATE TABLE payments (
    pgm_id INT PRIMARY KEY AUTO_INCREMENT,
    payday DATE NOT NULL,
    expired DATE NOT NULL,
    atl_id INT NOT NULL,
	FOREIGN KEY (atl_id) REFERENCES Atleta(id)
);
*/