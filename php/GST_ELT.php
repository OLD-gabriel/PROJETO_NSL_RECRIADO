<?php
include "database.php";

function Exibir_eletivas()
{

    $consulta = query("SELECT * FROM eletivas ORDER BY turno ASC ");
    if ($consulta->num_rows > 0) {
        foreach ($consulta as $row) {
            echo "                                                  
            <div class='eletivas'> 
            <h2>ELETIVA:</h2>  
            <span class='nome-tutor'>" .  $row["nome_eletiva"]  . " <br> </span>                     
            <h2>Professores:</h2>  
            <span class='nome-eletiva'>" . $row["professor_1"] . "  </span>
            <span class='nome-eletiva'>" . $row["professor_2"] . "  </span>
            <span class='nome-eletiva'>" . $row["professor_3"] . "  </span>
            <h2>Curso da eletiva:</h2>  
            <span class='nome-eletiva'>" . str_replace(" ", "<br>", $row["curso"]) . "  </span>
            <h2>Turno da eletiva:</h2>  
            <span class='nome-eletiva'>" . $row["turno"] . "  </span>
            <span class'nome-eletiva'>
            <b>vagas:</b>
            " . $row["vagas"] . "
            </span>
            <form action='' method='post'>
                <button type='submit' class='botao' name='eletiva' value='escolher-" . $row["nome_eletiva"] . $row["turno"] . "' > Ver Alunos   </button> 
            </form> 
            <form action='' method='get'>
                <button type='submit' class='botao-excluir' name='excluir' value='excluir-" . $row["nome_eletiva"] . $row["turno"] . "'>Excluir Eletiva</button> 
            </form> 
    
                    </div>";
        }
    } else {
        echo "  
    <div class='eletivas'>
    <h1>SEM ELETIVAS!</h1> <br> 
<span> Adicione Eletivas<a href='../html/add-eletiva.html'> Aqui </a> </span>
</div> 
    ";
    }
}

if (isset($_GET["excluir"])) {
    $consulta = query("SELECT * FROM eletivas");
    $botaoclicado = $_GET["excluir"];
    foreach ($consulta as $row) {
        if ($botaoclicado == "excluir-" . $row["nome_eletiva"] . $row["turno"]) {

            $turno = $row["turno"];
            $nome_eletiva = $row["nome_eletiva"];

            $consulta_excluir = query("SELECT * FROM todas_escolhas_eletiva WHERE nome_eletiva = '$nome_eletiva' AND turno = '$turno'");

            foreach ($consulta_excluir as $row_excluir) {
                $RA = $row_excluir["RA"];
                $excluir_registro = query("DELETE FROM todas_escolhas_eletiva where RA = '$RA'");
            }

            $apagar_registro = query("DELETE FROM eletivas where nome_eletiva = '$nome_eletiva' AND turno = '$turno' ");

            if ($apagar_registro) {
                echo "<script>history.replaceState({},document.title,window.location.pathname)</script>";
            }
        }
    }
}

if (isset($_POST["eletiva"])) {
    $consulta = query("SELECT * FROM eletivas");
    $botaoclicado = $_POST["eletiva"];
    foreach ($consulta as $row) {
        if ($botaoclicado == "escolher-" . $row["nome_eletiva"] . $row["turno"]) {
            session_start();
            $_SESSION["eletiva"] = $row["nome_eletiva"];
            $_SESSION["turno"] = $row["turno"];
            header("location: eletivandos.php");
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Eletivas | Nsl</title>
    <link rel="shortcut icon" href="../img/favicon (3).ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/style_GstEletiva.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;800&display=swap" rel="stylesheet">
</head>

<body>
    <!-- Pop-up -->
    <div id='sobreposicao-popup' class="sobreposicao-popup">
        <div id='conteudo-popup' class="conteudo-popup">
            <h2>Sucess</h2>
            <p> Eletiva Excluida com <br> sucesso!</p>
            <button id='fechar-popup' class="fechar-popup">Fechar</button>
        </div>
    </div>

    <!-- Script JavaScript -->
    <script>
        setTimeout(function() {
            location.reload()
        }, 10000)

        const botaoFecharPopup = document.getElementById('fechar-popup');
        const sobreposicaoPopup = document.getElementById('sobreposicao-popup');

        function fecharPopup() {
            sobreposicaoPopup.style.display = 'none';
        }

        function mostrarPopup() {
            sobreposicaoPopup.style.display = 'block';
        }



        botaoFecharPopup.addEventListener('click', fecharPopup);
    </script>


    <header class="header">
        <div class="brazao">
            <a href="../Tutoria-Eletiva.html"><img src="../img/brazao.png" alt="Brazao" class="brazao"></a>
        </div>

        <div class="header-user">
            <a href="#" class="nome">
                ADMINISTRADOR
            </a>
            <img src="../img/Imagem1.svg" alt="" class="user">
        </div>
    </header>

    <main class="eletiva-bg">
        <?php
        Exibir_eletivas();
        ?>
    </main>

    <?php

    ?>
    <center>
        <button class="botao" onclick="window.location.href = '../html/pag_gestor.html'">Voltar</button>
    </center>

    <footer>
        <div class="creditos">
            <p class="projeto-info">Projeto realizado pelos alunos de Altas Habilidades da escola "EEEM Nossa Senhora de Lourdes"
            </p>
            <p class="supervisao-info">Supervisionado pelos professores Alex Menezes & Vânia Alves</p>

            <div class="nomes-grupos">


                <div class="back">
                    <h4>Backend<br> desenvolvido por:</h4>
                    <p class="backend-info"> Gabriel <br>Cirqueira</p>
                </div>
                <div class="vertical"></div>

                <div class="bd">
                    <h4>Banco de dados <br>desenvolvido por:</h4>
                    <p class="bd-info"> Gabriel<br> Cirqueira &<br> Matheus <br>Trindade</p>

                </div>
                <div class="vertical"></div>

                <div class="front">
                    <h4>Frontend <br>desenvolvido por:</h4>
                    <p class="frontend-info"> Guilherme<br> Vagmaker & <br> Arthur <br> Possino</p>

                </div>
            </div>

        </div>
        <hr class="linha-horizontal">
        <div class="informacoes-escola">


        </div>
    </footer>

</body>

</html>