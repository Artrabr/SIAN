<?php
$mensagem = $_GET['status'] ?? null;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIAN - Nova notícia</title>
    <link rel="stylesheet" href="style/mainstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.css" integrity="sha512-x9WwyMYBnlXMNQ6kQ/Lyzu1NqIhLQKL5Oq6xByfXuRj7s9CskyCbLv/1IjqzJmXwFXWr0ov6jBV7Qbc0hh9nHg==" crossorigin="anonymous" referrerpolicy="no-referrer">
</head>
<body>
    <header class="topbar">
        <img src="style/logo-sian.png" alt="Logo SIAN" class="logo">
        <div>
            <h1>SIAN</h1>
            <p>Publicar notícia</p>
        </div>
    </header>

    <main class="content-card">
        <section class="page-intro">
            <h2>Nova notícia</h2>
            <p>Preencha os dados abaixo para preparar uma publicação para o site.</p>
        </section>

        <?php if ($mensagem === 'sucesso'): ?>
            <p class="notice success">Notícia enviada para processamento.</p>
        <?php elseif ($mensagem === 'erro'): ?>
            <p class="notice error">Não foi possível enviar a notícia. Confira os dados.</p>
        <?php endif; ?>

        <form action="../backend/process/psc_newNews.php" method="POST" enctype="multipart/form-data" class="athlete-form news-form">
            <div class="form-field">
                <label for="category">Categoria ou assunto</label>
                <input id="category" type="text" name="category" maxlength="80" placeholder="Ex.: Base, Vitória, SIAN" required>
            </div>

            <div class="form-field">
                <label for="title">Título da notícia</label>
                <input id="title" type="text" name="title" maxlength="180" placeholder="Digite um título claro e objetivo" required>
            </div>

            <div class="form-field">
                <label for="description">Descrição</label>
                <textarea id="description" name="description" maxlength="5000" rows="8" placeholder="Escreva o conteúdo ou resumo da notícia" required></textarea>
                <small class="field-help"><span id="description-count">0</span>/5000 caracteres</small>
            </div>

            <div class="form-field">
                <label for="photo">Foto da notícia</label>
                <div class="news-upload">
                    <input id="photo" type="file" name="photo" accept="image/jpeg,image/png,image/webp" required>
                    <label for="photo" class="news-upload-label">
                        <span class="news-upload-icon" aria-hidden="true">↑</span>
                        <span class="news-upload-copy">
                            <strong>Escolher foto</strong>
                            <small id="photo-file-name">Nenhum arquivo escolhido</small>
                        </span>
                    </label>
                </div>
                <small class="field-help">Formatos aceitos: JPG, PNG ou WEBP. Limite recomendado: 5 MB.</small>
                <div class="news-image-preview" id="image-preview" hidden>
                    <img id="image-preview-img" alt="Pré-visualização da foto selecionada">
                </div>
            </div>

            <div class="news-form-actions">
                <a href="home.php" class="back-link">Cancelar</a>
                <button type="submit" class="news-submit">Preparar publicação</button>
            </div>
        </form>
    </main>

    <nav class="bottom-nav">
        <a href="home.php"><i class="fa-regular fa-house" aria-label="Início"></i></a>
        <a href="lists.php"><i class="fa-solid fa-list" aria-label="Atletas"></i></a>
        <a href="candidates.php"><i class="fa-solid fa-inbox" aria-label="Candidatos"></i></a>
        <a href="registration.php"><i class="fa-solid fa-user-pen" aria-label="Cadastrar"></i></a>
        <a href="news.php" class="active"><i class="fa-solid fa-newspaper" aria-label="Notícias"></i></a>
        <a href="authorization.php"><i class="fa-solid fa-user-gear" aria-label="Autorizações"></i></a>
    </nav>

    <script>
        const description = document.getElementById('description');
        const descriptionCount = document.getElementById('description-count');
        const photo = document.getElementById('photo');
        const photoFileName = document.getElementById('photo-file-name');
        const preview = document.getElementById('image-preview');
        const previewImage = document.getElementById('image-preview-img');

        description.addEventListener('input', function () {
            descriptionCount.textContent = description.value.length;
        });

        photo.addEventListener('change', function () {
            const file = photo.files[0];
            if (!file) {
                photoFileName.textContent = 'Nenhum arquivo escolhido';
                preview.hidden = true;
                previewImage.removeAttribute('src');
                return;
            }

            photoFileName.textContent = file.name;
            previewImage.src = URL.createObjectURL(file);
            preview.hidden = false;
        });
    </script>
</body>
</html>
