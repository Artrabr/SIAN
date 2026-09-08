<?php
$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIAN - Novo time</title>
    <link rel="stylesheet" href="style/mainstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.css">
</head>
<body>
    <header class="topbar">
        <img src="style/logo-sian.png" alt="Logo SIAN" class="logo">
        <div><h1>SIAN</h1><p>Cadastrar time</p></div>
    </header>
    <main class="content-card">
        <?php if ($error === 'team_exists'): ?><p class="notice">Já existe um time com esse nome.</p><?php endif; ?>
        <?php if ($error === 'invalid_data'): ?><p class="notice">Confira os dados informados.</p><?php endif; ?>
        <form action="../backend/process/pcs_newTeam.php" method="POST" class="athlete-form">
            <label for="name">Nome do time:</label>
            <input id="name" name="name" type="text" maxlength="30" required>

            <label for="description">Descrição:</label>
            <textarea id="description" name="description" maxlength="400"></textarea>

            <label for="maxCapacity">Capacidade máxima:</label>
            <input id="maxCapacity" name="maxCapacity" type="number" min="1" max="5000">

            <label for="gender">Categoria:</label>
            <select id="gender" name="gender" required>
                <option value="">Selecione</option>
                <option value="masculino">Masculino</option>
                <option value="feminino">Feminino</option>
                <option value="misto">Misto</option>
            </select>

            <button type="submit">Criar time</button>
        </form>
        <a href="teams.php" class="back-link">Voltar para times</a>
    </main>
    <nav class="bottom-nav">
        <a href="home.php"><i class="fa-slab-press-duo fa-regular fa-house"></i></a>
        <a href="lists.php"><i class="fa-solid fa-list"></i></a>
        <a href="candidates.php"><i class="fa-solid fa-inbox"></i></a>
        <a href="registration.php"><i class="fa-solid fa-user-pen"></i></a>
        <a href="news.php"><i class="fa-solid fa-newspaper"></i></a>
        <a href="newsConfig.php"><i class="fa-brands fa-leanpub"></i></a>
        <a href="authorization.php"><i class="fa-solid fa-user-gear"></i></a>
        <a href="teamRegistration.php" class="active"><i class="fa-solid fa-arrows-down-to-people"></i></a>
        <a href="teams.php"><i class="fa-solid fa-people-group"></i></a>
    </nav>
</body>
</html>
