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

            <label for="gender">Gênero:</label>
            <select name="gender" id="gender" required>
                <option value="">Selecione</option>
                <option value="homem">Homem</option>
                <option value="mulher">Mulher</option>
            </select>

            <label for="hight">Altura (cm):</label>
            <input type="number" name="hight" id="hight" min="100" max="250" step="1" required placeholder="ex: 188">

            <label for="cpf">CPF:</label>
            <input type="text" name="cpf" id="cpf" required placeholder="000.000.000-00">
            
            <label for="instagram">Instagram:</label>
            <input type="text" name="instagram" id="instagram" required placeholder="@name">

            <label for="contact">Contato:</label>
            <input type="text" name="contact" id="contact" min="0" required>

            <label for="birth">Data de nascimento:</label>
            <input type="date" name="birthDate" id="birthDate" required>

            <label for="position">Posição Principal</label>
                <select name="position" class="form-control" required>
                    <option value="">Selecione...</option>
                    <option value="levantador">Levantador(a)</option>
                    <option value="ponteiro">Ponteiro(a)</option>
                    <option value="oposto">Oposto(a)</option>
                    <option value="central">Central</option>
                    <option value="libero">Líbero</option>
                </select>

            <label for="city">Cidade:</label>
            <select name="city" class="form-control" required>
                    <option value="">Selecione...</option>
                    <option value="Novo Hamburgo">Novo Hamburgo</option>
                    <option value="São Leopoldo">São Leopoldo</option>
                    <option value="Estancia Velha">Estancia Velha</option>
                    <option value="Campo Bom">Campo Bom</option>
                    <option value="Sapucaia do Sul">Sapucaia do Sul</option>
                    <option value="Esteio">Esteio</option>
                    <option value="Canoas">Canoas</option>
                    <option value="Porto Alegre">Porto Alegre</option>
                    <option value="Ivoti">Ivoti</option>
                </select>

            <label for="payMethod">Metodo de pagamento:</label>
            <select name="payMethod" id="payMethod" required>
                <option value="">Selecione</option>
                <option value="diaria">Diaria</option>
                <option value="mensal">Mensal</option>
            </select>

            <label for="team">Equipe:</label>
            <select name="team" id="team" required>
                <option value="">Selecione</option>
                <option value="a">Equipe a</option>
                <option value="b">Equipe b</option>
                <option value="c">Equipe c</option>
                <option value="d">Equipe d</option>
            </select>

            <button type="submit">Criar atleta</button>
        </form>

        <a href="home.php" class="back-link">← Voltar ao home</a>
    </main>

    <nav class="bottom-nav">
        <a href="home.php">Início</a>
        <a href="lists.php">Listas</a>
        <a href="registration.php" class="active">Cadastrar</a>
    </nav>
</body>
</html>
