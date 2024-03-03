<?php

include 'database.php';

$sistema = $_GET["sistema"];

$buscar_dado = query("SELECT * FROM status_eletiva_tutoria");

$dado = mysqli_fetch_assoc($buscar_dado);

$status = $dado[$sistema];


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gestor | Nsl</title>
    <link rel="shortcut icon" href="../img/favicon (3).ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/style_status.css">

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
    <div class="container">
        <div class="main-box">
            <h2><?php echo $sistema?></h2>
            <p>O SISTEMA ESTÁ <?php echo $status?></p> 
        
            <form action="#" method="post">
                <button onclick="refresh()" type="submit" name="ativar" class="botao">Ativar</buton>
                <button onclick="refresh()"  type="submit" name="desativar" class="botao">Desativar</buton>
            </form>
            <button class="btn" onclick="window.location.href = '../html/pag_gestor.html'" >Voltar</button>
        </div>
    </div>



    <div id="sobreposicao-popup" class="sobreposicao-popup">
        <div id="conteudo-popup" class="conteudo-popup">
            <h2>Sucesso</h2>
            <p> O sistema está  !</p>
            <p>Recarregue a pagina</p>
            <div class="buttons"> 
                <button id="fechar-popup" class="btn-sair" onclick="fecharPopup('sobreposicao-popup')">Fechar</button>
            </div>
        </div>
    </div>

    

    <script> 
       setTimeout(function() {
            location.reload()
        }, 3000)

        function mostrarPopup(id) {
            document.getElementById(id).style.display = 'block'
        }

        function fecharPopup(id) {
            document.getElementById(id).style.display = 'none' 
        }
    </script>

        <?php 
        if(isset($_POST["ativar"])){
            query("UPDATE status_eletiva_tutoria SET $sistema = 'ATIVADO'"); 
        }
        
        if(isset($_POST["desativar"])){
            query("UPDATE status_eletiva_tutoria SET $sistema = 'DESATIVADO'"); 
        }
        
        ?>

    <footer>
        <div class="creditos">
            <p class="projeto-info">Projeto realizado pelos alunos de Altas
                Habilidades da escola "EEEM Nossa Senhora de Lourdes"
            </p>
            <p class="supervisao-info">Supervisionado pelos professores Alex
                Menezes & Vânia Alves</p>

            <div class="nomes-grupos">
                <div class="back">
                    <h4>Backend<br> desenvolvido por:</h4>
                    <p class="backend-info"> Gabriel <br>Cirqueira</p>
                </div>
                <div class="vertical"></div>

                <div class="bd">
                    <h4>Banco de dados <br>desenvolvido por:</h4>
                    <p class="bd-info"> Gabriel<br> Cirqueira &<br> Matheus
                        <br>Trindade
                    </p>
                </div>
                <div class="vertical"></div>

                <div class="front">
                    <h4>Frontend <br>desenvolvido por:</h4>
                    <p class="frontend-info"> Guilherme<br> Vagmaker & <br>
                        Arthur <br> Possino</p>

                </div>
            </div>
        </div>
        <hr class="linha-horizontal">
        <div class="informacoes-escola">
        </div>
    </footer>

</body>

</html>