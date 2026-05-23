<?php

session_start();

if(isset($_SESSION['auth'])){
    $user_name = $_SESSION['username'];
    $user_profile = $_SESSION['user'];
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
    <title>BioAlumnus - Nome do artigo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="frontend/styles/index.css">
    <link rel="icon" href="frontend/assets/icons/icon.png">
</head>
<body>
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
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Sobre</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="lupa.html">Lupa</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <div class="input-group">
                        
                        <input class="form-control" type="search" placeholder="Buscar na wiki..." aria-label="Buscar">
                        <button class="btn btn-verde" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
                
                <div class="dropdown ms-3">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?php echo $user_photo; ?>" alt="Usuário" class="rounded-circle me-2" style="width: 38px; height: 38px; color: white; object-fit: cover; border: 2px solid var(--verde-mato);">
                        <span class="d-none d-lg-inline" style="color: var(--texto-principal);"><?php echo $user_profile; ?></span>
                    </a>
                    <?php if(isset($_SESSION['auth'])): ?>
                        <ul class="dropdown-menu dropdown-menu-end" style="background-color: var(--fundo-card); border: 1px solid var(--borda-sutil);">
                            <li><a class="dropdown-item" href="profile.php" style="color: var(--texto-principal);"><i class="bi bi-person me-2"></i>Meu Perfil</a></li>
                            <li><a class="dropdown-item" href="#" style="color: var(--texto-principal);"><i class="bi bi-gear me-2"></i>Configurações</a></li>
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
            <h5 class="offcanvas-title">
                <i class="bi bi-flower1 me-2"></i>
                BioAlumnus
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body p-0">
            <div class="p-3">
                <div class="d-flex align-items-center mb-3 p-2 rounded" style="background-color: rgba(45, 90, 39, 0.15); border: 1px solid var(--borda-sutil);">
                    <img src="<?php echo $user_photo; ?>" alt="Usuário" class="rounded-circle me-2" style="width: 42px; height: 42px; object-fit: cover; border: 2px solid var(--verde-mato);">
                    <div>
                        <?php if(isset($_SESSION['auth'])): ?>
                            <span class="d-block fw-semibold" style="color: var(--texto-principal);"><?php echo $user_name; ?></span>
                            <small style="color: var(--texto-secundario);"><?php echo $user_profile; ?></small>
                        <?php else: ?>
                            <a href="login.php"><span class="d-block fw-semibold" style="color: var(--texto-principal);">Fazer login</span></a>
                        <?php endif; ?>
                    </div>
                </div>
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

    <div class="container-fluid" style="margin-top: 76px;">
        <div class="row">
            <div class="col-lg-3 col-xl-2 d-none d-lg-block p-0">
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
                    <!--
                    <p class="sidebar-title mt-4">Tags Populares</p>
                    <div class="px-3">
                        <div class="tag-cloud">
                            
                                <span class="badge">DNA</span>
                                <span class="badge">RNA</span>
                                <span class="badge">Célula</span>
                                <span class="badge">Mitose</span>
                                <span class="badge">Meiose</span>
                                <span class="badge">ATP</span>
                                <span class="badge">Enzimas</span>
                            
                        </div>
                    </div>
                    -->
                </div>
            </div>

            <div class="col-lg-9 col-xl-10">
                <main class="main-content" id="inicio">
                    <section id="artigos" class="mb-5">
                        <div class="row g-4">
                            <div class="col-md-12 col-xl-12">
                                <div class="card artigo-card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=50&h=50&fit=crop&crop=face" alt="Prof. Carlos Silva" class="rounded-circle me-2" style="width: 36px; height: 36px; object-fit: cover; border: 2px solid var(--verde-mato);">
                                            <span style="color: var(--texto-secundario); font-size: 0.9rem;"><i>Alu.</i> Fabricio Henrique</span>
                                        </div>
                                        
                                        <div class="mb-2">
                                            <span class="badge">Boas-vindas</span>
                                        </div>
                                        <h5 class="card-title">Seja bem-vindo ao BioAlumnus!</h5>
                                        <p style="text-align: justify;" class="card-text">Olá! Boas vindas ao <b><span style="color: var(--verde-destaque);">BioAlumnus</span> aluno ou docente.</b></p>
                                        <p style="text-align: justify; line-height: 2;" class="card-text">Vejo que deve estar se perguntando: para o que é essa plataforma? O que de fato há de conter nessa nova área da tecnologia? O que é tudo isso? Pois bem, <b>não precisa temer!</b> Vamos todos por partes para entender como que funciona de fato todo o esquema por aqui, cada tópico e cada área para navegar sem dificuldade. Vamos lá?</p>
                                        <h4 style="color: var(--verde-destaque);"><b>O que é o BioAlumnus?</b></h4>
                                        <p style="text-align: justify; line-height: 2;" class="card-text">Produzido inicialmente como um projeto escolar, o BioAlumnus <i>(Vida + Aluno em latim)</i> veio como uma proposta nova e interativa para o ensino na questão das ciências da vida com a tecnologia, trazendo uma ideia incentivadora para os jovens estudarem e absorverem, de forma memorável, conteúdos de biologia que são ensinados em âmbito escolar e contexto disciplinar, aprimorando e aprofundando seu conhecimento com base de orientadores e professores verificados que trazem informações verificadas para um ambiente mais seguro e com dados confiáveis.</p>
                                    </div>
                                    <div class="card-footer d-flex justify-content-between align-items-center">
                                        <small class="text-muted"><i class="bi bi-calendar me-1"></i>12 Mai 2024</small>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </section>

                    <section id="sobre" class="mb-5">
                        <h2 class="section-title">
                            <i class="bi bi-info-circle"></i>
                            Sobre este usuário
                        </h2>
                        <div class="content-article">
                            <div class="row align-items-center">
                                <div class="col-lg-8">
                                    <p>O BioAlumnus é uma enciclopédia colaborativa dedicada ao estudo da Biologia. Nosso objetivo é disponibilizar conteúdo científico de qualidade, acessível a estudantes, professores e entusiastas da ciência.</p>
                                    <p>Todo o conteúdo composto deste site é avaliado e publicado por professores e orientadores da área, visando uma confiabilidade e maior veracidade das informações compostas.</p>
                                    <h3>Nossa Missão</h3>
                                    <p>Democratizar o acesso ao conhecimento biológico, fornecendo recursos educacionais gratuitos e de alta qualidade para todos que desejam aprender sobre a vida e seus processos.</p>
                                </div>
                                <div class="col-lg-4">
                                    <div class="stats-card">
                                        <i class="bi bi-award"></i>
                                        <h3>2026</h3>
                                        <p align="center">Fundação do BioAlumnus</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
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
                            <!--
                            <div class="col-md-3 mb-3 mb-md-0">
                                <h6 style="color: var(--texto-principal);">Links Úteis</h6>
                                <ul class="list-unstyled">
                                    <li><a href="#">Política de Privacidade</a></li>
                                    <li><a href="#">Termos de Uso</a></li>
                                    <li><a href="#">Contribuir</a></li>
                                </ul>
                            </div>
                            <div class="col-md-3">
                                <h6 style="color: var(--texto-principal);">Contato</h6>
                                <ul class="list-unstyled">
                                    <li><a href="#"><i class="bi bi-envelope me-2"></i>contato@biowiki.com</a></li>
                                    <li><a href="#"><i class="bi bi-github me-2"></i>GitHub</a></li>
                                </ul>
                            </div>
                            -->
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
