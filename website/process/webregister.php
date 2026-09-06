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

function cpfAutorizado($pdo, $cpf){ // retorna o cpf ['cpf_atl' = '123.123.123-09'] ou retorna false
    $cpf = sanitizeCpf($cpf);
    $stmt = $pdo->prepare("SELECT cpf_atl FROM atl_authorized WHERE cpf_atl = :cpf");
    $stmt->execute(['cpf' => $cpf]);
    return (bool) $stmt->fetch();
}

//========================================================================//
//                                CÓDIGO
//========================================================================//

$requiredFields = ['cpf', 'password', 'name', 'contact', 'birthDate', 'position', 'city', 'hight', 'payMethod', 'gender', 'team'];

if(!checkData($_POST, $requiredFields)) {
    header("Location: ../clientRegister.php?error=invalid_data");
    exit();
}

if (!validarCpf($_POST['cpf'])) {
    header("Location: ../clientRegister.php?error=invalid_cpf");
    exit();
}

try {
    $pdo = conection::conectar();
    
    $cpf = sanitizeCpf($_POST['cpf']);
    
    // Verifica se o CPF foi autorizado em um treino
    if (!cpfAutorizado($pdo, $cpf)) {
        header("Location: ../clientRegister.php?error=cpf_not_authorized");
        exit();
    }
    
    // Verifica se o CPF já está cadastrado como atleta
    $stmt = $pdo->prepare("SELECT id_atl FROM athlete WHERE cpf_atl = :cpf");
    $stmt->execute([':cpf' => $cpf]);
    if ($stmt->fetchColumn() !== false) {
        header("Location: ../clientRegister.php?error=cpf_already_registered");
        exit();
    }
    
    // Insere o novo atleta
    $password_hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("INSERT INTO athlete
        (cpf_atl, password_atl, name_atl, contact_atl, birthDate_atl, position_atl, city_atl, hight_atl, instagram_atl, payMethod_atl, gender_atl, team_atl)
        VALUES (:cpf, :password, :name, :contact, :birthDate, :position, :city, :hight, :instagram, :payMethod, :gender, :team)");
    
    $stmt->execute([
        ':cpf' => $cpf,
        ':password' => $password_hash,
        ':name' => trim($_POST['name']),
        ':contact' => trim($_POST['contact']),
        ':birthDate' => $_POST['birthDate'],
        ':position' => $_POST['position'],
        ':city' => $_POST['city'],
        ':hight' => (int) $_POST['hight'],
        ':instagram' => trim($_POST['instagram'] ?? ''),
        ':payMethod' => $_POST['payMethod'],
        ':gender' => $_POST['gender'],
        ':team' => $_POST['team']
    ]);
    
    $pdo = null;
    
    header("Location: ../clientRegister.php?success=athlete_created");
    exit();
} catch (Exception $e) {
    header("Location: ../clientRegister.php?error=database_error");
    exit();
}