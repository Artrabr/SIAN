<?php
function validateFormData($data) {
    return !empty($data['login'])
        && !empty($data['password']);
}

function connect() {
    return conection::conectar();
}

function disconnect() {
    $pdo = null;
}

function loginCheck($login, $password) { //corrigir o codigo quebrado da ia
    $pdo = connect();
    $stmt = $pdo->prepare("SELECT * FROM perfil WHERE login = :login AND password = :password");
    $stmt->execute([':login' => $login, ':password' => $password]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Login successful
        session_start();
        $_SESSION['user_id'] = $user['login_pfl'];
        $_SESSION['login'] = $user['login_pfl'];
        header("Location: ../../../../website/dashboard.php");
        exit();
    } else {
        // Login failed
        header("Location: ../../../../website/index.php?error=invalid_credentials");
        exit();
    }
}

function sessionCheck() {
    session_start();
    $_SESSION['user_id'] = $user['id_pfl'];
    session_close();
}

function getUserMYSQL($login/*$_POST['login'] isso é o cpf*/) {
    $pdo = connect();
    $stmt = $pdo->prepare("SELECT login_pfl FROM perfil WHERE login_pfl = :login");
    $stmt->execute([':login' => $login]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

//========================================================================//
//                                CÓDIGO
//========================================================================//

if(validateFormData($_POST)){
    $name = $_POST['name'];
    connect();
    loginCheck($_POST['login'],$_POST['password']);
    $user = getUserMYSQL($_POST['login']);
    disconnect();
    
}

/*
CREATE TABLE perfil (
    login_pfl VARCHAR(100) NOT NULL,
    password_pfl VARCHAR(100) NOT NULL,
    created_at_pfl TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
*/