<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Atleta - SIAN</title>
    <link rel="stylesheet" href="style/mainstyle.css">
</head>
<body>
    <header class="topbar">
        <img src="style/logo-sian.png" alt="Logo SIAN" class="logo">
        <div>
            <h1>SIAN</h1>
            <p>Cadastro de atleta</p>
        </div>
    </header>

    <main class="content-card">
        <form action="../backend/process/pcs_newAthlete.php" method="POST" class="athlete-form">
            <label for="name">Nome:</label>
            <input type="text" name="name" id="name" required placeholder="Nome completo">

            <label for="birth">Data de nascimento:</label>
            <input type="date" name="birth" id="birth" required>

            <label for="sport">Esporte:</label>
            <select name="sport" id="sport" required>
                <option value="">Selecione</option>
                <option value="volei">Vôlei</option>
                <option value="basquete">Basquete</option>
            </select>

            <label for="position">Posição:</label>
            <select name="position" id="position">
                <option value="">Selecione</option>
                <option value="levantador">Levantador</option>
                <option value="ponteiro">Ponteiro</option>
                <option value="central">Central</option>
                <option value="libero">Líbero</option>
                <option value="oposto">Oposto</option>
                <option value="none">Não possui</option>
            </select>

            <input type="hidden" name="paid" value="false">

            <button type="submit">Criar atleta</button>
        </form>

        <a href="home.php" class="back-link">← Voltar ao home</a>
    </main>

    <nav class="bottom-nav">
        <a href="home.php">Início</a>
        <a href="lists.php">Listas</a>
        <a href="cadastrar_jogador.php" class="active">Cadastrar</a>
    </nav>
</body>
</html>