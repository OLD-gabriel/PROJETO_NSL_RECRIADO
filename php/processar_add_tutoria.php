<?php
    include "database.php";

    $nome = $_POST["nome"];
    $turno = $_POST["turno"];

    if($turno == "INTERMEDIÁRIO"){
        $nome_tabela_tutoria = "tutoria_I_" . str_replace(" ","_",$nome);
        $nome_registro = "INT_" . $_POST["nome"];
    }else if($turno == "VESPERTINO"){
        $nome_tabela_tutoria = "tutoria_V_" . str_replace(" ","_",$nome);
        $nome_registro = "VES_" . $_POST["nome"];
    }else{
        $nome_tabela_tutoria = "tutoria_N_" . str_replace(" ","_",$nome);
        $nome_registro = "NOT_" . $_POST["nome"];
    }
    
    $verificar_inexistencia = query("SHOW TABLES LIKE '$nome_tabela_tutoria'");
   
    if($verificar_inexistencia->num_rows == 0 ){
        $inseirir_tabela = query("INSERT INTO tutoria (nome_professor,vagas,turno) VALUES ('$nome_registro','$vagas_tutoria','$turno')");
        if($inseirir_tabela){
            $criar_tabela = query("CREATE TABLE $nome_tabela_tutoria(
                Nome_professor varchar(255),
                RA int,
                nome_aluno varchar(255),
                serie_aluno varchar(255)
                )default charset utf8;
            ");
        if($criar_tabela){
            header("location: ../html/add-tutoria.html?status=true");
        }    
    }
    }else{
        header("location: ../html/add-tutoria.html?status=false");
    }


   
