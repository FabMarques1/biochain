<?php

session_start();

require "backend/config/database.php";

?>

<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioAlumnus - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="frontend/styles/login.css?">
    <link rel="icon" href="frontend/assets/icons/icon.png">
</head>
<body>
    <div class="login-wrapper">
        <div class="login-container">
            <div class="login-visual">
                <i class="login-icon"><img src="frontend/assets/icons/icon.png" alt="Ícone principal"></i>
                <h2>BioAlumnus</h2>
                <p>Sua plataforma de estudos centrada em Biologia.</p>
                <ul class="login-visual-features">
                    <li><i class="bi bi-check-circle-fill"></i> Artigos revisados por professores</li>
                    <li><i class="bi bi-check-circle-fill"></i> Comunidade ativa de estudantes</li>
                    <li><i class="bi bi-check-circle-fill"></i> Interatividade com o <span class="lupa-text">LUPA</span></li>
                </ul>
            </div>
            <div class="login-form-side">
                <div class="login-brand">
                    <i class="login-icon-secondary"><img src="frontend/assets/icons/icon.png" alt="Ícone principal"></i>
                    <span>BioAlumnus</span>
                </div>
                <h1 class="login-title">Entrar na sua conta</h1>
                <p class="login-subtitle">Preencha seus dados para acessar a plataforma</p>
                <form onsubmit="return validateLogin()" novalidate>
                    <div class="mb-3">
                        <label for="user" class="form-label">Usuário ou E-mail</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control" id="user" placeholder="Digite seu usuário ou e-mail" maxlength="255" required>
                        </div>
                        <div class="char-counter"><span id="userCount">0</span>/255 caracteres</div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <div class="input-group position-relative">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control pe-5" id="password" placeholder="Digite sua senha" maxlength="45" required>
                            <button type="button" class="password-toggle" onclick="togglePassword()">
                                <i class="bi bi-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        <div class="char-counter"><span id="passwordCount">0</span>/45 caracteres</div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="rememberMe">
                            <label class="form-check-label" for="rememberMe">Lembrar de mim</label>
                        </div>
                        <a href="#" class="link-verde" style="font-size: 0.9rem;">Esqueceu a senha?</a>
                    </div>
                    <button type="submit" class="btn btn-verde w-100 mb-3">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Entrar
                    </button>
                    <div class="divider-text">ou continue com</div>
                    <button type="button" class="btn btn-outline-verde w-100 mb-4" disabled>
                        <i class="bi bi-google me-2"></i>Entrar com Google
                    </button>
                    <p class="text-center mb-0" style="color: var(--texto-secundario); font-size: 0.9rem;">
                        Ainda não tem conta? <a href="registro.php" class="link-verde">Cadastre-se gratuitamente</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
    <footer class="login-footer">
        <p>&copy; 2026 <a href="index.php">BioAlumnus</a> - Todos os direitos reservados</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="backend/assets/js/auth.js?"></script>
    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }

        document.getElementById('user').addEventListener('input', function() {
            document.getElementById('userCount').textContent = this.value.length;
        });

        document.getElementById('password').addEventListener('input', function() {
            document.getElementById('passwordCount').textContent = this.value.length;
        });
    </script>
    <script>
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
    </script>
</body>
</html>