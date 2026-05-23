<?php

require_once "backend/src/db_queries.php";

session_start();

if(!isset($_GET['user']) || empty($_GET['user'])){
    header("Location: index.php");
    exit;
}

$user_id = 0;

$user_name = $_SESSION['username'];
$user_profile = $_SESSION['user'];
$user_photo = $_SESSION['photo'];
$user_name_url = $_GET['user'];

$query = $conn->prepare(
    "SELECT
        users.id,
        users.username,
        users.userprofile,
        users.email,
        GROUP_CONCAT(tel.phone SEPARATOR ', '),
        users.biografia,
        users.icon,
        users.cargo
    FROM tbl_usuarios users
    LEFT JOIN tbl_telefone tel
    ON users.id = tel.userprofile
    WHERE users.userprofile = ?
    GROUP BY 
        users.id,
        users.username,
        users.userprofile,
        users.email,
        users.icon,
        users.cargo"
);
$query->bind_param("s", $user_name_url);
$query->execute();

$result = $query->get_result();

$row = $result->fetch_assoc();

$user_tel_profile = "indefinido";

if($result->num_rows > 0){
    $user_id = $row['id'];
    $user_name_profile = $row['username'];
    $user_tag_profile = $row['userprofile'];
    $user_email_profile = $row['email'];
    $user_bio = $row['biografia'];
    $user_photo_profile = $row['icon'];
    $cargo = $row['cargo'];
}

$query->close();

if(!isset($_SESSION['auth'])){
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioAlumnus - Perfil de Usuário</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="frontend/styles/profile.css?v=2">
    <link rel="icon" href="frontend/assets/icons/icon.png">
</head>
<body>

    <!-- ===================== NAVBAR ===================== -->
    <nav class="navbar navbar-expand-lg fixed-top" aria-label="Navegação principal">
        <div class="container-fluid px-4">

            <!-- Brand -->
            <a class="navbar-brand" href="index.php" aria-label="BioAlumnus — Página inicial">
                <i class="bi bi-flower1" aria-hidden="true"></i>
                BioAlumnus
            </a>

            <!-- Toggler mobile → offcanvas sidebar -->
            <button
                class="navbar-toggler border-0"
                type="button"
                data-bs-toggle="offcanvas"
                data-bs-target="#mobileSidebar"
                aria-controls="mobileSidebar"
                aria-label="Abrir menu de navegação"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Links desktop -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Sobre</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="artigos.php">Artigos</a>
                    </li>
                </ul>

                <!-- Barra de busca -->
                <form class="d-flex" role="search" method="GET" action="artigos.php">
                    <div class="input-group">
                        <input
                            name="search"
                            class="form-control"
                            type="search"
                            placeholder="Buscar na wiki..."
                            aria-label="Buscar artigos"
                        >
                        <button class="btn btn-verde" type="submit" aria-label="Executar busca">
                            <i class="bi bi-search" aria-hidden="true"></i>
                        </button>
                    </div>
                </form>

                <!-- Dropdown do usuário -->
                <div class="dropdown ms-3">
                    <a
                        href="#"
                        class="d-flex align-items-center text-decoration-none dropdown-toggle"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                        aria-label="Menu do usuário"
                    >
                        <img
                            src="<?php echo $user_photo; ?>"
                            alt="Foto de perfil do usuário"
                            class="profile-avatar-nav rounded-circle me-2"
                        >
                        <span class="d-none d-lg-inline nav-username"><?php echo $user_profile; ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end custom-dropdown">
                        <li>
                            <a class="dropdown-item" href="profile.php?user=<?php echo $user_profile; ?>" aria-current="page">
                                <i class="bi bi-person me-2" aria-hidden="true"></i>Meu Perfil
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bi bi-gear me-2" aria-hidden="true"></i>Configurações
                            </a>
                        </li>
                        <li><hr class="dropdown-divider custom-divider" role="separator"></li>
                        <li>
                            <a class="dropdown-item item-danger" href="backend/src/quit.php">
                                <i class="bi bi-box-arrow-right me-2" aria-hidden="true"></i>Sair
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- ===================== SIDEBAR MOBILE (OFFCANVAS) ===================== -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="mobileSidebarLabel">
                <i class="bi bi-flower1 me-2" aria-hidden="true"></i>BioAlumnus
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fechar menu"></button>
        </div>
        <div class="offcanvas-body p-0">
            <div class="p-3">
                <!-- Usuário no mobile -->
                <a href="profile.php?user=<?php echo $user_profile; ?>">
                    <div class="d-flex align-items-center mb-3 p-2 rounded offcanvas-user-card">
                        <img
                            src="<?php echo $user_photo; ?>"
                            alt="Foto de perfil"
                            class="rounded-circle me-2 offcanvas-avatar"
                        >
                        <div>
                            <span class="d-block fw-semibold text-principal"><?php echo $user_name; ?></span>
                            <small class="text-secundario"><?php echo $user_profile; ?></small>
                        </div>
                    </div>
                </a>
                <input class="form-control mb-3" type="search" placeholder="Buscar na wiki..." aria-label="Buscar">
            </div>

            <p class="sidebar-title">Categorias</p>
            <ul class="sidebar-nav" role="list">
                <li role="listitem"><a href="artigos.php?theme=ecologia"><i class="bi bi-tree" aria-hidden="true"></i>Ecologia</a></li>
            </ul>

            <p class="sidebar-title mt-4">Recursos</p>
            <ul class="sidebar-nav" role="list">
                <li role="listitem"><a href="#"><i class="bi bi-journal-text" aria-hidden="true"></i>Artigos Recentes</a></li>
                <li role="listitem"><a href="#"><i class="bi bi-bookmark" aria-hidden="true"></i>Salvos</a></li>
                <li role="listitem"><a href="#"><i class="bi bi-clock-history" aria-hidden="true"></i>Histórico</a></li>
            </ul>
        </div>
    </div>

    <!-- ===================== LAYOUT PRINCIPAL ===================== -->
    <div class="container-fluid layout-wrapper">
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

            <!-- CONTEÚDO PRINCIPAL -->
            <main class="col-lg-9 col-xl-10 main-content" id="main-content" aria-label="Conteúdo principal">

                <!-- ===== HERO DO PERFIL ===== -->
                <section class="profile-hero" aria-label="Cabeçalho do perfil">
                    <!-- Faixa de capa / banner -->
                    <div class="profile-cover" aria-hidden="true"></div>

                    <div class="profile-hero-body">
                        <!-- Avatar + info -->
                        <?php if(contar("tbl_usuarios", "id", $user_id) > 0): ?>
                            <div class="d-flex flex-column flex-sm-row align-items-center align-items-sm-end gap-3 mb-3">
                                <div class="profile-avatar-wrapper">
                                    <img
                                        src="<?php echo $user_photo_profile; ?>"
                                        alt="Foto de perfil de <?php echo strtok($user_name, " "); ?>"
                                        class="profile-avatar"
                                        id="preview-avatar-display"
                                    >
                                    <span class="profile-status-badge" aria-label="Usuário online" title="Online"></span>
                                </div>
                                <div class="profile-info flex-grow-1">
                                    <h1 class="profile-name"><?php echo $user_name_profile; ?></h1>
                                    <p class="profile-username">@<?php echo $user_tag_profile; ?></p>
                                </div>
                                <div class="ms-sm-auto">
                                    <span class="profile-role-badge">
                                        <?php

                                        switch($cargo){
                                            case 1:
                                                echo '
                                                <i class="bi bi-book-half me-2"></i>
                                                Aluno';
                                                break;
                                            case 2:
                                                echo '
                                                <i class="bi bi-mortarboard-fill me-2"></i>
                                                Professor';
                                                break;
                                            case 3:
                                                echo '
                                                <i class="bi bi-shield-fill me-2"></i>
                                                Administrador';
                                                break;
                                            default:
                                                echo '
                                                <i class="bi bi-exclamation-octagon-fill me-2"></i>
                                                Indefinido';
                                        }

                                        ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- ===== NAVEGAÇÃO POR ABAS ===== -->
                    <nav aria-label="Seções do perfil">
                        <ul class="nav profile-tabs mb-4" id="profileTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button
                                    class="profile-tab-btn active"
                                    id="tab-perfil-btn"
                                    data-bs-toggle="tab"
                                    data-bs-target="#tab-perfil"
                                    type="button"
                                    role="tab"
                                    aria-controls="tab-perfil"
                                    aria-selected="true"
                                >
                                    <i class="bi bi-person-lines-fill me-2" aria-hidden="true"></i>Perfil Geral
                                </button>
                            </li>
                            <?php if($_SESSION['id'] == $user_id): ?>
                            <li class="nav-item" role="presentation">
                                <button
                                    class="profile-tab-btn"
                                    id="tab-conta-btn"
                                    data-bs-toggle="tab"
                                    data-bs-target="#tab-conta"
                                    type="button"
                                    role="tab"
                                    aria-controls="tab-conta"
                                    aria-selected="false"
                                >
                                    <i class="bi bi-gear-fill me-2" aria-hidden="true"></i>Alterar Informações
                                </button>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </nav>

                    <!-- ===== CONTEÚDO DAS ABAS ===== -->
                    <div class="tab-content" id="profileTabsContent">

                        <!-- ========================== ABA 1: PERFIL GERAL ========================== -->
                        <div
                            class="tab-pane fade show active"
                            id="tab-perfil"
                            role="tabpanel"
                            aria-labelledby="tab-perfil-btn"
                            tabindex="0"
                        >
                            <div class="row g-4">

                                <!-- COLUNA PRINCIPAL (esquerda no desktop) -->
                                <div class="col-12 col-xl-8">

                                    <!-- Seção: Sobre -->
                                    <section class="profile-section" aria-labelledby="about-title">
                                        <h2 class="section-title" id="about-title">
                                            <i class="bi bi-person-badge" aria-hidden="true"></i>
                                            Sobre
                                        </h2>
                                        <div class="content-article">
                                            <p>
                                                <?php echo $user_bio; ?>
                                            </p>
                                            <div class="info-box" role="note">
                                                <p><i class="bi bi-info-circle me-2" aria-hidden="true"></i>
                                                    Este perfil é público. Qualquer visitante pode ver seus artigos e estatísticas.
                                                </p>
                                            </div>
                                        </div>
                                    </section>

                                    <!-- Seção: Atividade Recente -->
                                    <section class="profile-section" aria-labelledby="activity-title">
                                        <h2 class="section-title" id="activity-title">
                                            <i class="bi bi-clock-history" aria-hidden="true"></i>
                                            Atividade Recente
                                        </h2>
                                        <div class="content-article p-0 overflow-hidden">
                                            <ol class="activity-timeline list-unstyled mb-0" aria-label="Últimas atividades">
                                                <li class="activity-item activity-item--last">
                                                    <span class="activity-icon bg-success-subtle" aria-hidden="true">
                                                        <i class="bi bi-file-earmark-plus text-success"></i>
                                                    </span>
                                                    <div class="activity-body">
                                                        <p class="activity-text">Não possui atividade recente...</p>
                                                        <time class="activity-time" datetime="2026-05-01">há ? dias</time>
                                                    </div>
                                                </li>
                                            </ol>
                                        </div>
                                    </section>
                                </div>

                                <!-- COLUNA LATERAL (direita no desktop) -->
                                <div class="col-12 col-xl-4">

                                    <!-- Estatísticas -->
                                    <section class="profile-section" aria-labelledby="stats-title">
                                        <h2 class="section-title" id="stats-title">
                                            <i class="bi bi-bar-chart-line" aria-hidden="true"></i>
                                            Estatísticas
                                        </h2>
                                        <div class="row g-3" role="list" aria-label="Métricas do perfil">
                                            <div class="col-6" role="listitem">
                                                <article class="stats-card" aria-label="Artigos publicados">
                                                    <i class="bi bi-file-earmark-text" aria-hidden="true"></i>
                                                    <h3 aria-label="24 artigos">24</h3>
                                                    <p>Artigos</p>
                                                </article>
                                            </div>
                                            <div class="col-6" role="listitem">
                                                <article class="stats-card" aria-label="Visualizações totais">
                                                    <i class="bi bi-eye" aria-hidden="true"></i>
                                                    <h3 aria-label="3.412 visualizações">3.4k</h3>
                                                    <p>Visualizações</p>
                                                </article>
                                            </div>
                                            <div class="col-6" role="listitem">
                                                <article class="stats-card" aria-label="Edições realizadas">
                                                    <i class="bi bi-pencil-square" aria-hidden="true"></i>
                                                    <h3 aria-label="87 edições">87</h3>
                                                    <p>Edições</p>
                                                </article>
                                            </div>
                                            <div class="col-6" role="listitem">
                                                <article class="stats-card" aria-label="Avaliação média">
                                                    <i class="bi bi-star-half" aria-hidden="true"></i>
                                                    <h3 aria-label="4.8 estrelas">4.8</h3>
                                                    <p>Avaliação</p>
                                                </article>
                                            </div>
                                        </div>
                                    </section>

                                    <!-- Informações de Contato -->
                                    <section class="profile-section" aria-labelledby="contact-title">
                                        <h2 class="section-title" id="contact-title">
                                            <i class="bi bi-envelope" aria-hidden="true"></i>
                                            Contato
                                        </h2>
                                        <div class="content-article py-0">
                                            <ul class="contact-list list-unstyled mb-0" aria-label="Informações de contato">
                                                <li class="contact-item">
                                                    <i class="bi bi-envelope-fill contact-icon" aria-hidden="true"></i>
                                                    <div>
                                                        <small class="contact-label">E-mail</small>
                                                        <a href="mailto:<?php echo $user_email_profile; ?>" class="contact-value d-block"><?php echo $user_email_profile; ?></a>
                                                    </div>
                                                </li>
                                                <li class="contact-item">
                                                    <i class="bi bi-telephone-fill contact-icon" aria-hidden="true"></i>
                                                    <div>
                                                        <small class="contact-label">Telefone</small>
                                                        <a href="#" class="contact-value d-block">
                                                            <?php 
                                                                if(empty($user_tel_profile))
                                                                    echo "Não possui número...";
                                                                else
                                                                    echo $user_tel_profile;
                                                            ?>
                                                        </a>
                                                    </div>
                                                </li>
                                                <li class="contact-item">
                                                    <i class="bi bi-geo-alt-fill contact-icon" aria-hidden="true"></i>
                                                    <div>
                                                        <small class="contact-label">Localização</small>
                                                        <span class="contact-value d-block">São Paulo, SP — Brasil</span>
                                                    </div>
                                                </li>
                                                <li class="contact-item contact-item--last">
                                                    <i class="bi bi-link-45deg contact-icon" aria-hidden="true"></i>
                                                    <div>
                                                        <small class="contact-label">Website</small>
                                                        <a href="#" class="contact-value d-block" target="_blank" rel="noopener noreferrer"></a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </section>

                                    <!-- Tags de interesse -->
                                    <section class="profile-section" aria-labelledby="tags-title">
                                        <h2 class="section-title" id="tags-title">
                                            <i class="bi bi-tags" aria-hidden="true"></i>
                                            Interesses
                                        </h2>
                                        <div class="tag-cloud" role="list" aria-label="Áreas de interesse">
                                            <?php if(contar("tbl_usuarios_has_tbl_interesses", "tbl_usuarios_id", $user_id) < 1): ?>
                                                <span class="badge" role="listitem">Não há interesses...</span>
                                            <?php else: ?>
                                                <span class="badge" role="listitem">Taxonomia</span>
                                            <?php endif; ?>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                        <!-- /ABA 1 -->

                        <?php if($_SESSION['id'] == $user_id): ?>
                        <!-- ========================== ABA 2: ALTERAR INFORMAÇÕES ========================== -->
                        <div
                            class="tab-pane fade"
                            id="tab-conta"
                            role="tabpanel"
                            aria-labelledby="tab-conta-btn"
                            tabindex="0"
                        >
                            <div class="row g-4">
                                <div class="col-12 col-xl-8">

                                    <!-- ===== FORMULÁRIO PRINCIPAL ===== -->
                                    <section class="profile-section" aria-labelledby="edit-profile-title">
                                        <h2 class="section-title" id="edit-profile-title">
                                            <i class="bi bi-person-gear" aria-hidden="true"></i>
                                            Informações Pessoais
                                        </h2>
                                        <div class="content-article">

                                            <!-- Foto de perfil com preview -->
                                            <form method="POST" action="backend/src/edit.php" onsubmit="return validateUpdate()" novalidate>
                                                <div class="mb-4">
                                                    <label class="form-label" id="avatar-label">Foto de Perfil</label>
                                                    <div class="d-flex align-items-center gap-3 flex-wrap" aria-labelledby="avatar-label">
                                                        <img
                                                            src="<?php echo $user_photo_profile; ?>"
                                                            alt="Preview da foto de perfil"
                                                            class="avatar-preview rounded-circle"
                                                            id="avatar-preview"
                                                        >
                                                        <div>
                                                            <label for="avatar-upload" class="btn btn-outline-verde btn-sm d-block mb-2" role="button">
                                                                <i class="bi bi-upload me-2" aria-hidden="true"></i>Enviar foto
                                                            </label>
                                                            <input
                                                                type="file"
                                                                id="avatar-upload"
                                                                name="avatar"
                                                                accept="image/*"
                                                                class="visually-hidden"
                                                                aria-describedby="avatar-hint"
                                                                onchange="previewAvatar(this)"
                                                            >
                                                            <small class="d-block text-muted" id="avatar-hint">JPG, PNG ou GIF. Máx. 2 MB.</small>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Nome completo -->
                                                <div class="mb-3">
                                                    <label for="fullName" class="form-label">Nome Completo <span class="required-mark" aria-hidden="true">*</span></label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="fullName"
                                                        name="user_name"
                                                        value="<?php echo $user_name; ?>"
                                                        placeholder="Seu nome completo"
                                                        autocomplete="name"
                                                    >
                                                    
                                                </div>

                                                <!-- Username -->
                                                <div class="mb-3">
                                                    <label for="user" class="form-label">Nome de Usuário <span class="required-mark" aria-hidden="true">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text input-prefix" aria-hidden="true">@</span>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="user"
                                                            name="user_profile"
                                                            value="<?php echo $user_profile ?>"
                                                            placeholder="seunome"
                                                            autocomplete="username"
                                                            pattern="[a-zA-Z0-9_.]{8,45}"
                                                            aria-describedby="username-hint"
                                                        >
                                                    </div>
                                                    
                                                </div>

                                                <!-- E-mail -->
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">E-mail <span class="required-mark" aria-hidden="true">*</span></label>
                                                    <input
                                                        type="email"
                                                        class="form-control"
                                                        id="email"
                                                        name="email"
                                                        value="<?php echo $user_email_profile; ?>"
                                                        placeholder="seu@email.com"
                                                        autocomplete="email"
                                                    >
                                                    
                                                </div>

                                                <!-- Telefone -->
                                                <div class="mb-3">
                                                    <label for="phone" class="form-label">Telefone</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="phone"
                                                        name="phone"
                                                        placeholder="<?php echo $user_tel_profile; ?>"
                                                    >
                                                </div>

                                                <!-- Bio -->
                                                <div class="mb-3">
                                                    <label for="bio" class="form-label">Bio / Descrição</label>
                                                    <textarea
                                                        class="form-control"
                                                        id="bio"
                                                        name="biografia"
                                                        rows="4"
                                                        placeholder="Fale um pouco sobre você..."
                                                        maxlength="500"
                                                        aria-describedby="bio-counter"
                                                    ><?php echo $user_bio; ?></textarea>
                                                    <small class="form-text text-muted" id="bio-counter">Máx. 450 caracteres.</small>
                                                </div>

                                            
                                            <!-- Botões principais -->
                                            <div class="d-flex gap-2 flex-wrap mt-4">
                                                <button type="submit" class="btn btn-verde btn-save" id="btn-save" aria-label="Salvar alterações de perfil">
                                                    <span class="btn-text">
                                                        <i class="bi bi-check-lg me-2" aria-hidden="true"></i>Salvar Alterações
                                                    </span>
                                                    <span class="btn-loading d-none" aria-live="polite">
                                                        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Salvando...
                                                    </span>
                                                </button>
                                                <button type="reset" class="btn btn-outline-verde" aria-label="Cancelar e descartar alterações">
                                                    <i class="bi bi-x-lg me-2" aria-hidden="true"></i>Cancelar
                                                </button>
                                            </div>
                                            </form>
                                        </div>
                                    </section>

                                    <!-- ===== ALTERAÇÃO DE SENHA ===== -->
                                    <section class="profile-section" aria-labelledby="password-title">
                                        <h2 class="section-title" id="password-title">
                                            <i class="bi bi-key" aria-hidden="true"></i>
                                            Alterar Senha
                                        </h2>
                                        <div class="content-article">

                                            <!-- Senha atual -->
                                            <div class="mb-3">
                                                <label for="current-password" class="form-label">Senha Atual <span class="required-mark" aria-hidden="true">*</span></label>
                                                <div class="input-group">
                                                    <input
                                                        type="password"
                                                        class="form-control"
                                                        id="current-password"
                                                        name="current_password"
                                                        placeholder="••••••••"
                                                        autocomplete="current-password"
                                                        aria-required="true"
                                                    >
                                                    <button
                                                        class="btn btn-input-toggle"
                                                        type="button"
                                                        aria-label="Mostrar/ocultar senha atual"
                                                        onclick="togglePassword('current-password', this)"
                                                    >
                                                        <i class="bi bi-eye" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Nova senha -->
                                            <div class="mb-3">
                                                <label for="new-password" class="form-label">Nova Senha <span class="required-mark" aria-hidden="true">*</span></label>
                                                <div class="input-group">
                                                    <input
                                                        type="password"
                                                        class="form-control"
                                                        id="new-password"
                                                        name="new_password"
                                                        placeholder="••••••••"
                                                        autocomplete="new-password"
                                                        minlength="8"
                                                        aria-required="true"
                                                        aria-describedby="password-strength-hint"
                                                    >
                                                    <button
                                                        class="btn btn-input-toggle"
                                                        type="button"
                                                        aria-label="Mostrar/ocultar nova senha"
                                                        onclick="togglePassword('new-password', this)"
                                                    >
                                                        <i class="bi bi-eye" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                                <small class="form-text text-muted" id="password-strength-hint">Mínimo de 8 caracteres. Use letras, números e símbolos.</small>
                                            </div>

                                            <!-- Confirmar nova senha -->
                                            <div class="mb-4">
                                                <label for="confirm-password" class="form-label">Confirmar Nova Senha <span class="required-mark" aria-hidden="true">*</span></label>
                                                <div class="input-group">
                                                    <input
                                                        type="password"
                                                        class="form-control"
                                                        id="confirm-password"
                                                        name="confirm_password"
                                                        placeholder="••••••••"
                                                        autocomplete="new-password"
                                                    >
                                                    <button
                                                        class="btn btn-input-toggle"
                                                        type="button"
                                                        aria-label="Mostrar/ocultar confirmação de senha"
                                                        onclick="togglePassword('confirm-password', this)"
                                                    >
                                                        <i class="bi bi-eye" aria-hidden="true"></i>
                                                    </button>
                                                </div>
                                                <div class="invalid-feedback">As senhas não coincidem.</div>
                                            </div>

                                            <button type="submit" class="btn btn-verde" aria-label="Confirmar alteração de senha">
                                                <i class="bi bi-shield-lock me-2" aria-hidden="true"></i>Atualizar Senha
                                            </button>
                                        </div>
                                    </section>
                                </div>

                                <!-- COLUNA LATERAL DIREITA -->
                                <div class="col-12 col-xl-4">

                                    <!-- ===== PREFERÊNCIAS ===== -->
                                    <section class="profile-section" aria-labelledby="prefs-title">
                                        <h2 class="section-title" id="prefs-title">
                                            <i class="bi bi-sliders" aria-hidden="true"></i>
                                            Preferências
                                        </h2>
                                        <div class="content-article">
                                            <fieldset>
                                                <legend class="visually-hidden">E-mail visível para todos os usuários</legend>

                                                <!-- Toggle: Email público -->
                                                <div class="pref-item d-flex justify-content-between align-items-start gap-3">
                                                    <div>
                                                        <label for="pref-email-notif" class="pref-label">E-mail público</label>
                                                        <p class="pref-desc mb-0">Permita que alunos e tutores vejam seu e-mail.</p>
                                                    </div>
                                                    <div class="form-check form-switch mt-1 flex-shrink-0">
                                                        <input
                                                            class="form-check-input pref-switch"
                                                            type="checkbox"
                                                            id="pref-email-notif"
                                                            name="email_notifications"
                                                            checked
                                                            role="switch"
                                                            aria-checked="true"
                                                        >
                                                    </div>
                                                </div>

                                                <hr class="pref-divider">

                                                <!-- Toggle: Perfil público -->
                                                <div class="pref-item d-flex justify-content-between align-items-start gap-3">
                                                    <div>
                                                        <label for="pref-public-profile" class="pref-label">Perfil Público</label>
                                                        <p class="pref-desc mb-0">Permite que outros usuários visualizem seu perfil e artigos. <i>(Desabilitado para tutores)</i></p>
                                                    </div>
                                                    <div class="form-check form-switch mt-1 flex-shrink-0">
                                                        <input
                                                            class="form-check-input pref-switch"
                                                            type="checkbox"
                                                            id="pref-public-profile"
                                                            name="public_profile"
                                                            checked
                                                            role="switch"
                                                            aria-checked="true"
                                                        >
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </section>

                                    <!-- ===== ZONA DE PERIGO ===== -->
                                    <section class="profile-section" aria-labelledby="danger-title">
                                        <h2 class="section-title danger-title" id="danger-title">
                                            <i class="bi bi-exclamation-triangle" aria-hidden="true"></i>
                                            Zona de Perigo
                                        </h2>
                                        <div class="content-article danger-zone">
                                            <div class="danger-action d-flex justify-content-between align-items-center flex-wrap gap-2">
                                                <div>
                                                    <strong class="d-block text-danger-bio">Excluir Conta</strong>
                                                    <small class="text-secundario">Remove permanentemente sua conta e todos os seus dados.</small>
                                                </div>
                                                <button
                                                    type="button"
                                                    class="btn btn-outline-danger btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal"
                                                    aria-label="Excluir conta permanentemente"
                                                >
                                                    <i class="bi bi-trash me-1" aria-hidden="true"></i>Excluir
                                                </button>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                        <!-- /ABA 2 -->
                         <?php endif; ?>

                    </div>
                    <!-- /tab-content -->

                </main>
                <!-- /main -->
            </div>
        </div>
        <!-- /layout-wrapper -->

        <!-- ===================== FOOTER ===================== -->
        <footer role="contentinfo">
            <div class="container-fluid px-4">
                <p class="text-center">
                    &copy; 2026 <a href="index.php">BioAlumnus</a> — Enciclopédia de Biologia.
                    Feito com <i class="bi bi-heart-fill" class="text-destaque" aria-hidden="true"></i> pela comunidade.
                </p>
            </div>
        </footer>

        <!-- ===================== MODAL: CONFIRMAR EXCLUSÃO ===================== -->
        <div
            class="modal fade"
            id="deleteModal"
            tabindex="-1"
            aria-labelledby="deleteModalLabel"
            aria-describedby="deleteModalDesc"
        >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content delete-modal-content">
                    <div class="modal-header delete-modal-header">
                        <h3 class="modal-title" id="deleteModalLabel">
                            <i class="bi bi-exclamation-triangle-fill me-2" class="text-danger-bio" aria-hidden="true"></i>
                            Confirmar Exclusão de Conta
                        </h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <p id="deleteModalDesc" class="text-secundario">
                            Esta ação é <strong class="text-danger-bio">permanente e irreversível</strong>. Todos os seus artigos, comentários e dados serão deletados.
                        </p>
                        <div class="mb-3">
                            <label for="confirm-delete-input" class="form-label">
                                Para confirmar, digite <strong class="text-destaque"><?php echo $user_profile; ?></strong> abaixo:
                            </label>
                            <input
                                type="text"
                                class="form-control"
                                id="confirm-delete-input"
                                placeholder="<?php echo $user_profile; ?>"
                                aria-describedby="deleteModalDesc"
                            >
                        </div>
                    </div>
                    <div class="modal-footer delete-modal-footer">
                        <button type="button" class="btn btn-outline-verde" data-bs-dismiss="modal">
                            <i class="bi bi-x-lg me-2" aria-hidden="true"></i>Cancelar
                        </button>
                        <button type="button" class="btn btn-danger" id="btn-confirm-delete" disabled aria-label="Confirmar exclusão permanente da conta">
                            <i class="bi bi-trash me-2" aria-hidden="true"></i>Excluir Permanentemente
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="backend/assets/js/auth.js"></script>
        <script src="https://unpkg.com/imask"></script>
        <!-- ===================== JS: Microinterações e UI ===================== -->
        <script>
            /* ---------- Toggle visibilidade de senha ---------- */
            function togglePassword(inputId, btn) {
                const input = document.getElementById(inputId);
                const icon  = btn.querySelector('i');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.replace('bi-eye', 'bi-eye-slash');
                    btn.setAttribute('aria-label', btn.getAttribute('aria-label').replace('Mostrar', 'Ocultar'));
                } else {
                    input.type = 'password';
                    icon.classList.replace('bi-eye-slash', 'bi-eye');
                    btn.setAttribute('aria-label', btn.getAttribute('aria-label').replace('Ocultar', 'Mostrar'));
                }
            }

            /* ---------- Preview de avatar ao fazer upload ---------- */
            function previewAvatar(input) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('avatar-preview').src = e.target.result;
                        document.getElementById('preview-avatar-display').src = e.target.result;
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            /* ---------- Botão salvar: estado loading ---------- */
            

            /* ---------- Modal exclusão: habilitar botão só após confirmação ---------- */
            const confirmDeleteInput = document.getElementById('confirm-delete-input');
            const btnConfirmDelete   = document.getElementById('btn-confirm-delete');
            if (confirmDeleteInput && btnConfirmDelete) {
                confirmDeleteInput.addEventListener('input', function () {
                    btnConfirmDelete.disabled = this.value.trim() !== '<?php echo $user_profile; ?>';
                });
            }

            /* ---------- Sincronizar sidebar links com abas ---------- */
            document.querySelectorAll('.sidebar-nav a[data-bs-toggle="tab"]').forEach(link => {
                link.addEventListener('click', function () {
                    document.querySelectorAll('.sidebar-nav a').forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            document.querySelectorAll('.profile-tab-btn').forEach(btn => {
                btn.addEventListener('shown.bs.tab', function () {
                    const target = this.getAttribute('data-bs-target');
                    document.querySelectorAll('.sidebar-nav a[data-bs-target]').forEach(link => {
                        link.classList.toggle('active', link.getAttribute('data-bs-target') === target);
                    });
                });
            });


            // SWEETALERT para alertar sobre os campos
            // MENSAGEM DE SUCESSO
            <?php if(isset($_SESSION['success'])): ?>
                Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    background: "var(--verde-mato)",
                    color: "white",
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                }
                }).fire({
                    icon: "success",
                    title: '<?= $_SESSION['success'] ?>'
                });
            <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            // MENSAGEM DE ERRO
            <?php if(isset($_SESSION['error'])): ?>
                Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    background: "var(--verde-mato)",
                    color: "white",
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                }
                }).fire({
                    icon: "error",
                    title: '<?= $_SESSION['error'] ?>'
                });
            <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            // MASCARAR O INPUT DE TELEFONE
            IMask(
                document.getElementById('phone'),
                {
                    mask: '+{55}(00)00000-0000'
                }
            )

        </script>
    <?php else: ?>
        <div class="d-flex flex-column flex-sm-row align-items-center align-items-sm-end gap-3 mb-3">
            <div class="profile-info flex-grow-1 text-center mt-4 mb-1">
                <i style="color: var(--verde-destaque); font-size: 50px;" class="bi bi-bug-fill"></i>
                <h1 class="profile-name mb-2">Ops... lamentamos!</h1>
                <p class="profile-username"><i>Você tentou procurar um perfil... mas não o encontramos em nossa teia alimentar.</i></p>
            </div>
        </div>
    <?php endif; ?>
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
