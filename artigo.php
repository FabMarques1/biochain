<?php

session_start();

$autor = $_GET['author'];
$artigo = $_GET['article'];

if(isset($_SESSION['auth'])){
    $user_name = $_SESSION['username'];
    $user_profile = $_SESSION['user'];
    $user_photo = $_SESSION['photo'];
    $cargo = $_SESSION['cargo'];
} else{
    $user_photo = "frontend/assets/icons/incognito.svg";
    $user_name = "Anônimo";
    $user_profile = "Anônimo";
}

?>

<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Título do Artigo - BioAlumnus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="frontend/styles/index.css?">
    <link rel="icon" href="frontend/assets/icons/icon.png">
</head>
<body>
    <div class="reading-progress" id="readingProgress" aria-hidden="true"></div>

    <div class="focus-exit-banner" role="status" aria-live="polite">
        <i class="bi bi-eye"></i> Modo leitura ativo
        <button type="button" id="exitFocusBtn"><i class="bi bi-x-lg"></i> Sair (Esc)</button>
    </div>

    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-flower1"></i>
                BioAlumnus
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="index.php">Início</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Sobre</a></li>
                    <li class="nav-item"><a class="nav-link" href="lupa.html">Lupa</a></li>
                </ul>
                <form class="d-flex" role="search">
                    <div class="input-group">
                        <input class="form-control" type="search" placeholder="Buscar na wiki..." aria-label="Buscar">
                        <button class="btn btn-verde" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </form>
                <div class="dropdown ms-3">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?php echo $user_photo; ?>" alt="Usuário" class="rounded-circle me-2" style="width: 38px; height: 38px; object-fit: cover; border: 2px solid var(--verde-mato);">
                        <span class="d-none d-lg-inline" style="color: var(--texto-principal);"><?php echo $user_profile; ?></span>
                    </a>
                    <?php if(isset($_SESSION['auth'])): ?>
                        <ul class="dropdown-menu dropdown-menu-end" style="background-color: var(--fundo-card); border: 1px solid var(--borda-sutil);">
                            <li><a class="dropdown-item" href="profile.php?user=<?php echo $user_profile; ?>" style="color: var(--texto-principal);"><i class="bi bi-person me-2"></i>Meu Perfil</a></li>
                            <li><a class="dropdown-item" href="#" style="color: var(--texto-principal);"><i class="bi bi-gear me-2"></i>Configurações</a></li>
                            <?php if($cargo > 1): ?>
                                <li><a class="dropdown-item" href="criar-artigo.php" style="color: var(--texto-principal);"><i class="bi bi-newspaper"></i> Criar artigo</a></li>
                            <?php endif; ?>
                            <li><hr class="dropdown-divider" style="border-color: var(--borda-sutil);"></li>
                            <li><a class="dropdown-item" href="backend/src/quit.php" style="color: #dc3545;"><i class="bi bi-box-arrow-right me-2"></i>Sair</a></li>
                        </ul>
                    <?php else: ?>
                        <ul class="dropdown-menu dropdown-menu-end" style="background-color: var(--fundo-card); border: 1px solid var(--borda-sutil);">
                            <li><a class="dropdown-item" href="login.php" style="color: var(--texto-principal);"><i class="bi bi-person me-2"></i>Fazer login</a></li>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title"><i class="bi bi-flower1 me-2"></i>BioAlumnus</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body p-0">
            <div class="p-3">
                
                <div class="d-flex align-items-center mb-3 p-2 rounded" style="background-color: rgba(45, 90, 39, 0.15); border: 1px solid var(--borda-sutil);">
                    <img src="<?php echo $user_photo; ?>" alt="Usuário" class="rounded-circle me-2" style="width: 42px; height: 42px; object-fit: cover; border: 2px solid var(--verde-mato);">
                    <a style="text-decoration: none;" href="profile.php?user=<?php echo $user_profile; ?>">
                        <div>
                            <?php if(isset($_SESSION['auth'])): ?>
                                <span class="d-block fw-semibold" style="color: var(--texto-principal);"><?php echo $user_name; ?></span>
                                <small style="color: var(--texto-secundario);"><?php echo $user_profile; ?></small>
                            <?php else: ?>
                                <a href="login.php"><span class="d-block fw-semibold" style="color: var(--texto-principal);">Fazer login</span></a>
                            <?php endif; ?>
                        </div>
                    </a>
                </div>
                <a href="backend/src/quit.php">
                    <button class="btn btn-danger opacity-75 col-12"><i class="bi bi-box-arrow-right me-2"></i>Sair</button>  
                </a>
                <hr>
                <input class="form-control mb-3" type="search" placeholder="Buscar na wiki...">
            </div>
            <p class="sidebar-title">Categorias</p>
            <ul class="sidebar-nav">
                <li><a href="artigos.php?theme=ecologia"><i class="bi bi-tree"></i>Ecologia</a></li>
            </ul>
            <p class="sidebar-title mt-4">Recursos</p>
            <ul class="sidebar-nav">
                <li><a href="#"><i class="bi bi-journal-text"></i>Artigos Recentes</a></li>
                <li><a href="#"><i class="bi bi-bookmark"></i>Salvos</a></li>
                <li><a href="#"><i class="bi bi-clock-history"></i>Histórico</a></li>
            </ul>
        </div>
    </div>

    <div class="container-fluid article-shell" style="margin-top: 76px;">
        <div class="row">
            <div class="col-lg-3 col-xl-2 d-none d-lg-block p-0 sidebar-col">
                <div class="sidebar">
                    <p class="sidebar-title">Categorias</p>
                    <ul class="sidebar-nav">
                        <li><a href="artigos.php?theme=ecologia"><i class="bi bi-tree"></i>Ecologia</a></li>
                    </ul>
                    <p class="sidebar-title mt-4">Recursos</p>
                    <ul class="sidebar-nav">
                        <li><a href="#"><i class="bi bi-journal-text"></i>Artigos Recentes</a></li>
                        <li><a href="#"><i class="bi bi-bookmark"></i>Salvos</a></li>
                        <li><a href="#"><i class="bi bi-clock-history"></i>Histórico</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-9 col-xl-10 article-main-col">
                <main class="main-content article-content-wrap" id="inicio">

                    <!-- Cabeçalho do Artigo -->
                    <header class="article-hero">
                        <span class="eyebrow"><i class="bi bi-bookmark-star"></i> TEMA / INTERESSE</span>
                        <h1 class="article-title">Seja bem-vindo ao BioAlumnus!</h1>
                        <p class="article-subtitle">Uma enciclopédia colaborativa de Biologia, feita por alunos e orientadores, pensada para você aprender sem distrações.</p>
                        <div class="article-meta">
                            <div class="article-author">
                                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&h=100&fit=crop&crop=face" alt="Fabricio Henrique">
                                <div>
                                    <div class="name">Nome do autor</div>
                                    <div class="role"><i>Cargo.</i></div>
                                </div>
                            </div>
                            <span class="meta-item"><i class="bi bi-calendar3"></i> Data</span>
                            <span class="meta-item"><i class="bi bi-eye"></i> Quantidade de Leituras</span>
                        </div>
                    </header>

                    <!-- Layout do artigo: corpo + TOC -->
                    <div class="article-layout">
                        <div>
                            <div class="article-body" id="articleBody" tabindex="0" aria-label="Conteúdo do artigo">

                                <p class="lead">E se eu pudessepneumultramicroscopicosilivoculcanocanioticosililactobailiosvivos</p>
                                <p></p>

                            </div>

                            <!-- Ações: curtir, salvar, compartilhar, comentar -->
                            <div class="article-actions" aria-label="Ações do artigo">

                                    <div class="actions-group">
                                        <button type="button" class="action-btn " id="likeBtn" aria-pressed="false">
                                            <i class="bi bi-heart"></i>
                                            <span id="likeCount">?</span>
                                        </button>
                                        <button type="button" class="action-btn " id="bookmarkBtn" aria-pressed="false">
                                            <i class="bi bi-bookmark"></i>
                                        </button>
                                        <a href="#comentarios" class="action-btn ">
                                            <i class="bi bi-chat-dots"></i> <span id="commentCountTop">?</span>
                                        </a>
                                        <button type="button" class="action-btn " id="shareBtn">
                                            <i class="bi bi-share"></i>
                                        </button>
                                    </div>

                            </div>

                            <!-- Comentários -->
                            <section class="comments-section" id="comentarios" aria-label="Comentários">
                                <h3><i class="bi bi-chat-square-text"></i> Comentários (<span id="commentCount">3</span>)</h3>

                                <?php if(isset($_SESSION['auth'])): ?>
                                <form class="mb-4" id="commentForm" autocomplete="off">
                                    <label for="commentInput" class="form-label" style="color: var(--texto-secundario);">Deixe seu comentário</label>
                                    <textarea class="form-control mb-2" id="commentInput" rows="3" maxlength="600" placeholder="Compartilhe sua opinião com respeito..." required></textarea>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small style="color: var(--texto-secundario);"><span id="charCount">0</span>/600 caracteres</small>
                                        <button type="submit" class="btn btn-verde"><i class="bi bi-send me-1"></i> Publicar</button>
                                    </div>
                                </form>
                                <?php else: ?>
                                <div class="info-box mb-4">
                                    <p><i class="bi bi-info-circle me-2"></i> <a href="login.php" style="color: var(--verde-destaque);">Faça login</a> para deixar um comentário.</p>
                                </div>
                                <?php endif; ?>

                                <div id="commentList">
                                    <div class="comment">
                                        <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=100&h=100&fit=crop&crop=face" class="avatar" alt="Ana M.">
                                        <div class="flex-grow-1">
                                            <div class="meta"><span class="author">Nome de quem comentou</span></div>
                                            <div class="meta"><span>há quantia de dias que comentou</span></div>
                                            <div class="body">Comentário</div>
                                            <div class="reply-actions">
                                                <button type="button"><i class="bi bi-heart"></i> curtidas</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </main>

                <footer>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <h5 style="color: var(--verde-destaque);">
                                    <i class="bi bi-flower1 me-2"></i>BioAlumnus
                                </h5>
                                <p>Sua enciclopédia colaborativa de Biologia.</p>
                            </div>
                        </div>
                        <hr style="border-color: var(--borda-sutil);">
                        <div class="text-center">
                            <p>&copy; 2026 BioAlumnus. Todos os direitos reservados.</p>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <!-- Barra flutuante de Leitura Acessível -->
    <aside class="reading-toolbar" role="toolbar" aria-label="Ferramentas de leitura acessível">
        <button type="button" class="tool-btn" id="focusModeBtn" title="Modo leitura (esconde topo e barra lateral)" aria-pressed="false">
            <i class="bi bi-eye"></i>
        </button>
        <button type="button" class="tool-btn" id="paragraphFocusBtn" title="Foco por parágrafo" aria-pressed="false">
            <i class="bi bi-bullseye"></i>
        </button>
        <div class="divider" aria-hidden="true"></div>
        <button type="button" class="tool-btn" id="fontIncBtn" title="Aumentar fonte">
            <i class="bi bi-type" style="font-size:1.3rem;"></i><sup>+</sup>
        </button>
        <button type="button" class="tool-btn" id="fontDecBtn" title="Diminuir fonte">
            <i class="bi bi-type" style="font-size:.9rem;"></i><sup>−</sup>
        </button>
        <button type="button" class="tool-btn" id="spacingBtn" title="Aumentar espaçamento entre linhas" aria-pressed="false">
            <i class="bi bi-distribute-vertical"></i>
        </button>
        <button type="button" class="tool-btn" id="legibleBtn" title="Fonte mais legível" aria-pressed="false">
            <i class="bi bi-fonts"></i>
        </button>
        <div class="divider" aria-hidden="true"></div>
        <button type="button" class="tool-btn" id="resetBtn" title="Restaurar padrões de leitura">
            <i class="bi bi-arrow-counterclockwise"></i>
        </button>
    </aside>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    (function () {
        const STORAGE_KEY = 'bioalumnus.readingPrefs.v1';
        const body = document.body;
        const articleBody = document.getElementById('articleBody');
        const progressBar = document.getElementById('readingProgress');

        // ----- Persistência de preferências -----
        const defaults = { fs: 1.05, lh: 1.85, ls: 0.01, legible: false, paragraphFocus: false, focusMode: false, spacing: false };
        let prefs = { ...defaults, ...(JSON.parse(localStorage.getItem(STORAGE_KEY) || '{}')) };

        function apply() {
            articleBody.style.setProperty('--article-fs', prefs.fs + 'rem');
            articleBody.style.setProperty('--article-lh', prefs.lh);
            articleBody.classList.toggle('legible-font', !!prefs.legible);
            articleBody.classList.toggle('focus-paragraph', !!prefs.paragraphFocus);
            body.classList.toggle('focus-mode', !!prefs.focusMode);

            document.getElementById('legibleBtn').classList.toggle('active', !!prefs.legible);
            document.getElementById('legibleBtn').setAttribute('aria-pressed', !!prefs.legible);
            document.getElementById('paragraphFocusBtn').classList.toggle('active', !!prefs.paragraphFocus);
            document.getElementById('paragraphFocusBtn').setAttribute('aria-pressed', !!prefs.paragraphFocus);
            document.getElementById('focusModeBtn').classList.toggle('active', !!prefs.focusMode);
            document.getElementById('focusModeBtn').setAttribute('aria-pressed', !!prefs.focusMode);
            document.getElementById('spacingBtn').classList.toggle('active', !!prefs.spacing);
        }
        function save() { localStorage.setItem(STORAGE_KEY, JSON.stringify(prefs)); }

        // ----- Bindings dos botões -----
        document.getElementById('focusModeBtn').addEventListener('click', () => {
            prefs.focusMode = !prefs.focusMode; apply(); save();
        });
        document.getElementById('exitFocusBtn').addEventListener('click', () => {
            prefs.focusMode = false; apply(); save();
        });
        document.getElementById('paragraphFocusBtn').addEventListener('click', () => {
            prefs.paragraphFocus = !prefs.paragraphFocus; apply(); save();
        });
        document.getElementById('fontIncBtn').addEventListener('click', () => {
            prefs.fs = Math.min(1.5, +(prefs.fs + 0.05).toFixed(2)); apply(); save();
        });
        document.getElementById('fontDecBtn').addEventListener('click', () => {
            prefs.fs = Math.max(0.9, +(prefs.fs - 0.05).toFixed(2)); apply(); save();
        });
        document.getElementById('spacingBtn').addEventListener('click', () => {
            prefs.spacing = !prefs.spacing;
            prefs.lh = prefs.spacing ? 2.2 : 1.85;
            apply(); save();
        });
        document.getElementById('legibleBtn').addEventListener('click', () => {
            prefs.legible = !prefs.legible; apply(); save();
        });
        document.getElementById('resetBtn').addEventListener('click', () => {
            prefs = { ...defaults }; apply(); save();
        });

        // ESC sai do modo foco
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && prefs.focusMode) { prefs.focusMode = false; apply(); save(); }
        });

        apply();

        // ----- Barra de progresso de leitura -----
        function updateProgress() {
            const rect = articleBody.getBoundingClientRect();
            const total = articleBody.offsetHeight - window.innerHeight;
            const scrolled = Math.min(Math.max(-rect.top, 0), Math.max(total, 1));
            const pct = total > 0 ? (scrolled / total) * 100 : 0;
            progressBar.style.width = Math.min(100, pct) + '%';
        }
        document.addEventListener('scroll', updateProgress, { passive: true });
        window.addEventListener('resize', updateProgress);
        updateProgress();

        // ----- TOC: destaque da seção ativa -----
        const tocLinks = document.querySelectorAll('#tocNav a');
        const targets = Array.from(tocLinks).map(a => document.querySelector(a.getAttribute('href'))).filter(Boolean);
        const io = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    tocLinks.forEach(l => l.classList.toggle('active', l.getAttribute('href') === '#' + entry.target.id));
                }
            });
        }, { rootMargin: '-30% 0px -60% 0px' });
        targets.forEach(t => io.observe(t));

        // ----- Curtir / Salvar -----
        const likeBtn = document.getElementById('likeBtn');
        const likeCount = document.getElementById('likeCount');
        likeBtn.addEventListener('click', () => {
            const active = likeBtn.classList.toggle('active');
            likeBtn.setAttribute('aria-pressed', active);
            likeCount.textContent = parseInt(likeCount.textContent, 10) + (active ? 1 : -1);
        });
        const bookmarkBtn = document.getElementById('bookmarkBtn');
        bookmarkBtn.addEventListener('click', () => {
            const active = bookmarkBtn.classList.toggle('active');
            bookmarkBtn.setAttribute('aria-pressed', active);
        });
        document.getElementById('shareBtn').addEventListener('click', async () => {
            const url = window.location.href;
            if (navigator.share) {
                try { await navigator.share({ title: document.title, url }); } catch (_) {}
            } else {
                try { await navigator.clipboard.writeText(url); alert('Link copiado!'); } catch (_) {}
            }
        });

        // ----- Comentário (frontend demo) -----
        const form = document.getElementById('commentForm');
        if (form) {
            const input = document.getElementById('commentInput');
            const charCount = document.getElementById('charCount');
            input.addEventListener('input', () => charCount.textContent = input.value.length);
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                const text = input.value.trim();
                if (!text) return;
                const list = document.getElementById('commentList');
                const el = document.createElement('div');
                el.className = 'comment';
                el.innerHTML = `
                    <img src="<?php echo $user_photo; ?>" class="avatar" alt="Você">
                    <div class="flex-grow-1">
                        <div class="meta"><span class="author"><?php echo htmlspecialchars($user_name); ?></span> · <span>agora</span></div>
                        <div class="body"></div>
                        <div class="reply-actions">
                            <button type="button"><i class="bi bi-heart"></i> curtidas</button>
                        </div>
                    </div>`;
                el.querySelector('.body').textContent = text;
                list.prepend(el);
                input.value = ''; charCount.textContent = '0';
                const c = document.getElementById('commentCount');
                const ct = document.getElementById('commentCountTop');
                c.textContent = parseInt(c.textContent, 10) + 1;
                ct.textContent = parseInt(ct.textContent, 10) + 1;
            });
        }
    })();
    </script>
</body>
</html>
