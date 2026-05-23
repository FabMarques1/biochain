<?php

require_once "db_queries.php";
require_once "../config/database.php";
session_start();

$id = $_SESSION['id'];
$user_name = trim($_POST['user_name']);
$user_profile = strtolower(trim($_POST['user_profile']));
$email = $_POST['email'];
$phone = $_POST['phone'];
$biografia = htmlspecialchars($_POST['biografia']);

if(!isset($_SESSION['auth'])) {
    $_SESSION['error'] = "Seu login expirou. Entre novamente.";
    header("Location: ../../login.php");
    exit;
}

if(empty($user_name) || empty($user_profile) || empty($email) || empty($biografia)) {
    $_SESSION['error'] = "Nenhum dos campos devem estar vazio (exceto telefone).";
    header("Location: ../../profile.php?id=" . urlencode($id));
    exit;
}

if(strlen($user_name) <= 8 || strlen($user_name) >= 200){
    $_SESSION['error'] = "Seu nome completo deve ter no mínimo 8 caracteres.";
    header("Location: ../../profile.php?id=" . urlencode($id));
    exit;
}

if(strlen($user_profile) <= 8 || strlen($user_profile) >= 45){
    $_SESSION['error'] = "Seu nome de usuário deve ter no mínimo 8 caracteres.";
    header("Location: ../../profile.php?id=" . urlencode($id));
    exit;
}

if(strlen($biografia) <= 1){
    $_SESSION['error'] = "Sua biografia deve ter no mínimo 1 caractere.";
    header("Location: ../../profile.php?id=" . urlencode($id));
    exit;
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Por favor, insira um endereço de email real.";
    header("Location: ../../profile.php?id=" . urlencode($id));
    exit;
}

$conn->begin_transaction();

try {

    $query = $conn->prepare(
        "SELECT
            users.username,
            users.userprofile,
            users.email,
            GROUP_CONCAT(tel.phone SEPARATOR ', ') AS phone,
            users.cargo,
            users.biografia
        FROM tbl_usuarios users
        LEFT JOIN tbl_telefone tel
            ON users.id = tel.userprofile
        WHERE users.id = ?
        GROUP BY
            users.username,
            users.userprofile,
            users.email,
            users.cargo,
            users.biografia"
    );

    $query->bind_param("i", $id);
    $query->execute();

    $result = $query->get_result();

    if ($result->num_rows < 1) {
        throw new Exception("Erro ao localizar usuário.");
    }

    $row = $result->fetch_assoc();

    $updated = false;

    if ($user_name != $row['username']) {
        update('tbl_usuarios', 'username', $user_name, $id);
        $updated = true;
    }

    if ($user_profile != $row['userprofile']) {

        $query = $conn->prepare(
            "SELECT userprofile
            FROM tbl_usuarios
            WHERE userprofile = ?"
        );
        $query->bind_param("s", $user_profile);
        $query->execute();

        $result = $query->get_result();

        if($result->num_rows > 0){
            throw new Exception("Usuário já existe.");
        }

        update('tbl_usuarios', 'userprofile', $user_profile, $id);
        $updated = true;
    }

    if ($email != $row['email']) {

        $query = $conn->prepare(
            "SELECT email
            FROM tbl_usuarios
            WHERE email = ?"
        );
        $query->bind_param("s", $email);
        $query->execute();

        $result = $query->get_result();

        if($result->num_rows > 0){
            throw new Exception("Email já existe.");
        }

        update('tbl_usuarios', 'email', $email, $id);
        $updated = true;
    }

    if ($biografia != $row['biografia']) {
        update('tbl_usuarios', 'biografia', $biografia, $id);
        $updated = true;
    }

    $conn->commit();

    $_SESSION['success'] = $updated ? "Alterações feitas com êxito!" : "Nenhuma alteração foi necessária.";

    $_SESSION['username'] = $user_name;
    $_SESSION['user'] = $user_profile;
    $_SESSION['email'] = $email;
    // $_SESSION['telefone'] = ;
    $_SESSION['biografia'] = $biografia;

    header("Location: ../../profile.php?id=" . urlencode($id));
    exit;

} catch (Exception $e) {

    $conn->rollback();

    $_SESSION['error'] = $e->getMessage();

    header("Location: ../../profile.php?id=" . urlencode($id));
    exit;
}


?>