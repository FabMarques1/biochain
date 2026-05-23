<?php

require_once realpath(__DIR__ . "/../config/database.php");

// PROCURAR QUANTIA DE USUÁRIO
// TABLE = tabela que será chamada para contagem
function contar($table, $column, $id) {
    global $conn;
    $query = $conn->prepare(
        "SELECT COUNT(*) as total
        FROM $table
        WHERE $column = ?"
    );
    $query->bind_param("i", $id);
    $query->execute();

    $result = $query->get_result();
    $row = $result->fetch_assoc();

    return $row['total'];
}

function update($table, $column, $value, $id){
    global $conn;

    $tabelas = ['tbl_usuarios'];
    $colunas = ['username', 'userprofile', 'email', 'biografia'];

    if(!in_array($table, $tabelas) || !in_array($column, $colunas)){
        return false;
    }

    $query = $conn->prepare(
        "UPDATE $table
        SET $column = ?
        WHERE id = ?"
    );
    $query->bind_param("si", $value, $id);
    
    if(!$query->execute()){
        return false;
    }

    return true;
}

?>