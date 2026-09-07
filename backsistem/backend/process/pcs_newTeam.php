<?php
require_once __DIR__ . '/../data/conection.php';

function validarDadosTime($dados){
    return !empty(trim($dados['name'] ?? ''))
        && in_array($dados['gender'] ?? '', ['masculino', 'feminino', 'misto'], true)
        && (($dados['maxCapacity'] ?? '') === '' || filter_var($dados['maxCapacity'], FILTER_VALIDATE_INT) !== false);
}

if (!validarDadosTime($_POST)) {
    header('Location: ../../frontend/teamRegistration.php?error=invalid_data');
    exit();
}

try {
    $pdo = conection::conectar();
    $stmt = $pdo->prepare("SELECT t_id FROM teams WHERE t_name = :name LIMIT 1");
    $stmt->execute(['name' => trim($_POST['name'])]);

    if ($stmt->fetchColumn() !== false) {
        header('Location: ../../frontend/teamRegistration.php?error=team_exists');
        exit();
    }

    $stmt = $pdo->prepare("INSERT INTO teams
        (t_name, t_description, t_maxCapacity, t_totalAthletes, t_status, t_gender)
        VALUES (:name, :description, :capacity, 0, 1, :gender)");
    $stmt->execute([
        'name' => trim($_POST['name']),
        'description' => trim($_POST['description'] ?? ''),
        'capacity' => ($_POST['maxCapacity'] ?? '') === '' ? null : (int) $_POST['maxCapacity'],
        'gender' => $_POST['gender'],
    ]);

    header('Location: ../../frontend/teams.php?success=team_created');
    exit();
} catch (Throwable $exception) {
    header('Location: ../../frontend/teamRegistration.php?error=database_error');
    exit();
}
