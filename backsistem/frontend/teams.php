<?php
require_once __DIR__ . '/../backend/data/conection.php';

$pdo = conection::conectar();

$generosStmt = $pdo->query("SELECT DISTINCT t_gender FROM teams WHERE t_gender IS NOT NULL AND t_gender <> '' ORDER BY t_gender");
$generosDisponiveis = $generosStmt->fetchAll(PDO::FETCH_COLUMN);

$filtroGenero = $_GET['gender'] ?? '';
$filtroGenero = in_array($filtroGenero, $generosDisponiveis, true) ? $filtroGenero : '';

$sql = "SELECT t_id, t_name, t_description, t_maxCapacity, t_totalAthletes, t_status, t_gender
        FROM teams";

if ($filtroGenero !== '') {
    $sql .= " WHERE t_gender = :gender";
}

$sql .= " ORDER BY t_status DESC, t_name";

$stmt = $pdo->prepare($sql);
if ($filtroGenero !== '') {
    $stmt->bindValue(':gender', $filtroGenero);
}
$stmt->execute();
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
        <div>
            <h1>SIAN</h1>
            <p>Times cadastrados</p>
        </div>
    </header>

    <main class="content-card">
        <section class="page-intro">
            <h2>Times</h2>
            <p>Consulte status, categoria e ocupação das equipes.</p>
        </section>

        <a href="teamRegistration.php" class="action-card primary">
            <strong>Novo time</strong>
            <span>Cadastrar uma equipe.</span>
        </a>

        <br>

        <section class="filter-bar">
            <a href="teams.php" class="filter-chip <?= $filtroGenero === '' ? 'active' : '' ?>">
                Todos
            </a>
            <?php foreach ($generosDisponiveis as $genero): ?>
                <a href="teams.php?gender=<?= urlencode($genero) ?>"
                   class="filter-chip <?= $filtroGenero === $genero ? 'active' : '' ?>">
                    <?= htmlspecialchars($genero) ?>
                </a>
            <?php endforeach; ?>
        </section>

        <section class="list-stack">
            <?php
            if (empty($equipes)) {
                echo '<p class="empty-state">Nenhum time encontrado para esse filtro.</p>';
            }

            foreach ($equipes as $equipe):
                $id = (int) ($equipe['t_id'] ?? 0);
                $nome = htmlspecialchars($equipe['t_name'] ?? 'Sem nome');
                $descricao = htmlspecialchars($equipe['t_description'] ?? 'Sem descrição');
                $genero = htmlspecialchars(ucfirst($equipe['t_gender'] ?? '-'));
                $totalAtletas = (int) ($equipe['t_totalAthletes'] ?? 0);
                $capacidadeMaxima = $equipe['t_maxCapacity'];
                $capacidade = $capacidadeMaxima === null ? 'Sem limite' : $totalAtletas . '/' . (int) $capacidadeMaxima;
                $lotado = $capacidadeMaxima !== null && $totalAtletas >= (int) $capacidadeMaxima;
                $statusAtivo = (bool) $equipe['t_status'];
                $statusTexto = !$statusAtivo ? 'Inativo' : ($lotado ? 'Lotado' : 'Disponível');
                $statusClasse = !$statusAtivo ? 'pending' : ($lotado ? 'pending' : 'paid');
                $cardId = 'team-card-' . $id;
                ?>
                <div class="athlete-card">
                    <input type="checkbox" class="card-toggle" id="<?= $cardId ?>">

                    <label class="card-summary" for="<?= $cardId ?>">
                        <div class="summary-main">
                            <div>
                                <span class="card-id">#<?= $id ?></span>
                                <h3><?= $nome ?></h3>
                            </div>
                            <span class="status-pill <?= $statusClasse ?>"><?= $statusTexto ?></span>
                        </div>
                        <div class="summary-meta">
                            <span><?= $genero ?></span>
                            <span><?= htmlspecialchars($capacidade) ?></span>
                            <p class="team-description"><?= $descricao ?></p>
                        </div>
                    </label>

                    <div class="card-details">
                        <label for="<?= $cardId ?>" class="close-btn" aria-label="Fechar">×</label>

                        <div class="detail-header">
                            <div>
                                <p class="eyebrow">Detalhes da equipe</p>
                                <h3><?= $nome ?></h3>
                            </div>
                            <span class="status-pill <?= $statusClasse ?>"><?= $statusTexto ?></span>
                        </div>

                        <div class="detail-grid">
                            <div>
                                <span>ID</span>
                                <strong>#<?= $id ?></strong>
                            </div>
                            <div>
                                <span>Nome</span>
                                <strong><?= $nome ?></strong>
                            </div>
                            <div>
                                <span>Categoria</span>
                                <strong><?= $genero ?></strong>
                            </div>
                            <div>
                                <span>Status</span>
                                <strong><?= $statusTexto ?></strong>
                            </div>
                            <div>
                                <span>Atletas</span>
                                <strong><?= $totalAtletas ?></strong>
                            </div>
                            <div>
                                <span>Capacidade</span>
                                <strong><?= $capacidadeMaxima === null ? 'Sem limite' : $capacidadeMaxima ?></strong>
                            </div>
                            <div style="grid-column: 1 / -1;">
                                <span>Descrição</span>
                                <strong><?= $descricao ?></strong>
                            </div>
                        </div>

                        <div class="detail-panel">
                            <h4>Observação</h4>
                            <p>Todos os times disponiveis serão exibidos na hora de cadastro</p>
                            <div class="chip-row">
                                <a href="home.php" class="chip">Saíba mais</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>

        <a href="home.php" class="back-link">← Voltar ao home</a>
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
