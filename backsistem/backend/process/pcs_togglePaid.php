<?php
require_once __DIR__ . "/../data/conection.php";
require_once __DIR__ . "/../classes/payment.php";

if (!isset($_POST['id'], $_POST['paid'])) {
    header("Location: ../../frontend/lists.php?error=invalid_request");
    exit;
}

$id = (int) $_POST['id'];
$paid = strtolower($_POST['paid']) === 'true';
$tipoPagamento = $_POST['type_pgm'] ?? 'mensalidade';

if (!in_array($tipoPagamento, ['mensalidade', 'diaria'], true)) {
    header("Location: ../../frontend/lists.php?error=invalid_payment_type");
    exit;
}

$pdo = conection::conectar();
$pdo->beginTransaction();

try {
    if ($paid) {
        $dataPagamento = date('Y-m-d');
        $dataExpiracao = calcularDataExpiracao($tipoPagamento, $dataPagamento);
        $stmt = $pdo->prepare(
            "INSERT INTO payments (payday, expired, atl_id, type_pgm)
             SELECT :payday, :expired, :id, :type_pgm
             WHERE NOT EXISTS (
                 SELECT 1
                 FROM payments
                 WHERE atl_id = :id_check
                   AND payday = :payday_check
                   AND type_pgm = :type_check
             )"
        );
        $stmt->execute([
            ':payday' => $dataPagamento,
            ':expired' => $dataExpiracao,
            ':id' => $id,
            ':type_pgm' => $tipoPagamento,
            ':id_check' => $id,
            ':payday_check' => $dataPagamento,
            ':type_check' => $tipoPagamento,
        ]);
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
