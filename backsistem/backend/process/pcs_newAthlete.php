<?php
include_once __DIR__ . "/../data/conection.php";

//========================================================================//
//                               FUNÇÕES
//========================================================================//

function sanitizeCpf($cpf) {
    return preg_replace('/\D+/', '', (string) $cpf);
}

function validarCpf($cpf) {
    $cpf = sanitizeCpf($cpf);
    
    if (strlen($cpf) !== 11) {
        return false;
    }
    
    // Verifica se todos os dígitos são iguais
    if (preg_match('/^(\d)\1{10}$/', $cpf)) {
        return false;
    }
    
    return true;
}

function validarAlturaEmCm($altura) {
    if (filter_var($altura, FILTER_VALIDATE_INT) === false) {
        return false;
    }

    $altura = (int) $altura;
    return $altura >= 100 && $altura <= 250;
}

function checkData($data, array $fields) { 
    for($i = 0; $i < count($fields); $i++){
        if(empty($data[$fields[$i]])){
            return false;
        }
    }
    return true; 
}

function cpfJaExiste($pdo, $cpf) {
    $stmt = $pdo->prepare("SELECT id_atl FROM athlete WHERE cpf_atl = :cpf");
    $stmt->execute([':cpf' => $cpf]);
    return $stmt->fetchColumn() !== false;
}

function enviarDadosMYSQL($pdo, $data) {
    $cpf = sanitizeCpf($data['cpf']);
    
    $stmt = $pdo->prepare("INSERT INTO athlete
        (name_atl, contact_atl, birthDate_atl, position_atl, city_atl, hight_atl, instagram_atl, cpf_atl, payMethod_atl, gender_atl, team_atl)
        VALUES (:name, :contact, :birthDate, :position, :city, :hight, :instagram, :cpf, :payMethod, :gender, :team)");

    $stmt->execute([
        ':name' => trim($data['name']),
        ':contact' => trim($data['contact']),
        ':birthDate' => $data['birthDate'],
        ':position' => $data['position'],
        ':city' => $data['city'],
        ':hight' => (int) $data['hight'],
        ':instagram' => trim($data['instagram']),
        ':cpf' => $cpf,
        ':payMethod' => $data['payMethod'],
        ':gender' => $data['gender'],
        ':team' => $data['team']
    ]);
}

//========================================================================//
//                                CÓDIGO
//========================================================================//

$requiredFields = ['name','contact','birthDate','position','city','hight','instagram','cpf','payMethod','gender','team'];

if (!checkData($_POST, $requiredFields) || !validarAlturaEmCm($_POST['hight'])) {
    header("Location: ../../frontend/registration.php?error=invalid_data");
    exit();
}

if (!validarCpf($_POST['cpf'])) {
    header("Location: ../../frontend/registration.php?error=invalid_cpf");
    exit();
}

try {
    $pdo = conection::conectar();
    
    if (cpfJaExiste($pdo, $_POST['cpf'])) {
        header("Location: ../../frontend/registration.php?error=cpf_already_exists");
        exit();
    }
    
    enviarDadosMYSQL($pdo, $_POST);
    $pdo = null;
    
    header("Location: ../../frontend/registration.php?success=athlete_created");
    exit();
} catch (Exception $e) {
    header("Location: ../../frontend/registration.php?error=database_error");
    exit();
}
