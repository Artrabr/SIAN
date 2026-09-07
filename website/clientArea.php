<?php
require_once __DIR__ . '/process/columProjection.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área do Cliente | NOIA Vôlei</title>
    <link rel="stylesheet" href="style/base.css">
    <link rel="stylesheet" href="style/logosize.css">
    <link rel="stylesheet" href="style/client-area.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="client-page">
    <header>
        <div class="nav-container">
            <div class="brand">
                <a href="index.php" class="crest-header" aria-label="Voltar para o site do NOIA Vôlei">
                    <img src="imagens/noialogo.png" alt="Logo NOIA Vôlei" class="logo-size01">
                </a>
                <div class="brand-text">Area do <span>atleta</span></div>
            </div>
            <nav aria-label="Navegação principal">
                <ul class="nav-menu client-nav-menu">
                    <li><a href="process/logout.php" class="btn-login">Sair / Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="client-main">
        <div class="container">
            <section class="client-panel active" id="inicio" role="tabpanel" aria-labelledby="tab-inicio">
                <div class="client-welcome">
                    <div>
                        <p class="eyebrow">Área do cliente</p>
                        <h1>Olá, <?= htmlspecialchars($atleta['nome']) ?></h1>
                        <p class="section-subtitle">Acompanhe sua rotina no <?= htmlspecialchars($atleta['equipe']) ?>.</p>
                    </div>
                    <div class="client-status"><span class="status-dot"></span> Cadastro ativo</div>
                </div>

                <div class="section-header compact-header">
                    <div>
                        <h2 class="section-title">Resumo</h2>
                        <p class="section-subtitle">Seus principais indicadores</p>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-12 col-md-6 col-xl-4">
                        <article class="client-card metric-card">
                            <span class="card-label">Financeiro do mês</span>
                            <strong class="metric-value status-paid"><?= htmlspecialchars($atleta['financeiro']) ?></strong>
                            <span class="card-note">Nenhuma pendência registrada</span>
                        </article>
                    </div>
            
                    <!--
                    <div class="col-12 col-md-6 col-xl-4">
                        <article class="client-card metric-card">
                            <span class="card-label">Próximo treino</span>
                            <strong class="metric-value">18:00</strong>
                            <span class="card-note"> ?= htmlspecialchars($atleta['proximo_treino']) ?></span>
                        </article>
                    </div>
                    -->

                    <div class="col-12 col-md-6 col-xl-4">
                        <article class="client-card metric-card">
                            <span class="card-label">Equipe</span>
                            <strong class="metric-value metric-team"><?= htmlspecialchars($atleta['equipe']) ?></strong>
                            <span class="card-note">Temporada 2026</span>
                        </article>
                    </div>
                </div>
            </section>

            <section class="client-panel" id="perfil" role="tabpanel" aria-labelledby="tab-perfil" hidden>
                <div class="section-header compact-header">
                    <div>
                        <h2 class="section-title">Meu perfil</h2>
                        <p class="section-subtitle">Seus dados dentro do NOIA Vôlei.</p>
                    </div>
                </div>
                <div class="row g-4 align-items-stretch">
                    <div class="col-12 col-lg-4">
                        <article class="client-card profile-card">
                            <img src="<?= htmlspecialchars($atleta['foto']) ?>" alt="Foto de <?= htmlspecialchars($atleta['nome']) ?>" class="profile-photo">
                            <h3><?= htmlspecialchars($atleta['nome']) ?></h3>
                            <p class="profile-role"><?= htmlspecialchars($atleta['posicao']) ?> · <?= htmlspecialchars($atleta['equipe']) ?></p>
                        </article>
                    </div>
                    <div class="col-12 col-lg-8">
                        <article class="client-card profile-details">
                            <div class="detail-line"><span>Nome completo</span><strong><?= htmlspecialchars($atleta['nome']) ?></strong></div>
                            <div class="detail-line"><span>Posição</span><strong><?= htmlspecialchars($atleta['posicao']) ?></strong></div>
                            <div class="detail-line"><span>Equipe</span><strong><?= htmlspecialchars($atleta['equipe']) ?></strong></div>
                            <div class="detail-line"><span>Instagram</span><strong><?= htmlspecialchars($atleta['instagram']) ?></strong></div>
                            <a href="#" class="btn-login password-button">Alterar senha</a>
                        </article>
                    </div>
                </div>
            </section>

            <section class="client-panel" id="equipe" role="tabpanel" aria-labelledby="tab-equipe" hidden>
                <div class="section-header compact-header">
                    <div>
                        <h2 class="section-title">Minha equipe</h2>
                        <p class="section-subtitle">Atletas da <?= htmlspecialchars($atleta['equipe']) ?>.</p>
                    </div>
                </div>
                <div class="row g-3">
                    <?php foreach ($equipe as $membro): ?>
                        <div class="col-12 col-sm-6 col-lg-3">
                            <article class="client-card teammate-card">
                                <img src="<?= htmlspecialchars($membro['foto']) ?>" alt="Foto de <?= htmlspecialchars($membro['nome']) ?>" class="teammate-photo">
                                <div>
                                    <h3><?= htmlspecialchars($membro['nome']) ?></h3>
                                    <span><?= htmlspecialchars($membro['posicao']) ?></span>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <section class="client-panel" id="pagamentos" role="tabpanel" aria-labelledby="tab-pagamentos" hidden>
                <div class="section-header compact-header">
                    <div>
                        <h2 class="section-title">Pagamentos</h2>
                        <p class="section-subtitle">Escolha o tipo de pagamento e fale com a equipe.</p>
                    </div>
                </div>
                <div class="row g-3 payment-options">
                    <?php if ($podePagarMensalidade): ?>
                        <div class="col-12 col-md-6">
                            <a class="payment-action primary-action" href="https://api.whatsapp.com/send?phone=<?= $numeroWhatsApp ?>&text=<?= $mensagemWhatsApp('mensalidade') ?>" target="_blank" rel="noopener">
                                <span class="payment-icon">R$</span>
                                <span><strong>Pagar mensalidade</strong><small>Disponível até o dia 5 de cada mês</small></span>
                                <span aria-hidden="true">&#8594;</span>
                            </a>
                        </div>
                    <?php endif; ?>
                    <div class="col-12 col-md-6">
                        <a class="payment-action" href="https://api.whatsapp.com/send?phone=<?= $numeroWhatsApp ?>&text=<?= $mensagemWhatsApp('diaria') ?>" target="_blank" rel="noopener">
                            <span class="payment-icon">1D</span>
                            <span><strong>Pagar diária</strong><small>Solicite o valor atualizado</small></span>
                            <span aria-hidden="true">&#8594;</span>
                        </a>
                    </div>
                </div>

                <div class="table-wrap">
                    <h3>Relatório financeiro</h3>
                    <div class="table-responsive">
                        <table class="finance-table">
                            <thead><tr><th>Data</th><th>Tipo</th><th>Status</th></tr></thead>
                            <tbody>
                                <?php foreach ($relatorioFinanceiro as $pagamento): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($pagamento['data']) ?></td>
                                        <td><?= htmlspecialchars($pagamento['tipo']) ?></td>
                                        <td><span class="payment-status"><?= htmlspecialchars($pagamento['status']) ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <nav class="client-tabs" role="tablist" aria-label="Seções da área do cliente">
                <button class="client-tab active" id="tab-inicio" role="tab" aria-selected="true" aria-controls="inicio" data-tab="inicio"><span aria-hidden="true">⌂</span><span>Início</span></button>
                <button class="client-tab" id="tab-perfil" role="tab" aria-selected="false" aria-controls="perfil" data-tab="perfil"><span aria-hidden="true">◎</span><span>Perfil</span></button>
                <button class="client-tab" id="tab-equipe" role="tab" aria-selected="false" aria-controls="equipe" data-tab="equipe"><span aria-hidden="true">♧</span><span>Equipe</span></button>
                <button class="client-tab" id="tab-pagamentos" role="tab" aria-selected="false" aria-controls="pagamentos" data-tab="pagamentos"><span aria-hidden="true">$</span><span>Pagamentos</span></button>
            </nav>
        </div>
    </main>

    <footer class="client-footer"><div class="container">&copy; <?= date('Y') ?> NOIA VÔLEI · Área do cliente</div></footer>
    <script>
        document.querySelectorAll('.client-tab').forEach(function (tab) {
            tab.addEventListener('click', function () {
                document.querySelectorAll('.client-tab').forEach(function (item) {
                    item.classList.remove('active');
                    item.setAttribute('aria-selected', 'false');
                });
                document.querySelectorAll('.client-panel').forEach(function (panel) {
                    panel.classList.remove('active');
                    panel.hidden = true;
                });
                tab.classList.add('active');
                tab.setAttribute('aria-selected', 'true');
                var panel = document.getElementById(tab.dataset.tab);
                panel.hidden = false;
                panel.classList.add('active');
            });
        });
    </script>
</body>
</html>
