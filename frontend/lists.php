<?php
require_once __DIR__ . "/../backend/data/conection.php";

$pdo = conection::conectar();

// Busca os valores de gênero que realmente existem na tabela,
// assim o filtro se adapta ao que estiver salvo no banco (ex: Masculino/Feminino).
$generosStmt = $pdo->query("SELECT DISTINCT gender_atl FROM athlete ORDER BY gender_atl");
$generosDisponiveis = $generosStmt->fetchAll(PDO::FETCH_COLUMN);

// Lê o filtro vindo da URL (?gender=Feminino) e só aceita valores que
// realmente existem no banco, evitando qualquer valor arbitrário.
$filtroGenero = $_GET['gender'] ?? '';
$filtroGenero = in_array($filtroGenero, $generosDisponiveis, true) ? $filtroGenero : '';

$sql = "SELECT a.id_atl AS id, a.name_atl AS name, a.contact_atl AS contact,
               a.birthDate_atl AS birth, a.position_atl AS position,
               a.city_atl AS city, a.team_atl AS team, a.gender_atl AS gender,
               EXISTS (
                   SELECT 1 FROM payments p WHERE p.atl_id = a.id_atl
               ) AS paid
        FROM athlete a";

if ($filtroGenero !== '') {
    $sql .= " WHERE a.gender_atl = :gender";
}

$sql .= " ORDER BY a.name_atl";

$stmt = $pdo->prepare($sql);
if ($filtroGenero !== '') {
    $stmt->bindValue(':gender', $filtroGenero);
}
$stmt->execute();
$atletas = $stmt->fetchAll();

function idadeDoAtleta($birth) {
    try {
        return (new DateTime($birth))->diff(new DateTime())->y;
    } catch (Exception $exception) {
        return '-';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIAN - Listas</title>
    <link rel="stylesheet" href="style/mainstyle.css">
</head>
<body>
    <header class="topbar">
        <img src="style/logo-sian.png" alt="Logo SIAN" class="logo">
        <div>
            <h1>SIAN</h1>
            <p>Lista de atletas</p>
        </div>
    </header>

    <main class="content-card">
        <section class="page-intro">
            <h2>Atletas cadastrados</h2>
            <p>Toque em qualquer card para ver todos os detalhes e o status de mensalidade.</p>
        </section>

        <section class="filter-bar">
            <a href="lists.php" class="filter-chip <?= $filtroGenero === '' ? 'active' : '' ?>">
                Todos
            </a>
            <?php foreach ($generosDisponiveis as $genero): ?>
                <a href="lists.php?gender=<?= urlencode($genero) ?>"
                   class="filter-chip <?= $filtroGenero === $genero ? 'active' : '' ?>">
                    <?= htmlspecialchars($genero) ?>
                </a>
            <?php endforeach; ?>
        </section>

        <section class="list-stack">
            <?php
                if (empty($atletas)) {
                    echo '<p class="empty-state">Nenhum atleta encontrado para esse filtro.</p>';
                }

                foreach ($atletas as $atleta) {
                    $id = (int) ($atleta['id'] ?? 0);
                    $nome = htmlspecialchars($atleta['name'] ?? 'Sem nome');
                    $idade = htmlspecialchars((string) idadeDoAtleta($atleta['birth'] ?? ''));
                    $nascimento = htmlspecialchars($atleta['birth'] ?? '-');
                    $posicao = htmlspecialchars(ucfirst($atleta['position'] ?? '-'));
                    $cidade = htmlspecialchars($atleta['city'] ?? '-');
                    $equipe = htmlspecialchars($atleta['team'] ?? '-');
                    $genero = htmlspecialchars($atleta['gender'] ?? '-');
                    $pago = (bool) $atleta['paid'];
                    $statusTexto = $pago ? 'Pago' : 'Pendente';
                    $statusClasse = $pago ? 'paid' : 'pending';
                    $cardId = 'card-' . $id;
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
                                <span><?= $idade ?> anos</span>
                                <span><?= $posicao ?></span>
                                <span><?= $equipe ?></span>
                            </div>
                        </label>

                        <div class="card-details">
                            <label for="<?= $cardId ?>" class="close-btn" aria-label="Fechar">×</label>

                            <div class="detail-header">
                                <div>
                                    <p class="eyebrow">Detalhes do atleta</p>
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
                                    <span>Gênero</span>
                                    <strong><?= $genero ?></strong>
                                </div>
                                <div>
                                    <span>Idade</span>
                                    <strong><?= $idade ?> anos</strong>
                                </div>
                                <div>
                                    <span>Data de nascimento</span>
                                    <strong><?= $nascimento ?></strong>
                                </div>
                                <div>
                                    <span>Posição</span>
                                    <strong><?= $posicao ?></strong>
                                </div>
                                <div>
                                    <span>Contato</span>
                                    <strong><?= htmlspecialchars($atleta['contact'] ?? '-') ?></strong>
                                </div>
                                <div>
                                    <span>Cidade</span>
                                    <strong><?= $cidade ?></strong>
                                </div>
                                <div>
                                    <span>Equipe</span>
                                    <strong><?= $equipe ?></strong>
                                </div>
                                <div>
                                    <span>Mensalidade</span>
                                    <strong><?= $pago ? 'Pago' : 'Pendente' ?></strong>
                                </div>
                            </div>

                            <form action="../backend/process/pcs_togglePaid.php" method="POST" class="status-form">
                                <input type="hidden" name="id" value="<?= $id ?>">
                                <input type="hidden" name="paid" value="<?= $pago ? 'false' : 'true' ?>">
                                <button type="submit" class="toggle-paid <?= $statusClasse ?>">
                                    <?= $pago ? 'Marcar como pendente' : 'Marcar como pago' ?>
                                </button>
                            </form>

                            <div class="detail-panel">
                                <h4>Dados extras</h4>
                                <p>Este espaço pode receber performance, frequência, avaliações, lesões e observações futuras.</p>
                                <div class="chip-row">
                                    <span class="chip">Performance</span>
                                    <span class="chip">Frequência</span>
                                    <span class="chip">Avaliações</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            ?>
        </section>

        <a href="home.php" class="back-link">← Voltar ao home</a>
    </main>

    <nav class="bottom-nav">
        <a href="home.php">Início</a>
        <a href="lists.php" class="active">Listas</a>
        <a href="registration.php">Cadastrar</a>
    </nav>
</body>
</html>