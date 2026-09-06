<?php
require_once __DIR__ . '/../backend/data/conection.php';

$statusMessage = $_GET['sucesso'] ?? '';
$errorMessage = $_GET['erro'] ?? '';

$autorizedAthletes = [];
try {
    $pdo = conection::conectar();
    $stmt = $pdo->prepare("SELECT cpf_atl, status, created_at FROM atl_authorized ORDER BY created_at DESC");
    $stmt->execute();
    $autorizedAthletes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $pdo = null;
} catch (Exception $e) {
    // Log silencioso - não mostra erro ao usuário
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIAN - Autorização</title>
    <link rel="stylesheet" href="style/mainstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.css" integrity="sha512-x9WwyMYBnlXMNQ6kQ/Lyzu1NqIhLQKL5Oq6xByfXuRj7s9CskyCbLv/1IjqzJmXwFXWr0ov6jBV7Qbc0hh9nHg==" crossorigin="anonymous" referrerpolicy="no-referrer">
</head>
<body>
    <header class="topbar">
        <img src="style/logo-sian.png" alt="Logo SIAN" class="logo">
        <div>
            <h1>SIAN</h1>
            <p>Autorização de treino</p>
        </div>
    </header>

    <main class="content-card">
        <section class="page-intro">
            <h2>Autorizar atleta para o treino</h2>
            <p>Registre o CPF do atleta que compareceu ao treino e pretende jogar.</p>
        </section>

        <?php if ($statusMessage !== ''): ?>
            <div class="notice success"><?= htmlspecialchars($statusMessage) ?></div>
        <?php endif; ?>

        <?php if ($errorMessage !== ''): ?>
            <div class="notice error"><?= htmlspecialchars($errorMessage) ?></div>
        <?php endif; ?>

        <form action="../backend/process/psc_authorization.php" method="POST" class="athlete-form authorization-form">
            <label for="cpf">CPF do atleta:</label>
            <input type="text" name="cpf" id="cpf" required placeholder="xxx.xxx.xxx-xx">

            <button type="submit">Autorizar atleta</button>
        </form>

        <section class="table-card">
            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>CPF</th>
                            <th>Data</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($autorizedAthletes) === 0): ?>
                            <tr>
                                <td colspan="3" class="empty-state">Nenhum atleta autorizado ainda.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($autorizedAthletes as $athlete): ?>
                                <tr>
                                    <td><?= htmlspecialchars($athlete['cpf_atl']) ?></td>
                                    <td><?= (new DateTime($athlete['created_at']))->format('d/m/Y H:i') ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <?php if ($athlete['status'] == 0): ?>
                                                <span class="badge badge-canceled">Cancelado</span>
                                            <?php else: ?>
                                                <span class="badge badge-success">Autorizado</span>
                                            <?php endif; ?>
                                            <form method="POST" action="../backend/process/psc_confirm_authorization.php" style="display:inline;">
                                                <input type="hidden" name="cpf" value="<?= htmlspecialchars($athlete['cpf_atl']) ?>">
                                                <button type="submit" class="btn-confirm" title="Confirmar">✓</button>
                                            </form>
                                            <form method="POST" action="../backend/process/psc_cancel_authorization.php" style="display:inline;" onsubmit="return confirm('Deseja cancelar a autorização deste atleta?');">
                                                <input type="hidden" name="cpf" value="<?= htmlspecialchars($athlete['cpf_atl']) ?>">
                                                <button type="submit" class="btn-cancel" title="Cancelar">✕</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <a href="home.php" class="back-link">← Voltar ao home</a>
    </main>

    <nav class="bottom-nav">
        <a href="home.php"><i class="fa-slab-press-duo fa-regular fa-house"></i></a>
        <a href="lists.php"><i class="fa-solid fa-list"></i></a>
        <a href="candidates.php"><i class="fa-solid fa-inbox"></i></a>
        <a href="registration.php"><i class="fa-solid fa-user-pen"></i></a>
        <a href="news.php"><i class="fa-solid fa-newspaper"></i></a>
        <a href="authorization.php" class="active"><i class="fa-solid fa-user-gear"></i></a>
    </nav>
</body>
</html>
