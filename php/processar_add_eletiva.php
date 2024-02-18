<?php
    include "database.php";
     
        $professor_1 =  str_replace(' ','_', $_POST['1prof']);
        $professor_2 =  str_replace(' ','_', $_POST['2prof']);
        $professor_3 =  str_replace(' ','_', $_POST['3prof']); 
        $curso = $_POST['cursos']; 
        $vagas = $_POST["vagas"];
        $turno = $_POST["turno"];

        if($turno == "INTERMEDIÁRIO"){
            $nome_tabela_eletiva = "eletiva_I_" . str_replace(' ','_', $_POST['nome-eletiva']);
            $nome_registro = "INT_" . $_POST["nome-eletiva"];
        }else if($turno == "VESPERTINO"){
            $nome_tabela_eletiva = "eletiva_V_" . str_replace(' ','_', $_POST['nome-eletiva']);
            $nome_registro = "VES_" . $_POST["nome-eletiva"];
        }else{
            $nome_tabela_eletiva = "eletiva_N_" . str_replace(' ','_', $_POST['nome-eletiva']);
            $nome_registro = "NOT_" . $_POST["nome-eletiva"];
        }

        $verificar_inexistencia = query("SHOW TABLES LIKE '$nome_tabela_eletiva'");
   
        if($verificar_inexistencia->num_rows == 0 ){
            $inserir_dados = query("INSERT INTO eletivas(nome_eletiva,professor_1,professor_2,professor_3,curso,vagas,turno) VALUES ('$nome_registro','$professor_1','$professor_2','$professor_3','$curso','$vagas','$turno')");

            if($inserir_dados){
             $criar_tabela = query("CREATE TABLE IF NOT EXISTS $nome_tabela_eletiva(
                     RA int,
                     nome_aluno varchar(255),
                     serie_aluno varchar(255)
                 )default charset utf8;
             ");
             if($criar_tabela){
                 header("location: ../html/add-eletiva.html?status=true");
             }
            }
        }else{
            header("location: ../html/add-eletiva.html?status=false");
        }

       