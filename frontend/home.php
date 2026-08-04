<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIAN - Home</title>
    <link rel="stylesheet" href="style/mainstyle.css">
</head>
<body>
    <header class="topbar">
        <img src="style/logo-sian.png" alt="Logo SIAN" class="logo">
        <div>
            <h1>SIAN - Sistema Interno Administrativo Noia</h1>
            <p>Painel principal</p>
        </div>
    </header>

    <main class="content-card">
        <section class="hero-card">
            <h2>Gerencie atletas com praticidade</h2>
            <p>Cadastre novos jogadores, acompanhe listas e mantenha tudo em um só lugar.</p>
        </section>

        <section class="action-grid">
            <a href="cadastrar_jogador.php" class="action-card primary">
                <strong>Novo atleta</strong>
                <span>Cadastre um jogador rapidamente.</span>
            </a>
            <a href="lists.php" class="action-card">
                <strong>Listas</strong>
                <span>Consulte os atletas já cadastrados.</span>
            </a>
        </section>
    </main>

    <nav class="bottom-nav">
        <a href="home.php" class="active">Início</a>
        <a href="lists.php">Listas</a>
        <a href="cadastrar_jogador.php">Cadastrar</a>
    </nav>
</body>
</html>