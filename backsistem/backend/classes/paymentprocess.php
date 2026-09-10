<?php

function verifyMonth($pdo, int $id_atl):bool{
    $sql = "
        SELECT payday, expired
        FROM payments
        WHERE atl_id = :id_atl
        AND type_pgm = 'mensalidade'
        ORDER BY expired DESC
        LIMIT 1
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'id_atl' => $id_atl
    ]);

    $pagamento = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$pagamento) {
        return false;
    }

    $payday = new DateTime($pagamento['payday']);
    $expired = new DateTime($pagamento['expired']);

    $expired->modify('-1 month');

    return $expired <= $payday; 
}

function howManyPaid($pdo, array $ids): int
{
    $total = 0;

    foreach ($ids as $id_atl) {

        if (verifyMonth($pdo, $id_atl)) {
            $total++;
        }

    }

    return $total;
}