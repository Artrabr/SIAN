<?php
require_once __DIR__ . '/../backend/data/conection.php';

$pdo = conection::conectar();
$stmt = $pdo->query("SELECT t_id, t_name, t_description, t_maxCapacity, t_totalAthletes, t_status, t_gender
                     FROM teams ORDER BY t_status DESC, t_name");
$equipes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIAN - Times</title>
    <link rel="stylesheet" href="style/mainstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.css">
</head>
<body>
    <header class="topbar">
        <img src="style/logo-sian.png" alt="Logo SIAN" class="logo">
        <div><h1>SIAN</h1><p>Times cadastrados</p></div>
    </header>
    <main class="content-card">
        <section class="page-intro">
            <h2>Times</h2>
            <p>Consulte status, categoria e ocupação das equipes.</p>
        </section>
        <a href="teamRegistration.php" class="action-card primary"><strong>Novo time</strong><span>Cadastrar uma equipe.</span></a>
        <br>
        <section class="list-stack">
            <?php if (!$equipes): ?>
                <p class="empty-state">Nenhum time cadastrado.</p>
            <?php endif; ?>
            <?php foreach ($equipes as $equipe):
                $capacidade = $equipe['t_maxCapacity'] === null ? 'Sem limite' : $equipe['t_totalAthletes'] . '/' . $equipe['t_maxCapacity'];
                $lotado = $equipe['t_maxCapacity'] !== null && $equipe['t_totalAthletes'] >= $equipe['t_maxCapacity'];
                $status = !$equipe['t_status'] ? 'Inativo' : ($lotado ? 'Lotado' : 'Disponível');
            ?>
                <article class="athlete-card">
                    <div class="card-summary">
                        <div class="summary-main">
                            <div><span class="card-id">#<?= (int) $equipe['t_id'] ?></span><h3><?= htmlspecialchars($equipe['t_name']) ?></h3></div>
                            <span class="status-pill <?= $status === 'Disponível' ? 'paid' : 'pending' ?>"><?= $status ?></span>
                        </div>
                        <div class="summary-meta">
                            <span><?= htmlspecialchars(ucfirst($equipe['t_gender'])) ?></span>
                            <span><?= htmlspecialchars($capacidade) ?></span>
                            <span><?php if ($equipe['t_description']): ?><p><?= htmlspecialchars($equipe['t_description']) ?></p><?php endif; ?></span>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </section>
    </main>
    <nav class="bottom-nav">
        <a href="home.php"><i class="fa-slab-press-duo fa-regular fa-house"></i></a>
        <a href="lists.php"><i class="fa-solid fa-list"></i></a>
        <a href="candidates.php"><i class="fa-solid fa-inbox"></i></a>
        <a href="registration.php"><i class="fa-solid fa-user-pen"></i></a>
        <a href="news.php"><i class="fa-solid fa-newspaper"></i></a>
        <a href="newsConfig.php"><i class="fa-brands fa-leanpub"></i></a>
        <a href="authorization.php"><i class="fa-solid fa-user-gear"></i></a>
        <a href="teamRegistration.php"><i class="fa-solid fa-arrows-down-to-people"></i></a>
        <a href="teams.php" class="active"><i class="fa-solid fa-people-group"></i></a>
    </nav>
</body>
</html>
