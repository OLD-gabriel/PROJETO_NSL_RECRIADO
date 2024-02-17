<?php
    include "database.php";

        $nome = $_POST["nome"];
        $serie = $_POST["series"];
        $curso = $_POST["cursos"];
        $RA = $_POST["ra"];
        $turno = $_POST["turno"];

        $inserir_dados = query("INSERT INTO alunos(RA,nome_aluno,serie_aluno,curso_aluno,turno) VALUES('$RA','$nome','$serie','$curso','$turno')");
     
        if($inserir_dados){
            header("location:../html/GST_ALUNOS.html?status=true");
        }
    

    
    