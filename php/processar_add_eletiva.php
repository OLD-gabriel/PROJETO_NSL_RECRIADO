<?php
    include "database.php";

        $nome_eletiva = $_POST['nome-eletiva'];
        $professor_1 =   $_POST['1prof'];
        $professor_2 =   $_POST['2prof'];
        $professor_3 =  $_POST['3prof']; 
        $turmas = $_POST['turma']; 
        $vagas = $_POST["vagas"];
        $turno = $_POST["turno"];
        $todos_cursos = " ";
        // var_dump($cursos);

        // $array_serilizado = serialize($cursos);

        // echo "<br><br>";
        // echo $array_serilizado;

        // echo "<br><br>";

        // var_dump(unserialize($array_serilizado));
        // echo "<br><br>";

        foreach($turmas as $turma){
            $todas_turmas .=  $turma . " ";
        } 

        $verificar_inexistencia = query("SELECT * from eletivas WHERE nome_eletiva = '$nome_eletiva' AND turno = '$turno' ");
   
        if($verificar_inexistencia->num_rows == 0 ){
            $inserir_dados = query("INSERT INTO eletivas(nome_eletiva,professor_1,professor_2,professor_3,turmas,vagas,turno) VALUES ('$nome_eletiva','$professor_1','$professor_2','$professor_3','$todas_turmas','$vagas','$turno')");

            if($inserir_dados){
                header("location: ../html/add-eletiva.html?status=true");
            }
        }else{
            header("location: ../html/add-eletiva.html?status=false");
        }

       