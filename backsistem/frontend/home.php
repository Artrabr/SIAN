<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIAN - Home</title>
    <link rel="stylesheet" href="style/mainstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.css" integrity="sha512-x9WwyMYBnlXMNQ6kQ/Lyzu1NqIhLQKL5Oq6xByfXuRj7s9CskyCbLv/1IjqzJmXwFXWr0ov6jBV7Qbc0hh9nHg==" crossorigin="anonymous" referrerpolicy="no-referrer">
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
            <a href="registration.php" class="action-card primary">
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
        <a href="home.php" class="active"><i class="fa-slab-press-duo fa-regular fa-house" style="color: rgb(255, 255, 255);"></i></i></a>
        <a href="lists.php"><i class="fa-solid fa-list" style="color: rgb(255, 255, 255);"></i></a>
        <a href="candidates.php"><i class="fa-solid fa-inbox" style="color: rgb(255, 255, 255);"></i></a>
        <a href="registration.php"><i class="fa-solid fa-user-pen" style="color: rgb(255, 255, 255);"></i></a>
        <a href="news.php"><i class="fa-solid fa-newspaper" style="color: rgb(255, 255, 255);"></i></a>
        <a href="authorization.php"><i class="fa-solid fa-user-gear" style="color: rgb(255, 255, 255);"></i></a>
    </nav>
</body>
</html>