// VALIDAÇÃO DO FORMULÁRIO DE LOGIN E REGISTRO COM SWEETALERT uwu
let user = document.getElementById('user');
let password = document.getElementById('password');
let fullName = document.getElementById('fullName');
let email = document.getElementById('email');
let biografia = document.getElementById('biografia');
const termosCheck = document.getElementById('termos-check');

const applyError = (input, message) => {
    input.classList.add('is-invalid');
    errorMsg(message);

    input.focus();

    input.addEventListener('input', function() {
        this.classList.remove('is-invalid');
    }, { once: true });

    return false;
}
// me demite então

function errorMsg(msg){
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
        title: msg
    });
}

function validateLogin(){

    if (!user.value) {
        return applyError(user, "Insira seu nome de usuário.");
    } 
    else if(user.value.length <= 7) {
        return applyError(user, "Seu nome de usuário deve ter no mínimo 8 caracteres.");
    }  
    else if(!password.value) {
        return applyError(password, "Insira sua senha.");
    }
    else if(password.value.length <= 5) {
        return applyError(password, "Sua senha deve ter no mínimo 6 caracteres.");
    }

}

function validateRegister(){

    if (!fullName.value) {
        return applyError(fullName, "Insira seu nome completo.");
    }
    else if (fullName.value.length <= 7) {
        return applyError(fullName, "Seu nome completo deve ter no mínimo 8 caracteres.");
    }

    if (!user.value) {
        return applyError(user, "Insira seu nome de usuário ou email.");
    } 
    else if(user.value.length <= 7) {
        return applyError(user, "Seu nome de usuário ou email deve ter no mínimo 8 caracteres.");
    }  

    if (!email.value) {
        return applyError(email, "Insira seu email.");
    }
    else if (email.value.length <= 7) {
        return applyError(email, "Seu email deve ter no mínimo 8 caracteres.")
    }
    else if (!email.value.includes('@') || !email.value.includes('.')) {
        return applyError(email, "Por favor, insira um endereço de email real.");
    }

    if (!password.value) {
        return applyError(password, "Insira sua senha.");
    }
    else if (password.value.length <= 5) {
        return applyError(password, "Sua senha deve ter no mínimo 6 caracteres.");
    }

    if (!termosCheck.checked) {
        return applyError(termosCheck, "Você deve concordar com os termos de uso. Leia para saber mais.");
    }

}

function validateUpdate() {
    if (!fullName.value) {
        return applyError(fullName, "Insira seu nome completo.");
    }
    else if (fullName.value.length <= 7) {
        return applyError(fullName, "Seu nome completo deve ter no mínimo 8 caracteres.");
    }

    if (!user.value) {
        return applyError(user, "Insira seu nome de usuário ou email.");
    } 
    else if(user.value.length <= 7) {
        return applyError(user, "Seu nome de usuário ou email deve ter no mínimo 8 caracteres.");
    }

    if (!email.value) {
        return applyError(email, "Insira seu email.");
    }
    else if (email.value.length <= 7) {
        return applyError(email, "Seu email deve ter no mínimo 8 caracteres.")
    }
    else if (!email.value.includes('@') || !email.value.includes('.')) {
        return applyError(email, "Por favor, insira um endereço de email real.");
    }

    if (!biografia.value) {
        return applyError(biografia, "Insira sua biografia.");
    } 
}