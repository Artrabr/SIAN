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

        <section class="list-stack">
            <?php
            $arquivo = "../backend/data/DataAthlete.csv";

            function resetStatusMensalidade($arquivo) {
                if (date('j') !== '1') {
                    return;
                }

                if (!file_exists($arquivo)) {
                    return;
                }

                $linhas = [];
                if (($handle = fopen($arquivo, 'r')) !== false) {
                    while (($dados = fgetcsv($handle, 1000, ',')) !== false) {
                        $linhas[] = $dados;
                    }
                    fclose($handle);
                }

                if (count($linhas) <= 1) {
                    return;
                }

                $cabecalho = array_shift($linhas);
                $alterado = false;

                foreach ($linhas as &$linha) {
                    if (isset($linha[6]) && strtolower($linha[6]) === 'true') {
                        $linha[6] = 'false';
                        $alterado = true;
                    }
                }

                if ($alterado && ($handle = fopen($arquivo, 'w')) !== false) {
                    fputcsv($handle, $cabecalho);
                    foreach ($linhas as $linha) {
                        fputcsv($handle, $linha);
                    }
                    fclose($handle);
                }
            }

            resetStatusMensalidade($arquivo);

            if (!file_exists($arquivo)) {
                echo "<p class='empty-state'>CSV não encontrado.</p>";
            } else {
                $handle = fopen($arquivo, "r");
                $cabecalho = fgetcsv($handle, 1000, ",");
                $atletas = [];

                while (($linha = fgetcsv($handle, 1000, ",")) !== false) {
                    $registro = [];

                    foreach ($cabecalho as $index => $nomeCampo) {
                        $registro[$nomeCampo] = $linha[$index] ?? '';
                    }

                    if (!isset($registro['paid']) || $registro['paid'] === '') {
                        $registro['paid'] = 'false';
                    }

                    $atletas[] = $registro;
                }

                fclose($handle);

                foreach ($atletas as $atleta) {
                    $id = (int) ($atleta['id'] ?? 0);
                    $nome = htmlspecialchars($atleta['name'] ?? 'Sem nome');
                    $idade = htmlspecialchars($atleta['age'] ?? '-');
                    $nascimento = htmlspecialchars($atleta['birth'] ?? '-');
                    $esporte = htmlspecialchars(ucfirst($atleta['sport'] ?? '-'));
                    $posicao = htmlspecialchars(ucfirst($atleta['position'] ?? '-'));
                    $pago = strtolower($atleta['paid'] ?? 'false') === 'true';
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
                                <span><?= $esporte ?></span>
                                <span><?= $posicao ?></span>
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
                                    <span>Idade</span>
                                    <strong><?= $idade ?> anos</strong>
                                </div>
                                <div>
                                    <span>Data de nascimento</span>
                                    <strong><?= $nascimento ?></strong>
                                </div>
                                <div>
                                    <span>Esporte</span>
                                    <strong><?= $esporte ?></strong>
                                </div>
                                <div>
                                    <span>Posição</span>
                                    <strong><?= $posicao ?></strong>
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
            }
            ?>
        </section>

        <a href="home.php" class="back-link">← Voltar ao home</a>
    </main>

    <nav class="bottom-nav">
        <a href="home.php">Início</a>
        <a href="lists.php" class="active">Listas</a>
        <a href="cadastrar_jogador.php">Cadastrar</a>
    </nav>
</body>
</html>