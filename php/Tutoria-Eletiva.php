<?php

include 'database.php';

$buscar_dado = query("SELECT * FROM status_eletiva_tutoria");

$dado = mysqli_fetch_assoc($buscar_dado);

session_start();

if (!isset($_SESSION["RA"])) {
    header("location: ../index.html");
    exit();
}

$RA = $_SESSION['RA'];
$serie = $_SESSION['serie'];
$curso_tec = $_SESSION['curso'];
$nome_aluno = $_SESSION['nome'];
$turno = $_SESSION['turno'];
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="../img/favicon (3).ico" type="image/x-icon">
    <title>Tutoria e Eletiva | Nsl</title>
    <link rel="stylesheet" href="../css/style_Tutoria_Eletiva.css">
</head>

<body>
    <header class="header-bg">
        <div class="header">
            <img class="header-brazao" src="../img/Imagem3.png" alt="Brazao">
            <div class="header-menu">
                <span href="#" class="nome">
                    <?php echo $nome_aluno . "<br>" . $serie . "<br>" . $curso_tec . "<br>" . $turno;   ?>
                    <br>
                    <button  onclick="mostrarPopup('sobreposicao-popup')">SAIR</button>

                    <br>
                </span>

                <img class="user" src="../img/Imagem1.svg" alt="User">
            </div>
        </div>
    </header>

    <main class="main-bg">
        <div class="main-caixa">
            <div class="caixas">
                <div>
                    <div class="status">
                        <h3 class="">SISTEMA DE ELETIVAS <br> <?php echo $dado["eletiva"] ?></h3>
                        <form action="" method="post">
                            <a <?php
                                if ($dado["eletiva"] == "DESATIVADO") {
                                    echo "href='#'";
                                } else {
                                    echo "href='../php/eletiva.php'";
                                }
                                ?> Class="animated-button1">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                eletiva </a>
                        </form>
                    </div>

                    <div class="status">
                        <form action="" method="post">
                            <h3 class="">SISTEMA DE TUTORIA <br> <?php echo $dado["tutoria"] ?></h3>
                            <a <?php
                                if ($dado["tutoria"] == "DESATIVADO") {
                                    echo "href='#'";
                                } else {
                                    echo "href='../php/tutoria.php'";
                                }
                                ?> Class="animated-button1">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                TUTORIA</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div id="sobreposicao-popup" class="sobreposicao-popup">
        <div id="conteudo-popup" class="conteudo-popup">
            <h2>Saida</h2><br>
            <p> Tem Certeza que deseja sair?</p><br>
            <div class="buttons">
                <button class="btn-voltar" onclick="fecharPopup('sobreposicao-popup')">voltar</button>
                <button id="fechar-popup" class="btn-sair-index" onclick="window.location.href = '../php/session.php'">Sair</button>
            </div>
        </div>
    </div>

    <script>
        setTimeout(function() {
            location.reload()
        }, 5000)

        function mostrarPopup(id) {
            document.getElementById(id).style.display = 'block'
        }

        function fecharPopup(id) {
            document.getElementById(id).style.display = 'none'
        }
    </script>

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