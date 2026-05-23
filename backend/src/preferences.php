<?php

require_once "../config/database.php";
session_start();

$id = $_SESSION['id'];

$query = $conn->prepare(
    "SELECT 
        show_email,
        show_profile
    FROM tbl_usuarios
    WHERE id = ?"
);
$query->bind_param("i", $id);
$query->execute();

$result = $query->get_result();

$row = $result->fetch_assoc();

$pref_email = isset($_POST['email_visible']) ? 1 : 0;
$pref_profile = isset($_POST['pref_profile']) ? 1 : 0;


if($pref_email != $row['show_email']) {
    $query = $conn->prepare("
        UPDATE tbl_usuarios
        SET show_email = ?
        WHERE id = ?
    ");

    $query->bind_param("ii", $pref_email, $id);
    $query->execute();

    $_SESSION['show_email'] = $pref_email;
}

if($pref_profile != $row['show_profile']) {
    $query = $conn->prepare("
        UPDATE tbl_usuarios
        SET show_profile = ?
        WHERE id = ?
    ");

    $query->bind_param("ii", $pref_profile, $id);
    $query->execute();

    $_SESSION['show_profile'] = $pref_profile;
}

header("Location: ../../profile.php?user=" . $_SESSION['user']);
exit;

?>