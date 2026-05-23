<?php

require_once "../config/database.php";

session_start();

if(!isset($_POST['user'], $_POST['pass'])){
    header("Location: ../../login.php");
    exit;
}

$user = strtolower(trim($_POST['user']));
$pass = $_POST['pass'];

$stmt = $conn->prepare(
    "SELECT
        users.id,
        users.cargo,
        users.username,
        users.userprofile,
        users.email,
        GROUP_CONCAT(tel.phone SEPARATOR ', ') AS phone,
        users.pass,
        users.biografia,
        users.createdAt
    FROM tbl_usuarios users
    LEFT JOIN tbl_telefone tel
    ON users.id = tel.phone
    WHERE users.userprofile = ?
    GROUP BY 
        users.id,
        users.cargo,
        users.username,
        users.userprofile,
        users.email,
        users.pass,
        users.biografia,
        users.createdAt"
);
$stmt->bind_param("s", $user);

if(!$stmt->execute()){
    $_SESSION['error'] = "Erro ao localizar usuário...";
    header("Location: ../../login.php");
    exit;
}

$result = $stmt->get_result();

if($result->num_rows < 1){
    $_SESSION['error'] = "Usuário ou senha incorretos!";
    header("Location: ../../login.php");
    exit;
}

$row = $result->fetch_assoc();

if(!password_verify($pass, $row['pass'])){
    $_SESSION['error'] = "Usuário ou senha incorretos!";
    header("Location: ../../login.php");
    exit;
}

session_regenerate_id(true);

$_SESSION['auth'] = true;

// RESPECTIVAS INFORMAÇÕES

$_SESSION['id'] = $row['id'];
$_SESSION['cargo'] = $row['cargo'];
$_SESSION['username'] = $row['username'];
$_SESSION['user'] = $row['userprofile'];
$_SESSION['email'] = $row['email'];
$_SESSION['telefone'] = $row['phone'];
$_SESSION['biografia'] = $row['biografia'];
$_SESSION['createdAt'] = $row['createdAt'];

header("Location: ../../index.php");
exit;

?>