<?php

if(isset($_SESSION['id'])){

} else{
    $user_photo = "frontend/assets/icons/incognito.svg";
    $user_name = "Anônimo";
    $user_profile = "@anonimo";
}


?>

<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioAlumnus - Enciclopédia de Biologia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="frontend/styles/index.css">
    <link rel="icon" href="frontend/assets/icons/icon.png">
</head>
<body>
    <!-- HEADER -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="index.html">
                <i class="bi bi-flower1"></i>
                BioAlumnus
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.html">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Sobre</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="lupa.html">Lupa</a>
                    </li>
                </ul>
                <form class="d-flex" role="search" method="GET" action="artigos.php">
                    <div class="input-group">
                        
                        <input name="search" class="form-control" type="search" placeholder="Buscar na wiki..." aria-label="Buscar">
                        <button class="btn btn-verde" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
                
                <div class="dropdown ms-3">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?php echo $user_photo; ?>" alt="Usuário" class="rounded-circle me-2" style="width: 38px; height: 38px; color: white; object-fit: cover; border: 2px solid var(--verde-mato);">
                        <span class="d-none d-lg-inline" style="color: var(--texto-principal);"><?php echo $user_name; ?></span>
                    </a>
                    <?php if(isset($_SESSION['id'])): ?>
                        <ul class="dropdown-menu dropdown-menu-end" style="background-color: var(--fundo-card); border: 1px solid var(--borda-sutil);">
                            <li><a class="dropdown-item" href="#" style="color: var(--texto-principal);"><i class="bi bi-person me-2"></i>Meu Perfil</a></li>
                            <li><a class="dropdown-item" href="#" style="color: var(--texto-principal);"><i class="bi bi-gear me-2"></i>Configurações</a></li>
                            <li><hr class="dropdown-divider" style="border-color: var(--borda-sutil);"></li>
                            <li><a class="dropdown-item" href="#" style="color: #dc3545;"><i class="bi bi-box-arrow-right me-2"></i>Sair</a></li>
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
    <!-- SIDEBAR MOBILE -->
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
                        <?php if(isset($_SESSION['id'])): ?>
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
                <li><a href="artigos.html?theme=ecologia"><i class="bi bi-tree"></i>Ecologia</a></li>
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
            <!-- SIDEBAR DESKTOP -->
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
            <!-- MAIN -->
            <div class="col-lg-9 col-xl-10">
                <main class="main-content" id="inicio">
                    <section class="hero-section">
                        <div class="row align-items-center">
                            <div class="col-lg-6 mb-4 mb-lg-0">
                                <h1>Bem-vindo ao <span>BioAlumnus</span></h1>
                                <p>Sua enciclopédia colaborativa de Biologia. Explore o fascinante mundo da vida através de artigos científicos detalhados, ilustrações e recursos educacionais.</p>
                                <div class="mt-4">
                                    <a href="artigos.php" class="btn btn-verde btn-md me-2">
                                        <i class="bi bi-book me-2"></i>Explorar Artigos
                                    </a>
                                    <a href="#sobre" class="btn btn-outline-verde btn-md">
                                        <i class="bi bi-info-circle me-2"></i>Saiba Mais
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-indicators">
                                        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                    </div>
                                    <div class="carousel-inner rounded-4 overflow-hidden" style="border: 3px solid var(--verde-mato);">
                                        <div class="carousel-item active">
                                            <a href="#artigo-1-destaque">
                                                <img src="frontend/assets/img/cadeia-alimentar.png" class="d-block w-100" alt="Cadeia Alimentar" style="height: 280px; object-fit: cover;">
                                            </a>
                                                <div class="carousel-caption" style="background: linear-gradient(transparent, rgba(13, 13, 13, 0.9)); bottom: 0; left: 0; right: 0; padding: 2rem 1rem 1rem;">
                                                    <h5 style="color: var(--verde-destaque-2);">Cadeia Alimentar</h5>
                                                </div>
                                            
                                        </div>
                                        <div class="carousel-item">
                                            <a href="#artigo-2-destaque">
                                                <img src="frontend/assets/img/teia-alimentar.png" class="d-block w-100" alt="Teia Alimentar" style="height: 280px; object-fit: cover;">
                                                <div class="carousel-caption" style="background: linear-gradient(transparent, rgba(13, 13, 13, 0.9)); bottom: 0; left: 0; right: 0; padding: 2rem 1rem 1rem;">
                                                    <h5 style="color: var(--verde-destaque-2);">Teia Alimentar</h5>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true" style="filter: drop-shadow(0 0 3px rgba(0,0,0,0.8));"></span>
                                        <span class="visually-hidden">Anterior</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true" style="filter: drop-shadow(0 0 3px rgba(0,0,0,0.8));"></span>
                                        <span class="visually-hidden">Próximo</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section id="artigos" class="mb-5">
                        <h2 class="section-title">
                            <i class="bi bi-star-fill"></i>
                            Artigos em Destaque
                        </h2>
                        <div class="row g-4">
                            <div class="col-md-6 col-xl-4">
                                <div class="bio-card">
                                    <img src="frontend/assets/img/welcome.png" class="card-img-top" alt="Fotossíntese">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=50&h=50&fit=crop&crop=face" alt="Prof. Carlos Silva" class="rounded-circle me-2" style="width: 36px; height: 36px; object-fit: cover; border: 2px solid var(--verde-mato);">
                                            <span style="color: var(--texto-secundario); font-size: 0.9rem;">Alu. Fabricio Henrique</span>
                                        </div>
                                        <div class="mb-2">
                                            <span class="badge">Boas-vindas</span>
                                        </div>
                                        <h5 class="card-title">Seja bem-vindo ao BioAlumnus!</h5>
                                        <p class="card-text">Este artigo se trata de um bem-vindo aos alunos e professores sobre a plataforma de estudos.</p>
                                    </div>
                                    <div class="card-footer d-flex justify-content-between align-items-center">
                                        <small class="text-muted"><i class="bi bi-calendar me-1"></i>12 Mai. 2026</small>
                                        <a href="artigo.html" class="btn btn-sm btn-outline-verde">Ler mais</a>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </section>

                    <section id="sobre" class="mb-5">
                        <h2 class="section-title">
                            <i class="bi bi-info-circle"></i>
                            Sobre o BioAlumnus
                        </h2>
                        <div class="content-article">
                            <div class="row align-items-center">
                                <div class="col-lg-8">
                                    <p>O BioAlumnus é uma enciclopédia colaborativa dedicada ao estudo da Biologia. Nosso objetivo é disponibilizar conteúdo científico de qualidade, acessível a estudantes, professores e entusiastas da ciência.</p>
                                    <p>Todo o conteúdo composto deste site é avaliado e publicado por professores e orientadores da área, visando uma confiabilidade e maior veracidade das informações compostas.</p>
                                    <h3>Nossa Missão</h3>
                                    <p>Democratizar o acesso ao conhecimento biológico, fornecendo recursos educacionais gratuitos e de alta qualidade para todos que desejam aprender sobre a vida e seus processos.</p>
                                </div>
                                <div class="col-lg-4 text-center">
                                    <div class="stats-card">
                                        <i class="bi bi-award"></i>
                                        <h3>2026</h3>
                                        <p class="foundation-bioalumnus">Fundação do BioAlumnus</p>
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
