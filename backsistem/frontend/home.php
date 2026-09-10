<?php
require_once __DIR__ . "/../backend/data/conection.php";
require_once __DIR__ . "/../backend/classes/paymentprocess.php";

function getTotalAthletes($pdo){
    $stmt = $pdo->query("SELECT COUNT(*) AS total FROM athlete");
    $resultado = $stmt->fetch();
    return $resultado['total'];
}

function getTotalTeams($pdo){
    $stmt = $pdo->query("SELECT COUNT(*) AS total FROM teams");
    $resultado = $stmt->fetch();
    return $resultado['total'];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIAN - Home</title>
    <link rel="stylesheet" href="style/mainstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.css" integrity="sha512-x9WwyMYBnlXMNQ6kQ/Lyzu1NqIhLQKL5Oq6xByfXuRj7s9CskyCbLv/1IjqzJmXwFXWr0ov6jBV7Qbc0hh9nHg==" crossorigin="anonymous" referrerpolicy="no-referrer">
</head>
<body>
    <header class="topbar">
        <img src="style/logo-sian.png" alt="Logo SIAN" class="logo">
        <div>
            <h1>SIAN</h1>
            <p>Painel principal</p>
        </div>
    </header>

    <main class="content-card">
        <section class="home-hero">
            <div class="hero-copy">
                <span class="eyebrow">Painel administrativo</span>
                <h2>Bem-vindo ao SIAN</h2>
                <p>Gerencie atletas, times e movimentações do clube em um só lugar.</p>
            </div>
        </section>

        <?php
        //==================================
        //         pega os valores
        //==================================
        
        $pdo = conection::conectar();

        $sql = "SELECT id_atl FROM athlete";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $athletesId = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $totalAthletes = getTotalAthletes($pdo);
        $totalTeams = getTotalTeams($pdo);
        $totalPayd = howManyPaid($pdo, $athletesId);
        $totalPending = max(0, count($athletesId) - $totalPayd);

        $pdo = null;
        ?>
        
        <section class="stats-grid">
            <article class="stat-tile">
                <small>Atletas</small>
                <strong><?=$totalAthletes?></strong>
                <span>cadastrados</span> <!--isso pode expor a quantidade q entra por mes na proxima aatualizacao-->
            </article>
            <article class="stat-tile">
                <small>Times</small>
                <strong><?=$totalTeams?></strong>
                <span>No total</span>
            </article>
            <article class="stat-tile">
                <small>Pagamentos</small>
                <strong><?=$totalPayd?></strong>
                <span><?=$totalPending?> pendentes</span>
            </article>
        </section>

        <section class="home-panel">
            <div class="panel-header">
                <h3>Atalhos rápidos</h3>
                <a href="lists.php">Ver tudo</a>
            </div>

            <div class="action-grid home-grid">
                <a href="registration.php" class="action-card primary">
                    <i class="fa-solid fa-user-plus"></i>
                    <strong>Novo atleta</strong>
                    <span>Cadastre um jogador rapidamente</span>
                </a>
                <a href="lists.php" class="action-card">
                    <i class="fa-solid fa-list"></i>
                    <strong>Listas</strong>
                    <span>Consulte os atletas já cadastrados</span>
                </a>
                <a href="teams.php" class="action-card">
                    <i class="fa-solid fa-people-group"></i>
                    <strong>Times</strong>
                    <span>Consulte capacidade e status das equipes</span>
                </a>
                <a href="teamRegistration.php" class="action-card">
                    <i class="fa-solid fa-arrows-down-to-people"></i>
                    <strong>Novo time</strong>
                    <span>Cadastre uma nova equipe</span>
                </a>
            </div>
        </section>

        <section class="home-panel">
            <div class="panel-header">
                <h3>Resumo do dia</h3>
            </div>

            <div class="mini-list">
                <div class="mini-item">
                    <span class="mini-label">Cadastro</span>
                    <strong><?=$totalAthletes?> atletas</strong>
                </div>
                <div class="mini-item">
                    <span class="mini-label">Equipe</span>
                    <strong>Times <?=$totalTeams?> no total</strong>
                </div>
                <div class="mini-item">
                    <span class="mini-label">Pagamento</span>
                    <strong><?=$totalPending?> mensalidades pendentes</strong>
                </div>
            </div>
        </section>
    </main>

    <nav class="bottom-nav">
        <a href="home.php" class="active"><i class="fa-slab-press-duo fa-regular fa-house"></i></a>
        <a href="lists.php"><i class="fa-solid fa-list"></i></a>
        <a href="candidates.php"><i class="fa-solid fa-inbox"></i></a>
        <a href="registration.php"><i class="fa-solid fa-user-pen"></i></a>
        <a href="news.php"><i class="fa-solid fa-newspaper"></i></a>
        <a href="newsConfig.php"><i class="fa-brands fa-leanpub"></i></a>
        <a href="authorization.php"><i class="fa-solid fa-user-gear"></i></a>
        <a href="teamRegistration.php"><i class="fa-solid fa-arrows-down-to-people"></i></a>
        <a href="teams.php"><i class="fa-solid fa-people-group"></i></a>
    </nav>
</body>
</html>