<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NOIA VÔLEI - Official Website</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="style/base.css">
    <link rel="stylesheet" href="style/logosize.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- ==========================================
         NAVBAR / CABEÇALHO
         ========================================== -->
    <header>
        <div class="nav-container">
            <div class="brand">
                <!-- ESPAÇO DO BRASÃO NO HEADER -->
                <div class="crest-header crest-placeholder      ">
                    <img src="imagens/noialogo.png" alt="logo noia" class="logo-size01">
                </div>
                <div class="brand-text">NOIA <span>VÔLEI</span></div>
            </div>

            <nav>
                <ul class="nav-menu">
                    <li><a href="#inicio" class="nav-link active">Início</a></li>
                    <li><a href="#equipes" class="nav-link">Equipes</a></li>
                    <li><a href="#participar" class="nav-link">Quero Participar</a></li>
                    <li>
                        <a href="#sian" class="nav-link">
                            SIAN <span class="badge-sian">SISTEMA</span>
                        </a>
                    </li>
                    <li>
                        <button class="btn-login" onclick="toggleLoginModal()">Login / Entrar</button>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- ==========================================
         HERO / BANNER PRINCIPAL
         ========================================== -->
    <section id="inicio" class="hero">
        <div class="hero-bg" aria-hidden="true">
            <div class="hero-bg-slide active" style="background-image: url('imagens/banner/ft1.jpeg');"></div>
            <div class="hero-bg-slide" style="background-image: url('imagens/banner/ft2.jpeg');"></div>
            <div class="hero-bg-slide" style="background-image: url('imagens/banner/ft3.jpeg');"></div>
        </div>

        <div class="container hero-container">
            <div class="hero-content">
                <div class="crest-placeholder crest-hero">
                    <img src="imagens/noialogo.png" alt="logo noia" class="logo-size02">
                </div>
                <h1>NOIA <span>VÔLEI</span></h1>
                <p>Garra, técnica e tradição nas quadras. Acompanhe nossas partidas, categorias de base e novidades do nosso time oficial.</p>
                <div style="display: flex; gap: 15px;">
                    <a href="#participar" class="btn-cyan">Faça o Teste</a>
                    <a href="#sian" class="btn-login" style="padding: 12px 24px;">Conheça o SIAN</a>
                </div>
            </div>

            <!-- CARD DE PRÓXIMO JOGO ->
            <div class="hero-card">
                <div class="match-widget-header">
                    <span class="match-title">⚡ Próximo Confronto</span>
                    <span style="font-size: 0.75rem; color: var(--text-dim);">Campeonato Estadual</span>
                </div>

                <div class="php-block">
                    <span class="php-tag">&lt;?php</span><br>
                    <span class="php-comment">// ESPAÇO PHP: Carregar dados do próximo jogo dinamicamente do banco de dados</span><br>
                    <span class="php-tag">?&gt;</span>
                </div>

                <div class="match-teams">
                    <div class="team-box">
                        <div class="crest-placeholder crest-card">NOIA</div>
                        <span class="team-name">NOIA VÔLEI</span>
                    </div>

                    <div class="vs-badge">VS</div>

                    <div class="team-box">
                        <div class="crest-placeholder crest-card">RIVAL</div>
                        <span class="team-name">ADVERSÁRIO</span>
                    </div>
                </div>

                <div style="text-align: center; color: var(--text-muted); font-size: 0.85rem; margin-top: 15px;">
                    📅 Sábado, 20:00h | 📍 Ginásio Principal
                </div>
            </div> -->
        </div>
    </section>

    <!-- ==========================================
         SEÇÃO INÍCIO: DESTAQUES E NOTÍCIAS
         ========================================== -->
    <section>
        <div class="container">
            <div class="section-header">
                <div>
                    <h2 class="section-title">Últimas Notícias</h2>
                    <p class="section-subtitle">Fique por dentro de tudo o que acontece no Noia Vôlei</p>
                </div>
            </div>

            <div class="php-block">
                <span class="php-tag">&lt;?php</span><br>
                <span class="php-comment">// ESPAÇO PHP: Loop de notícias recentes integradas via CMS / SIAN</span><br>
                <span class="php-tag">?&gt;</span>
            </div>

            <div class="news-grid">
                <div class="news-card">
                    <div class="news-img-placeholder">[ FOTO DA PARTIDA / NOTÍCIA ]</div>
                    <div class="news-body">
                        <span class="news-tag">Vitória</span>
                        <h3 class="news-title">Noia Vôlei vence o clássico no tie-break e avança para as finais</h3>
                        <p style="color: var(--text-muted); font-size: 0.85rem;">Com atuação impecável do sistema defensivo, a equipe garantiu a vaga na decisão...</p>
                    </div>
                </div>

                <div class="news-card">
                    <div class="news-img-placeholder">[ FOTO DA PENEIRA ]</div>
                    <div class="news-body">
                        <span class="news-tag">Base</span>
                        <h3 class="news-title">Abertas as inscrições para a Peneira Sub-19 e Sub-21</h3>
                        <p style="color: var(--text-muted); font-size: 0.85rem;">Buscamos novos talentos para integrar o projeto na próxima temporada de competições...</p>
                    </div>
                </div>

                <div class="news-card">
                    <div class="news-img-placeholder">[ FOTO SIAN / TECNOLOGIA ]</div>
                    <div class="news-body">
                        <span class="news-tag">Tecnologia</span>
                        <h3 class="news-title">Sistema SIAN passa a gerenciar 100% da preparação física do elenco</h3>
                        <p style="color: var(--text-muted); font-size: 0.85rem;">Plataforma desenvolvida internamente otimizou rendimento e prevenção de lesões...</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================
         SEÇÃO EQUIPES
         ========================================== -->
    <section id="equipes">
        <div class="container">
            <div class="section-header">
                <div>
                    <h2 class="section-title">Nossas Equipes</h2>
                    <p class="section-subtitle">Atletas e comissão técnica que defendem as cores do Noia Vôlei</p>
                </div>
            </div>

            <div class="team-tabs">
                <button class="tab-btn active">Masculino Principal</button>
                <button class="tab-btn">Feminino Principal</button>
                <button class="tab-btn">Sub-21 Base</button>
                <button class="tab-btn">Comissão Técnica</button>
            </div>

            <div class="php-block">
                <span class="php-tag">&lt;?php</span><br>
                <span class="php-comment">// ESPAÇO PHP: Query para buscar elenco ativo por categoria</span><br>
                <span class="php-tag">?&gt;</span>
            </div>

            <div class="players-grid">
                <!-- Atleta 1 -->
                <div class="player-card">
                    <span class="player-num">10</span>
                    <div class="player-photo-placeholder">[ FOTO ATLETA ]</div>
                    <h3 class="player-name">Carlos "Kapow"</h3>
                    <span class="player-pos">Ponteiro / Capitão</span>
                </div>

                <!-- Atleta 2 -->
                <div class="player-card">
                    <span class="player-num">07</span>
                    <div class="player-photo-placeholder">[ FOTO ATLETA ]</div>
                    <h3 class="player-name">Lucas Silva</h3>
                    <span class="player-pos">Levantador</span>
                </div>

                <!-- Atleta 3 -->
                <div class="player-card">
                    <span class="player-num">18</span>
                    <div class="player-photo-placeholder">[ FOTO ATLETA ]</div>
                    <h3 class="player-name">Mateus Rocha</h3>
                    <span class="player-pos">Central</span>
                </div>

                <!-- Atleta 4 -->
                <div class="player-card">
                    <span class="player-num">01</span>
                    <div class="player-photo-placeholder">[ FOTO ATLETA ]</div>
                    <h3 class="player-name">Gabriel Santos</h3>
                    <span class="player-pos">Líbero</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================
         SEÇÃO QUERO PARTICIPAR
         ========================================== -->
    <section id="participar">
        <div class="container">
            <div class="section-header">
                <div>
                    <h2 class="section-title">Quero Participar</h2>
                    <p class="section-subtitle">Quer jogar no Noia Vôlei, treinar conosco e evoluir apartir da nossa equipe? Preencha o formulario abaixo!</p>
                </div>
            </div>

            <div class="participate-box">
                <div>
                    <h3 style="font-family: var(--font-heading); font-size: 1.5rem; margin-bottom: 15px; color: var(--cyan-accent);">
                        Faça Parte da Família Noia
                    </h3>
                    <p style="color: var(--text-muted); margin-bottom: 20px;">
                        Realizamos testes periodicos para nossas categorias masculinas e femininas. Preencha seus dados para entrar na fila de ingresso na equipe.
                    </p>

                    <div class="php-block">
                        <span class="php-tag">&lt;?php</span><br>
                        <span class="php-comment">// ESPAÇO PHP: Processamento do formulário de pré-inscrição (envio para o banco / SIAN)</span><br>
                        <span class="php-tag">?&gt;</span>
                    </div>
                </div>

                <form action="../backsistem/backend/process/website/psc_newCandidate.php" method="POST">
                    <div class="form-group">
                        <label>Nome Completo</label>
                        <input type="text" name="name" class="form-control" placeholder="Seu nome completo" required>
                    </div>
                    <div class="form-group">
                        <label>Gênero</label>
                        <select name="gender" class="form-control" required>
                            <option value="">Selecione...</option>
                            <option value="homem">Homem</option>
                            <option value="mulher">Mulher</option>
                        </select>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div class="form-group">
                            <label>data de nascimento</label>
                            <input type="date" name="birthDate" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Altura (cm)</label>
                            <input type="number" name="hight" class="form-control" step="0.01" placeholder="Ex: 1.88" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Posição Principal</label>
                        <select name="position" class="form-control" required>
                            <option value="">Selecione...</option>
                            <option value="levantador">Levantador(a)</option>
                            <option value="ponteiro">Ponteiro(a)</option>
                            <option value="oposto">Oposto(a)</option>
                            <option value="central">Central</option>
                            <option value="libero">Líbero</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Cidade em que reside</label>
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
                    </div>

                    <div class="form-group">
                        <label>Rede Social (instagram)</label>
                        <input type="text" name="instagram" class="form-control" placeholder="@userparacontato">
                    </div>

                    <div class="form-group">
                        <label>WhatsApp</label>
                        <input type="text" name="contact" class="form-control" placeholder="(00) 00000-0000" required>
                    </div>

                    <button type="submit" class="btn-cyan" style="width: 100%;">Enviar Cadastro</button>
                </form>
            </div>
        </div>
    </section>

    <!-- ==========================================
         SEÇÃO SIAN - SISTEMA INTERNO DE ADMINISTRAÇÃO NOIA
         ========================================== -->
    <section id="sian" class="sian-section">
        <div class="container">
            <div class="sian-card">
                <div class="sian-header">
                    <div class="sian-logo-badge">SIAN</div>
                    <div>
                        <h2 style="font-family: var(--font-heading); font-size: 1.8rem; text-transform: uppercase;">
                            Sistema Interno de Administração Noia
                        </h2>
                        <p style="color: var(--cyan-accent); font-weight: 600;">Plataforma completa de gestão esportiva e corporativa</p>
                    </div>
                </div>

                <p style="color: var(--text-muted); font-size: 1rem;">
                    O <strong>SIAN</strong> é a plataforma tecnológica proprietária do <strong>NOIA VÔLEI</strong>, desenvolvida para integrar toda a gestão de atletas, treinos, frequência, dados de desempenho e controle financeiro da equipe.
                </p>

                <div class="php-block">
                    <span class="php-tag">&lt;?php</span><br>
                    <span class="php-comment">// ESPAÇO PHP: Módulo de integração de APIs do SIAN no site público</span><br>
                    <span class="php-tag">?&gt;</span>
                </div>

                <div class="sian-features">
                    <div class="sian-feat-item">
                        <h4>📊 Gestão de Performance</h4>
                        <p>Acompanhamento de estatísticas de jogo, scout técnico, taxas de acerto de ataque e passe em tempo real.</p>
                    </div>

                    <div class="sian-feat-item">
                        <h4>📋 Controle de Treinos</h4>
                        <p>Gestão de frequência, carga física, alertas de fadiga muscular e calendário de treinos do elenco.</p>
                    </div>

                    <div class="sian-feat-item">
                        <h4>💳 Gestão Financeira</h4>
                        <p>Administração de mensalidades, patrocínios, custos de viagens e fluxo de caixa completo.</p>
                    </div>

                    <div class="sian-feat-item">
                        <h4>🔐 Portal do Atleta Integrado</h4>
                        <p>Acesso exclusivo para os membros do time acompanharem suas métricas e rotinas na Área do Cliente.</p>
                    </div>
                </div>

                <!-- B2B MARKETING DO SIAN -->
                <div class="sian-b2b-box">
                    <h3>🚀 Leve o SIAN para o seu Time ou Empresa!</h3>
                    <p style="color: var(--text-muted); max-width: 800px; margin: 0 auto 15px auto;">
                        O SIAN não é exclusivo do Noia Vôlei! Comercializamos e adaptamos o sistema para outras equipes esportivas, academias, ligas e empresas que buscam alta performance em gestão de pessoas e métricas.
                    </p>
                    <button class="btn-cyan" onclick="alert('Entre em contato comercial pelo e-mail: comercial@sian.com.br');">Solicitar Demonstração Comercial</button>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================
         SISTEMA DE LOGIN E ÁREA DO CLIENTE
         ========================================== -->
    <section id="login-area">
        <div class="container">
            <div class="section-header">
                <div>
                    <h2 class="section-title">Login / Área do Cliente</h2>
                    <p class="section-subtitle">Acesse seu painel integrado ao SIAN</p>
                </div>
            </div>

            <!-- CARD DE LOGIN -->
            <div id="login-form-box" style="max-width: 450px; margin: 0 auto; background: var(--bg-card); border: 1px solid var(--border-color); padding: 30px; border-radius: 12px;">
                <div style="text-align: center; margin-bottom: 20px;">
                    <div class="crest-placeholder crest-card" style="margin: 0 auto 10px auto;"><img src="imagens/noialogo.png" alt="logo noia" class="logo-size01"></div>
                    <h3 style="font-family: var(--font-heading);">Acessar Conta</h3>
                </div>

                <div class="php-block">
                    <span class="php-tag">&lt;?php</span><br>
                    <span class="php-comment">// ESPAÇO PHP: Validação de login e inicialização de $_SESSION</span><br>
                    <span class="php-tag">?&gt;</span>
                </div>

                <form onsubmit="event.preventDefault(); simularLogin();">
                    <div class="form-group">
                        <label>Usuário / E-mail</label>
                        <input type="text" id="login-user" class="form-control" value="atleta@noiavolei.com" required>
                    </div>
                    <div class="form-group">
                        <label>Senha</label>
                        <input type="password" class="form-control" value="123456" required>
                    </div>
                    <button type="submit" class="btn-cyan" style="width: 100%;">Entrar na Área do Cliente</button>
                </form>
            </div>

            <!-- ÁREA DO CLIENTE (POS-LOGIN) -->
            <div id="client-dashboard" class="client-area-box">
                <div class="client-header">
                    <div class="user-profile">
                        <div class="user-avatar">NV</div>
                        <div>
                            <h3 style="font-family: var(--font-heading);" id="user-display-name">Atleta Noia Vôlei</h3>
                            <span style="color: var(--cyan-accent); font-size: 0.85rem;">Status SIAN: Ativo | Categoria: Principal</span>
                        </div>
                    </div>
                    <button class="btn-login" onclick="simularLogout()">Sair / Logout</button>
                </div>

                <div class="php-block">
                    <span class="php-tag">&lt;?php</span><br>
                    <span class="php-comment">// ESPAÇO PHP: Seção restrita - dados puxados em tempo real do banco SIAN</span><br>
                    <span class="php-tag">?&gt;</span>
                </div>

                <h4 style="font-family: var(--font-heading); margin-bottom: 15px; color: var(--text-main);">Seu Painel de Desempenho & Frequência</h4>

                <div class="client-dashboard-grid">
                    <div class="dash-card">
                        <span style="color: var(--text-muted); font-size: 0.85rem;">Presença em Treinos</span>
                        <div class="val">96%</div>
                    </div>

                    <div class="dash-card">
                        <span style="color: var(--text-muted); font-size: 0.85rem;">Mensalidade</span>
                        <div class="val" style="color: #4ade80;">EM DIA</div>
                    </div>

                    <div class="dash-card">
                        <span style="color: var(--text-muted); font-size: 0.85rem;">Próximo Treino</span>
                        <div class="val" style="font-size: 1.1rem; margin-top: 15px;">Amanhã - 18:00h</div>
                    </div>

                    <div class="dash-card">
                        <span style="color: var(--text-muted); font-size: 0.85rem;">Métricas no SIAN</span>
                        <div class="val">Scout ok</div>
                    </div>
                </div>

                <div style="margin-top: 25px; padding: 20px; background: #0d1017; border-radius: 8px; border: 1px solid var(--border-color);">
                    <h5 style="font-family: var(--font-heading); color: var(--cyan-accent); margin-bottom: 10px;">Atalhos Rápida do SIAN</h5>
                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <button class="btn-login" style="font-size: 0.75rem;">Ver Relatório Fisico</button>
                        <button class="btn-login" style="font-size: 0.75rem;">Solicitar Uniforme</button>
                        <button class="btn-login" style="font-size: 0.75rem;">Emitir Comprovante</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================
         RODAPÉ (FOOTER)
         ========================================== -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div>
                    <div class="brand" style="margin-bottom: 15px;">
                        <!-- ESPAÇO DO BRASÃO NO FOOTER -->
                        <div class="crest-placeholder crest-footer">
                            <img src="imagens/noialogo.png" alt="logo noia" class="logo-size01">
                        </div>
                        <div class="brand-text">NOIA <span>VÔLEI</span></div>
                    </div>
                    <p style="color: var(--text-muted); font-size: 0.85rem;">
                        Clube de voleibol focado em excelência esportiva, formação de atletas e tecnologia em gestão.
                    </p>
                </div>

                <div>
                    <h4 style="font-family: var(--font-heading); margin-bottom: 15px; color: var(--cyan-accent);">Navegação</h4>
                    <ul style="font-size: 0.85rem; color: var(--text-muted); line-height: 2;">
                        <li><a href="#inicio">Início</a></li>
                        <li><a href="#equipes">Equipes</a></li>
                        <li><a href="#participar">Quero Participar</a></li>
                        <li><a href="#sian">Plataforma SIAN</a></li>
                    </ul>
                </div>

                <div>
                    <h4 style="font-family: var(--font-heading); margin-bottom: 15px; color: var(--cyan-accent);">SIAN B2B</h4>
                    <ul style="font-size: 0.85rem; color: var(--text-muted); line-height: 2;">
                        <li><a href="#sian">Sobre o SIAN</a></li>
                        <li><a href="#sian">Planos para Empresas</a></li>
                        <li><a href="#sian">Agendar Demonstração</a></li>
                    </ul>
                </div>

                <div>
                    <h4 style="font-family: var(--font-heading); margin-bottom: 15px; color: var(--cyan-accent);">Contato</h4>
                    <p style="font-size: 0.85rem; color: var(--text-muted);">
                        📍 Ginásio Noia Vôlei<br>
                        📧 contato@noiavolei.com.br<br>
                        📱 (00) 99999-9999
                    </p>
                </div>
            </div>

            <div class="php-block" style="text-align: center;">
                <span class="php-tag">&lt;?php</span> 
                <span class="php-comment">// ESPAÇO PHP: Rodapé dinâmico / direitos autorais e inclusões de scripts</span> 
                <span class="php-tag">?&gt;</span>
            </div>

            <div class="footer-bottom">
                &copy; <?php echo date("Y"); ?> NOIA VÔLEI & SIAN System. Todos os direitos reservados.
            </div>
        </div>
    </footer>

    <!-- SCRIPT DE NAVEGAÇÃO E SIMULAÇÃO DE LOGIN -->
    <script>
        const heroSlides = document.querySelectorAll('.hero-bg-slide');

        if (heroSlides.length > 1) {
            let currentSlide = 0;

            setInterval(() => {
                heroSlides[currentSlide].classList.remove('active');
                currentSlide = (currentSlide + 1) % heroSlides.length;
                heroSlides[currentSlide].classList.add('active');
            }, 4000);
        }

        function toggleLoginModal() {
            document.getElementById('login-area').scrollIntoView({ behavior: 'smooth' });
        }

        function simularLogin() {
            const username = document.getElementById('login-user').value || 'Atleta Noia Vôlei';
            document.getElementById('login-form-box').style.display = 'none';
            document.getElementById('client-dashboard').style.display = 'block';
            document.getElementById('user-display-name').innerText = username;
            document.getElementById('client-dashboard').scrollIntoView({ behavior: 'smooth' });
        }

        function simularLogout() {
            document.getElementById('client-dashboard').style.display = 'none';
            document.getElementById('login-form-box').style.display = 'block';
        }
    </script>

</body>
</html>
