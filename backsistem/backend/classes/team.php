<?php

function buscarEquipesDisponiveis($pdo, $genero = null){
    $sql = "
        SELECT t_id, t_name, t_description, t_maxCapacity, t_totalAthletes, t_gender
        FROM teams
        WHERE t_status = 1
          AND (t_maxCapacity IS NULL OR t_totalAthletes < t_maxCapacity)
    ";

    $params = [];
    if ($genero !== null) {
        $sql .= " AND (t_gender = :gender OR t_gender = 'misto')";
        $params['gender'] = $genero;
    }

    $sql .= " ORDER BY t_name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function equipePodeReceberGenero($pdo, $nomeEquipe, $genero){
    $stmt = $pdo->prepare(" 
        SELECT t_id
        FROM teams
        WHERE t_name = :name
          AND t_status = 1
          AND (t_maxCapacity IS NULL OR t_totalAthletes < t_maxCapacity)
          AND (t_gender = :gender OR t_gender = 'misto')
        LIMIT 1
    ");
    $stmt->execute(['name' => $nomeEquipe, 'gender' => $genero]);
    return $stmt->fetchColumn() !== false;
}
