<?php

use LDAP\Result;

include 'database.php';
$ra = $_POST["RA"];

$consulta = query("SELECT * FROM alunos WHERE RA = '$ra'");
$result = mysqli_fetch_assoc($consulta);
$nome = $result["nome_aluno"];
$serie = $result["serie_aluno"];
$curso = $result["curso_aluno"];
$turno = $result["turno"];

if($consulta){
    if($consulta->num_rows > 0){
        session_start();
        $_SESSION["RA"] = $ra;
        $_SESSION["nome"] = $nome;
        $_SESSION["serie"] = $serie;
        $_SESSION["curso"] = $curso;
        $_SESSION["turno"] = $turno;
        header("location: ../html/Tutoria-Eletiva.html");
    }else{
        header("location: ../index.html?status=false");
    }
}