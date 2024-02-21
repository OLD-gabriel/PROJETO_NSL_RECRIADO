<?php
include "database.php";

function Exibir_tutores(){
    $consulta = query("SELECT * FROM tutoria ORDER BY turno ASC ");
    if ($consulta->num_rows > 0) {
        foreach ($consulta as $row) {
            echo "
            <div class='tutores'>
                <img src='../img/avatar.png' alt='' class=''>
                <span class='nome-tutor'>" . $row["nome_professor"] . "<br>
                    vagas:
                    " . $row["vagas"] . "
                </span>
                <h3>Turno da Tutoria:</h3>
                <span class='nome-tutor'>" . $row["turno"] . "
                </span>
                <form action='' method='post'>
                    <button type='submit' class='botao-ver' name='tutores' value='escolher-" .   $row["nome_professor"].$row["turno"] . "' >Ver alunos</button>
                </form>
                <form action='' method='get'>
                  <button type='submit' class='botao-excluir' name='excluir' value='excluir-" .  $row["nome_professor"].$row["turno"] ."'>Excluir</button> 
              </form>
             </div>
                ";
        }
    } else {
        echo "  
    <div class='tutores'>
    <h1>SEM TUTOR!</h1> <br> 
<span> Adicione Tutores  <a href='../html/add-tutoria.html'> Aqui </a> </span>
</div> 
    ";
    }
}

if (isset($_GET["excluir"])) {
    
    $consulta = query("SELECT * FROM tutoria");
    $botaoclicado = $_GET["excluir"];
    foreach ($consulta as $row) {
        if ($botaoclicado == "excluir-" . $row["nome_professor"].$row["turno"]) {

            $turno = $row["turno"];
            $nome_professor = $row["nome_professor"];

            $consulta_excluir = query("SELECT * FROM todas_escolhas_tutoria WHERE nome_tutoria = '$nome_professor' AND turno = '$turno'");

            foreach($consulta_excluir as $row_excluir){
                $RA = $row_excluir["RA"];
                $excluir_registro = query("DELETE FROM todas_escolhas_tutoria where RA = '$RA'");
            }

            $exluir_registro = query("DELETE FROM tutoria WHERE nome_professor = '$nome_professor' AND turno = '$turno'");
 
            if ($exluir_registro) {
                echo "<script>history.replaceState({},document.title,window.location.pathname)</script>";
            }
        }
    }
}

if(isset($_POST["tutores"])){
    $consulta = query("SELECT * FROM tutoria");
    $botaoclicado = $_POST["tutores"];
    foreach($consulta as $row){
        if($botaoclicado == "escolher-" . $row["nome_professor"].$row["turno"]){

            session_start();
            $_SESSION["tutor"] = $row["nome_professor"];
            $_SESSION["turno"] = $row["turno"];
            header("location: tutorandos.php");
        }
    }

}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gestor | Nsl</title>
    <link rel="shortcut icon" href="../img/favicon (3).ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/style-GST.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;800&display=swap" rel="stylesheet">

</head>

<body>
    <header class="header-bg">
        <div class="header">
            <img class="header-brazao" src="../img/Imagem3.png" alt="Brazao">
            <div class="header-menu">
                <a href="#" class="nome">
                    ADMINISTRADOR
                </a>
                <img class="user" src="../img/Imagem1.svg" alt="User">
            </div>
        </div>
    </header>


    <!-- Pop-up -->
    <div id="sobreposicao-popup">
        <div id="conteudo-popup">
            <h2>Sucess</h2>
            <p> tutoria excluida com sucesso! <br> recarregue a pagina </p>
            <button id="fechar-popup">Fechar</button>
        </div>
    </div>

    <!-- Script JavaScript -->
    <script>

setTimeout( function(){
            location.reload()
        },10000)
        
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

    <main class="tutor">

        <?php
        Exibir_tutores();
        ?>
    </main>
 

    <footer>
        <div class="creditos">
            <p class="projeto-info">Projeto realizado pelos alunos de Altas Habilidades da escola "EEEM Nossa Senhora"
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
            
            <div class="instagram-links">

                <div class="tecnico-sala">
                    <img src="../img/logo_sala.png" alt="Logo Sala" class="logo-sala">
                    <a href="https://www.instagram.com/2.tecnico_nsl/" target="_blank" class="link-tecnico">Técnico</a>

                </div>
                <div class="escola-insta">
                    <img src="../img/instagram.png" alt="Instagram" class="logo-instagram">
                    <a href="https://www.instagram.com/nslescola/" target="_blank" class="link-escola">Escola</a>

                </div>

            </div>
        </div>
    </footer>
</body>

</html>