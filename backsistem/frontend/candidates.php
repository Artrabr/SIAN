<?php
require_once __DIR__ . "/../backend/data/conection.php";

$pdo = conection::conectar();

// Busca os valores de gênero existentes na tabela candidates.
$generosStmt = $pdo->query("SELECT DISTINCT gender_cdt FROM candidates ORDER BY gender_cdt");
$generosDisponiveis = $generosStmt->fetchAll(PDO::FETCH_COLUMN);

// Lê o filtro vindo da URL (?gender=Feminino) e só aceita valores que
// realmente existem no banco, evitando qualquer valor arbitrário.
$filtroGenero = $_GET['gender'] ?? '';
$filtroGenero = in_array($filtroGenero, $generosDisponiveis, true) ? $filtroGenero : '';

$sql = "SELECT c.id_cdt AS id, c.name_cdt AS name, c.gender_cdt AS gender,
               c.contact_cdt AS contact, c.birthDate_cdt AS birth,
               c.hight_cdt AS height, c.position_cdt AS position,
               c.city_cdt AS city, c.instagram_cdt AS instagram
        FROM candidates c";

if ($filtroGenero !== '') {
    $sql .= " WHERE c.gender_cdt = :gender";
}

$sql .= " ORDER BY c.name_cdt";

$stmt = $pdo->prepare($sql);
if ($filtroGenero !== '') {
    $stmt->bindValue(':gender', $filtroGenero);
}
$stmt->execute();
$atletas = $stmt->fetchAll();

function idadeDoCandidato($birth) {
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
            <h2>Candidatos recebidos</h2>
                <p>Toque em qualquer card para ver todos os dados enviados no cadastro.</p>
        </section>

        <section class="filter-bar">
            <a href="candidates.php" class="filter-chip <?= $filtroGenero === '' ? 'active' : '' ?>">
                Todos
            </a>
            <?php foreach ($generosDisponiveis as $genero): ?>
                <a href="candidates.php?gender=<?= urlencode($genero) ?>"
                   class="filter-chip <?= $filtroGenero === $genero ? 'active' : '' ?>">
                    <?= htmlspecialchars($genero) ?>
                </a>
            <?php endforeach; ?>
        </section>

        <section class="list-stack">
            <?php
                if (empty($atletas)) {
                    echo '<p class="empty-state">Nenhum candidato encontrado para esse filtro.</p>';
                }

                foreach ($atletas as $candidato) {
                    $id = (int) ($candidato['id'] ?? 0);
                    $nome = htmlspecialchars($candidato['name'] ?? 'Sem nome');
                    $idade = htmlspecialchars((string) idadeDoCandidato($candidato['birth'] ?? ''));
                    $nascimento = htmlspecialchars($candidato['birth'] ?? '-');
                    $posicao = htmlspecialchars(ucfirst($candidato['position'] ?? '-'));
                    $cidade = htmlspecialchars($candidato['city'] ?? '-');
                    $genero = htmlspecialchars($candidato['gender'] ?? '-');
                    $contato = htmlspecialchars($candidato['contact'] ?? '-');
                    $altura = htmlspecialchars((string) ($candidato['height'] ?? '-'));
                    $instagram = htmlspecialchars($candidato['instagram'] ?? '-');
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
                                <span class="status-pill pending">Candidato</span>
                            </div>
                            <div class="summary-meta">
                                <span><?= $idade ?> anos</span>
                                <span><?= $posicao ?></span>
                            </div>
                        </label>

                        <div class="card-details">
                            <label for="<?= $cardId ?>" class="close-btn" aria-label="Fechar">×</label>

                            <div class="detail-header">
                                <div>
                                    <p class="eyebrow">Detalhes do candidato</p>
                                    <h3><?= $nome ?></h3>
                                </div>
                                    <span class="status-pill pending">Candidato</span>
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
                                    <strong><?= $contato ?></strong>
                                </div>
                                <div>
                                    <span>Cidade</span>
                                    <strong><?= $cidade ?></strong>
                                </div>
                                <div>
                                    <span>Altura</span>
                                    <strong><?= $altura ?> cm</strong>
                                </div>
                                <div>
                                    <span>Instagram</span>
                                    <strong><?= $instagram ?></strong>
                                </div>
                            </div>

                            <div class="detail-panel">
                                <h4>Próxima etapa</h4>
                                <p>Este candidato ainda não foi convertido em atleta cadastrado.</p>
                                <div class="chip-row">
                                    <span class="chip">Avaliar cadastro</span>
                                    <span class="chip">Confirmar autorização</span>
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
        <a href="lists.php">Listas</a>
        <a href="candidates.php" class="active">Candidatos</a>
        <a href="registration.php">Cadastrar</a>
        <a href="authorization.php">Autorizar</a>
    </nav>
</body>
</html>