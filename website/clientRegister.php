<?php
$errorMessage = $_GET['error'] ?? null;
$successMessage = $_GET['success'] ?? null;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro do Cliente | NOIA Vôlei</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="style/base.css">
    <link rel="stylesheet" href="style/logosize.css">
    <link rel="stylesheet" href="style/register.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="nav-container">
            <div class="brand">
                <div class="crest-header crest-placeholder">
                    <img src="imagens/noialogo.png" alt="logo noia" class="logo-size01">
                </div>
                <div class="brand-text">NOIA <span>VÔLEI</span></div>
            </div>

            <nav>
                <ul class="nav-menu">
                    <li><a href="index.php" class="nav-link">Início</a></li>
                    <li><a href="index.php#equipes" class="nav-link">Equipes</a></li>
                    <li><a href="index.php#participar" class="nav-link">Quero Participar</a></li>
                    <li><a href="index.php#sian" class="nav-link">SIAN <span class="badge-sian">SISTEMA</span></a></li>
                    <li><a href="clientRegister.php" class="nav-link active">Cadastro</a></li>
                    <li><a href="index.php#login-area" class="btn-login">Login / Entrar</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="register-main">
        <div class="container">
            <section class="register-shell">
                <div class="register-copy">
                    <div class="register-visual" aria-hidden="true">
                        <div class="register-bg-slide active" style="background-image: url('imagens/banner/ft1.jpeg');"></div>
                        <div class="register-bg-slide" style="background-image: url('imagens/banner/ft2.jpeg');"></div>
                        <div class="register-bg-slide" style="background-image: url('imagens/banner/ft3.jpeg');"></div>
                    </div>

                    <div class="register-copy-inner">
                        <p class="eyebrow">Cadastro</p>
                        <h1>Faça parte do <span>NOIA</span></h1>
                        <p>Preencha seus dados para cadastrar-se na equipe para ter acesso ao paindel do atleta, participar de torneios, amistosos, receber informações da equipe e acompanhar sua jornada no voleibol.</p>

                        <div class="register-benefits">
                            <div class="benefit-item"><span>✓</span> Cadastro rápido e seguro</div>
                            <div class="benefit-item"><span>✓</span> Acompanhe equipe e pagamentos</div>
                            <div class="benefit-item"><span>✓</span> Fique por dentro das oportunidades</div>
                        </div>
                    </div>
                </div>

                <div class="register-card">
                    <?php if (!empty($successMessage)): ?>
                        <div class="alert alert-success">Cadastro realizado com sucesso! Agora você pode entrar na área do cliente.</div>
                    <?php endif; ?>

                    <?php if (!empty($errorMessage)): ?>
                        <div class="alert alert-error">Não foi possível concluir o cadastro. Verifique os dados e tente novamente.</div>
                    <?php endif; ?>

                    <div style="background: rgba(239, 68, 68, 0.1); border-left: 4px solid #ef4444; padding: 12px 14px; border-radius: 6px; margin-bottom: 20px; font-size: 0.9rem; color: #fca5a5;">
                        <strong>*</strong> Para realizar o registro é preciso participar de ao menos um treino NOIA aonde validaremos seu CPF.
                    </div>

                    <form action="process/webregister.php" method="POST" class="register-form">
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="cpf">CPF</label>
                                <input id="cpf" type="text" name="cpf" class="form-control" placeholder="000.000.000-00" required>
                            </div>

                            <div class="form-group">
                                <label for="password">Senha</label>
                                <input id="password" type="password" name="password" class="form-control" placeholder="Crie sua senha" required>
                            </div>

                            <div class="form-group full">
                                <label for="name">Nome completo</label>
                                <input id="name" type="text" name="name" class="form-control" placeholder="Seu nome completo" required>
                            </div>

                            <div class="form-group">
                                <label for="contact">Contato</label>
                                <input id="contact" type="tel" name="contact" class="form-control" placeholder="(51) 99999-9999" required>
                            </div>

                            <div class="form-group">
                                <label for="birthDate">Data de nascimento</label>
                                <input id="birthDate" type="date" name="birthDate" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="position">Posição</label>
                                <select id="position" name="position" class="form-control" required>
                                    <option value="">Selecione...</option>
                                    <option value="levantador">Levantador(a)</option>
                                    <option value="ponteiro">Ponteiro(a)</option>
                                    <option value="oposto">Oposto(a)</option>
                                    <option value="central">Central</option>
                                    <option value="libero">Líbero</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="city">Cidade</label>
                                <select id="city" name="city" class="form-control" required>
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
                            </div>

                            <div class="form-group">
                                <label for="hight">Altura (cm)</label>
                                <input id="hight" type="number" name="hight" class="form-control" step="0.01" min="100" max="250" placeholder="Ex: 188" required>
                            </div>

                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input id="email" type="email" name="email" class="form-control" placeholder="seuemail@email.com" required>
                            </div>

                            <div class="form-group">
                                <label for="payMethod">Pagamento</label>
                                <select id="payMethod" name="payMethod" class="form-control" required>
                                    <option value="">Selecione...</option>
                                    <option value="diaria">Diária</option>
                                    <option value="mensal">Mensal</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="gender">Gênero</label>
                                <select id="gender" name="gender" class="form-control" required>
                                    <option value="">Selecione...</option>
                                    <option value="homem">Homem</option>
                                    <option value="mulher">Mulher</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="team">Time</label>
                                <select id="team" name="team" class="form-control" required>
                                    <option value="">Selecione...</option>
                                    <option value="masculino">Masculino</option>
                                    <option value="feminino">Feminino</option>
                                </select>
                            </div>

                            <div class="form-group full">
                                <label for="instagram">Instagram (opcional)</label>
                                <input id="instagram" type="text" name="instagram" class="form-control" placeholder="@seuinsta">
                            </div>
                        </div>

                        <div class="submit-row">
                            <button type="submit" class="btn-submit">Salvar cadastro</button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </main>
    <script>
        const registerSlides = document.querySelectorAll('.register-bg-slide');
        let registerSlideIndex = 0;

        if (registerSlides.length > 1) {
            setInterval(() => {
                registerSlides[registerSlideIndex].classList.remove('active');
                registerSlideIndex = (registerSlideIndex + 1) % registerSlides.length;
                registerSlides[registerSlideIndex].classList.add('active');
            }, 2600);
        }
    </script>
</body>
</html>
