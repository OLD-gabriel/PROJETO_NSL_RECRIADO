<?php
include "database.php";

$nome = $_POST["nome"];
$turno = $_POST["turno"];
$vagas = $_POST["vagas"];

if ($turno == "INTERMEDIÁRIO") {
    $nome_registro = "INT_" . $_POST["nome"];
} else if ($turno == "VESPERTINO") {
    $nome_registro = "VES_" . $_POST["nome"];
} else {
    $nome_registro = "NOT_" . $_POST["nome"];
}

$verificar_inexistencia = query("SELECT * FROM tutoria WHERE nome_professor = '$nome' AND turno = '$turno'");

if ($verificar_inexistencia->num_rows == 0) {
    $inseirir_tabela = query("INSERT INTO tutoria (nome_professor,vagas,turno) VALUES ('$nome','$vagas','$turno')");
    if ($inseirir_tabela) {
        header("location: ../html/add-tutoria.html?status=true");
    }
} else {
    header("location: ../html/add-tutoria.html?status=false");
}



