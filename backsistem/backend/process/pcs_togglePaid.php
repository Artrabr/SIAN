<?php
require_once __DIR__ . "/../data/conection.php";

if (!isset($_POST['id'], $_POST['paid'])) {
    header("Location: ../../frontend/lists.php?error=invalid_request");
    exit;
}

$id = (int) $_POST['id'];
$paid = strtolower($_POST['paid']) === 'true';

$pdo = conection::conectar();
$pdo->beginTransaction();

try {
    if ($paid) {
        $stmt = $pdo->prepare(
            "INSERT INTO payments (payday, expired, atl_id)
             SELECT CURDATE(), DATE_ADD(CURDATE(), INTERVAL 30 DAY), :id
             WHERE NOT EXISTS (SELECT 1 FROM payments WHERE atl_id = :id_check)"
        );
        $stmt->execute([':id' => $id, ':id_check' => $id]);
    } else {
        $stmt = $pdo->prepare("DELETE FROM payments WHERE atl_id = :id");
        $stmt->execute([':id' => $id]);
    }
    $pdo->commit();
} catch (PDOException $exception) {
    $pdo->rollBack();
    header("Location: ../../frontend/lists.php?error=payment_update");
    exit;
}

header("Location: ../../frontend/lists.php");
exit;
