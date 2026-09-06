<?php
require_once __DIR__ . '/../backend/data/conection.php';

$pdo = conection::conectar();

$categoriasStmt = $pdo->query(
    'SELECT DISTINCT nws_category
     FROM news
     WHERE nws_category IS NOT NULL AND nws_category <> ""
     ORDER BY nws_category'
);
$categoriasDisponiveis = $categoriasStmt->fetchAll(PDO::FETCH_COLUMN);

$filtroCategoria = trim($_GET['category'] ?? '');
if (!in_array($filtroCategoria, $categoriasDisponiveis, true)) {
    $filtroCategoria = '';
}

$sql = 'SELECT nws_id, nws_title, nws_category, nws_content, nws_photo_url,
               nws_status, nws_data_publicacao, nws_created_at, nws_updated_at
        FROM news';

if ($filtroCategoria !== '') {
    $sql .= ' WHERE nws_category = :category';
}

$sql .= ' ORDER BY nws_created_at DESC, nws_id DESC';

$stmt = $pdo->prepare($sql);
if ($filtroCategoria !== '') {
    $stmt->bindValue(':category', $filtroCategoria);
}
$stmt->execute();
$noticias = $stmt->fetchAll();
$mensagemStatus = $_GET['status'] ?? null;

function escapar($valor) {
    return htmlspecialchars((string) ($valor ?? '-'), ENT_QUOTES, 'UTF-8');
}

function formatarDataNoticia($data) {
    if (empty($data)) {
        return '-';
    }

    try {
        return (new DateTime($data))->format('d/m/Y H:i');
    } catch (Exception $exception) {
        return '-';
    }
}

function resumoNoticia($conteudo, $limite = 180) {
    $conteudo = trim((string) $conteudo);
    if (strlen($conteudo) <= $limite) {
        return $conteudo;
    }

    return substr($conteudo, 0, $limite) . '...';
}

function imagemNoticiaDisponivel($url) {
    if (empty($url)) {
        return false;
    }

    $caminho = realpath(__DIR__ . '/' . $url);
    return $caminho !== false && is_file($caminho);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIAN - Configurar notícias</title>
    <link rel="stylesheet" href="style/mainstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.css" integrity="sha512-x9WwyMYBnlXMNQ6kQ/Lyzu1NqIhLQKL5Oq6xByfXuRj7s9CskyCbLv/1IjqzJmXwFXWr0ov6jBV7Qbc0hh9nHg==" crossorigin="anonymous" referrerpolicy="no-referrer">
</head>
<body>
    <header class="topbar">
        <img src="style/logo-sian.png" alt="Logo SIAN" class="logo">
        <div>
            <h1>SIAN</h1>
            <p>Configurar notícias</p>
        </div>
    </header>

    <main class="content-card">
        <section class="page-intro">
            <h2>Notícias cadastradas</h2>
            <p>Consulte as notícias e acompanhe o status de cada postagem.</p>
        </section>

        <?php if ($mensagemStatus === 'sucesso'): ?>
            <p class="notice success">Status da notícia atualizado.</p>
        <?php elseif ($mensagemStatus === 'erro'): ?>
            <p class="notice error">Não foi possível atualizar o status da notícia.</p>
        <?php endif; ?>

        <section class="filter-bar" aria-label="Filtrar notícias por categoria">
            <a href="newsConfig.php" class="filter-chip <?= $filtroCategoria === '' ? 'active' : '' ?>">Todas</a>
            <?php foreach ($categoriasDisponiveis as $categoria): ?>
                <a href="newsConfig.php?category=<?= urlencode($categoria) ?>"
                   class="filter-chip <?= $filtroCategoria === $categoria ? 'active' : '' ?>">
                    <?= escapar($categoria) ?>
                </a>
            <?php endforeach; ?>
        </section>

        <section class="list-stack news-list">
            <?php if (empty($noticias)): ?>
                <p class="empty-state">Nenhuma notícia encontrada.</p>
            <?php endif; ?>

            <?php foreach ($noticias as $noticia): ?>
                <?php
                    $id = (int) $noticia['nws_id'];
                    $cardId = 'news-card-' . $id;
                    $publicada = (bool) $noticia['nws_status'];
                    $statusTexto = $publicada ? 'Publicada' : 'Rascunho';
                    $statusClasse = $publicada ? 'paid' : 'pending';
                ?>
                <article class="athlete-card news-card-item">
                    <input type="checkbox" class="card-toggle" id="<?= $cardId ?>">

                    <label class="card-summary" for="<?= $cardId ?>">
                        <div class="summary-main">
                            <div>
                                <span class="card-id">#<?= $id ?> · <?= escapar($noticia['nws_category']) ?></span>
                                <h3><?= escapar($noticia['nws_title']) ?></h3>
                            </div>
                            <span class="status-pill <?= $statusClasse ?>"><?= $statusTexto ?></span>
                        </div>
                        <div class="summary-meta">
                            <span><?= escapar(formatarDataNoticia($noticia['nws_created_at'])) ?></span>
                            <span>Notícia</span>
                        </div>
                    </label>

                    <div class="card-details">
                        <label for="<?= $cardId ?>" class="close-btn" aria-label="Fechar">×</label>

                        <div class="detail-header">
                            <div>
                                <p class="eyebrow">Detalhes da notícia</p>
                                <h3><?= escapar($noticia['nws_title']) ?></h3>
                            </div>
                            <span class="status-pill <?= $statusClasse ?>"><?= $statusTexto ?></span>
                        </div>

                        <?php if (imagemNoticiaDisponivel($noticia['nws_photo_url'])): ?>
                            <img class="news-config-image" src="<?= escapar($noticia['nws_photo_url']) ?>" alt="Imagem da notícia: <?= escapar($noticia['nws_title']) ?>">
                        <?php endif; ?>

                        <div class="detail-grid">
                            <div>
                                <span>ID</span>
                                <strong>#<?= $id ?></strong>
                            </div>
                            <div>
                                <span>Categoria</span>
                                <strong><?= escapar($noticia['nws_category']) ?></strong>
                            </div>
                            <div>
                                <span>Criada em</span>
                                <strong><?= escapar(formatarDataNoticia($noticia['nws_created_at'])) ?></strong>
                            </div>
                            <div>
                                <span>Publicada em</span>
                                <strong><?= escapar(formatarDataNoticia($noticia['nws_data_publicacao'])) ?></strong>
                            </div>
                        </div>

                        <div class="detail-panel">
                            <h4>Descrição</h4>
                            <p><?= nl2br(escapar($noticia['nws_content'])) ?></p>
                        </div>

                        <form action="../backend/process/pcs_togglePost.php" method="POST" class="status-form">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <input type="hidden" name="status" value="<?= $publicada ? '0' : '1' ?>">
                            <button type="submit" class="toggle-paid <?= $statusClasse ?>">
                                <?= $publicada ? 'Despublicar notícia' : 'Publicar notícia' ?>
                            </button>
                        </form>
                    </div>
                </article>
            <?php endforeach; ?>
        </section>

        <a href="news.php" class="back-link">+ Criar nova notícia</a>
    </main>

    <nav class="bottom-nav">
        <a href="home.php"><i class="fa-slab-press-duo fa-regular fa-house"></i></a>
        <a href="lists.php"><i class="fa-solid fa-list"></i></a>
        <a href="candidates.php"><i class="fa-solid fa-inbox"></i></a>
        <a href="registration.php"><i class="fa-solid fa-user-pen"></i></a>
        <a href="news.php"><i class="fa-solid fa-newspaper"></i></a>
        <a href="newsConfig.php" class="active"><i class="fa-brands fa-leanpub"></i></a>
        <a href="authorization.php"><i class="fa-solid fa-user-gear"></i></a>
    </nav>
</body>
</html>
