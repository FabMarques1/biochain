<?php

session_start();

require "backend/config/database.php";

?>

<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioAlumnus - Criar Conta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="frontend/styles/registro.css">
    <link rel="icon" href="frontend/assets/icons/icon.png">
</head>
<body>
    <div class="register-wrapper">
        <div class="register-container">
            <div class="register-form-side">
                <div class="register-brand">
                    <i class="register-icon"><img src="frontend/assets/icons/icon.png" alt="Ícone principal"></i>
                    <span>BioAlumnus</span>
                </div>
                <h1 class="register-title">Criar nova conta</h1>
                <p class="register-subtitle">Preencha os dados abaixo para se cadastrar na plataforma</p>
                <form action="backend/src/regAuth.php" method="POST" id="registerForm" onsubmit="return validateRegister()" novalidate>
                    <div class="mb-3">
                        <label for="fullName" class="form-label">Nome Completo</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                            <input name="fullName" type="text" class="form-control" id="fullName" placeholder="Digite seu nome completo" minlength="8" maxlength="200" autocomplete="name" required>
                        </div>
                        <div class="char-counter"><span id="fullNameCount">0</span>/200 caracteres</div>
                    </div>
                    <div class="mb-3">
                        <label for="user" class="form-label">Nome de Usuario</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-badge-fill"></i></span>
                            <input name="user" type="text" class="form-control" id="user" placeholder="Escolha um nome de usuario" minlength="8" maxlength="45" autocomplete="username" pattern="/^[A-Za-z0-9_.]+$/" required>
                        </div>
                        <div class="char-counter"><span id="usernameCount">0</span>/45 caracteres</div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                            <input name="email" type="email" class="form-control" id="email" placeholder="Digite seu melhor e-mail" minlength="8" maxlength="255" autocomplete="email" required>
                        </div>
                        <div class="char-counter"><span id="emailCount">0</span>/255 caracteres</div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <div class="input-group position-relative">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input name="password" type="password" class="form-control pe-5" id="password" placeholder="Crie uma senha segura" minlength="6" maxlength="45" autocomplete="new-password" required>
                            <button type="button" class="password-toggle" onclick="togglePassword()">
                                <i class="bi bi-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        <div class="char-counter"><span id="passwordCount">0</span>/45 caracteres</div>
                    </div>
                    <div class="form-check mb-4">
                        <input id="termos-check" class="form-check-input" type="checkbox" id="termsCheck" required>
                        <label class="form-check-label" for="termsCheck">
                            Li e concordo com os <a href="#" class="link-verde">Termos de Uso</a> e <a href="#" class="link-verde">Politica de Privacidade</a>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-verde w-100 mb-3">
                        <i class="bi bi-person-plus-fill me-2"></i>Criar Conta
                    </button>
                    <div class="divider-text">ou cadastre-se com</div>
                    <button type="button" class="btn btn-outline-verde w-100 mb-4" disabled>
                        <i class="bi bi-google me-2"></i>Continuar com Google
                    </button>
                    <p class="text-center mb-0" style="color: var(--texto-secundario); font-size: 0.9rem;">
                        Ja possui uma conta? <a href="login.php" class="link-verde">Fazer login</a>
                    </p>
                </form>
            </div>
            <div class="register-visual">
                <i class="register-icon-secondary"><img src="frontend/assets/icons/icon.png" alt="Ícone principal"></i>
                <h2>BioAlumnus</h2>
                <p>Junte-se a comunidade academica de Biologia e expanda seus conhecimentos cientificos.</p>
                <ul class="register-visual-features">
                    <li><i class="bi bi-check-circle-fill"></i> Acesso a artigos exclusivos</li>
                    <li><i class="bi bi-check-circle-fill"></i> Interaja com professores e alunos</li>
                    <li><i class="bi bi-check-circle-fill"></i> Publique suas pesquisas</li>
                    <li><i class="bi bi-check-circle-fill"></i> Certificados de participacao</li>
                </ul>
            </div>
        </div>
    </div>
    <footer class="register-footer">
        <p>&copy; 2026 <a href="index.html">BioAlumnus</a> - Todos os direitos reservados</p>
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

        document.getElementById('user').addEventListener("input", function () {
            
            this.value = this.value.replace(/[^a-zA-Z0-9_.]/g, "");
            
            if (this.value.endsWith(".") || this.value.endsWith("_")) {
                this.value = this.value.slice(0, -1);

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
                    title: 'Não é permitido: terminar com "_" e ".", caracteres especiais e espaços!'
                });
            }
        });

        document.getElementById('fullName').addEventListener('input', function() {
            document.getElementById('fullNameCount').textContent = this.value.length;
        });

        document.getElementById('user').addEventListener('input', function() {
            document.getElementById('usernameCount').textContent = this.value.length;
        });

        document.getElementById('email').addEventListener('input', function() {
            document.getElementById('emailCount').textContent = this.value.length;
        });

        document.getElementById('password').addEventListener('input', function() {
            document.getElementById('passwordCount').textContent = this.value.length;
        });
    </script>
    <script>
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
    </script>
</body>
</html>