<?php

session_start();

require "../config/database.php";

// OBTENÇÃO DOS DADOS
$fullName = trim($_POST['fullName']);
$user = strtolower(trim($_POST['user']));
$email = strtolower(trim($_POST['email']));
$password = $_POST['password'];

if(empty($fullName) || empty($user) || empty($email) || empty($password)){
    header("Location: ../../registro.php");
    exit;
}

if(strlen($fullName) <= 8 || strlen($user) <= 8 || strlen($password) <= 6) {
    header("Location: ../../registro.php");
    exit;
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    die("Email inválido.");
}

$passHash = password_hash($password, PASSWORD_ARGON2ID);

$search = $conn->prepare(
    "SELECT
    user, email
    FROM tbl_usuarios
    WHERE user = ? OR email = ?"
);

$search->bind_param("ss", $user, $email);
$search->execute();

$result = $search->get_result();

if ($result->num_rows > 0) {
    $_SESSION['error'] = "Usuário ou email já cadastrados.";
    header("Location: ../../registro.php");
    exit;
} else{

    
    $query = $conn->prepare(
        "INSERT INTO tbl_usuarios (username, user, email, pass)
        VALUES (?, ?, ?, ?)"
    );
    $query->bind_param("ssss", $fullName, $user, $email, $passHash);
    
    if($query->execute()){
        $_SESSION['success'] = "Registro feito com sucesso!";
        header("Location: ../../login.php");
        exit;
    } else{
        echo "Erro interno ao cadastrar.";
    }

}

if(isset($search)){
    $search->close();
}

if(isset($query)){
    $query->close();
}
     


?>