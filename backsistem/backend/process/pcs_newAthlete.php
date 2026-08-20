<?php
include_once __DIR__ . "/../data/conection.php";

function validateFormData($data) {
    return !empty($data['name'])
        && !empty($data['contact'])
        && !empty($data['birthDate'])
        && !empty($data['position'])
        && !empty($data['city'])
        && isset($data['hight'])
        && is_numeric($data['hight'])
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
        ':hight' => (float) $data['hight'],
        ':instagram' => trim($data['instagram']),
        ':cpf' => trim($data['cpf']),
        ':payMethod' => $data['payMethod'],
        ':gender' => $data['gender'],
        ':team' => $data['team']
    ]);
}

if (!validateFormData($_POST)) {
    header("Location: ../../frontend/registration.php?error=invalid_data");
    exit();
}

enviarDadosMYSQL(conection::conectar(), $_POST);
header("Location: ../../frontend/registration.php?success=1");
exit();

/*
CREATE TABLE athlete (
    id_atl INT PRIMARY KEY AUTO_INCREMENT,
    name_atl VARCHAR(100) NOT NULL,
    contact_atl VARCHAR(100) NOT NULL,
    birthDate_atl DATE NOT NULL,
    position_atl VARCHAR(150) NOT NULL,
    city_atl VARCHAR(100) NOT NULL,
    hight_atl DECIMAL(3,2) NOT NULL,
    instagram_atl VARCHAR(100) NOT NULL,
    cpf_atl VARCHAR(14) NOT NULL,
    payMethod_atl VARCHAR(50) NOT NULL,
    gender_atl VARCHAR(20) NOT NULL,
    team_atl VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE payments (
    pgm_id INT PRIMARY KEY AUTO_INCREMENT,
    payday DATE NOT NULL,
    expired DATE NOT NULL,
    atl_id INT NOT NULL,
    FOREIGN KEY (atl_id) REFERENCES athlete(id_atl)
);
*/
?>