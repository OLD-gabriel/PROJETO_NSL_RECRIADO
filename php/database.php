<?php

include 'variables.php';

$conn_banco = mysqli_connect($host, $user, $password);

if ($conn_banco) {
    $criar_banco = mysqli_query($conn_banco, "CREATE DATABASE IF NOT EXISTS ESCOLA
        default charset utf8
        default collate utf8_general_ci;
        ");
}

mysqli_close($conn_banco);

$conn = mysqli_connect($host, $user, $password, $db);

function query($str){
    global $conn;
    return mysqli_query($conn, $str);
}

// OBS: só pode ter uma coluna como 'auto_increment' na tabela, e ela deve ser primary key

$create_table = query("CREATE TABLE IF NOT EXISTS TODAS_ESCOLHAS_ELETIVA(
    RA int,
    nome_aluno varchar(255),
    nome_eletiva varchar(255),
    serie_aluno varchar(255),
    curso varchar(255),
    turno varchar(255)
)default charset utf8;
");

$create_table = query("CREATE TABLE IF NOT EXISTS ELETIVAS(
    nome_eletiva varchar(255),
    professor_1 varchar(255),
    professor_2 varchar(255),
    professor_3 varchar(255),
    curso varchar(255),
    turno varchar(255),
    vagas int
)default charset utf8;
");

$create_table = query("CREATE TABLE IF NOT EXISTS TODAS_ESCOLHAS_TUTORIA(
    RA int,
    nome_aluno varchar(255),
    nome_tutoria varchar(255),
    turno varchar(255),
    serie_aluno varchar(255)
)default charset utf8;
");

$create_table = query("CREATE TABLE IF NOT EXISTS TUTORIA(
    nome_professor varchar(255),
    turno varchar(255),
    vagas int
)default charset utf8;");

$create_table = query("CREATE TABLE IF NOT EXISTS ALUNOS(
    RA int,
    nome_aluno varchar(255),
    serie_aluno varchar(255),
    turno varchar(255),
    curso_aluno varchar(255)
)default charset utf8;
");
