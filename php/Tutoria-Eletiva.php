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
    <link rel="stylesheet" href="../css/header-menu.css">
    <link rel="stylesheet" href="../css/style_Tutoria_Eletiva.css">
</head>

<body>
    <header class="header">

        <div class="menu">
            <i class="fas fa-bars fa-2x" style="color:gray;width:20px"></i>
        </div>

        <div class="img-tile">

            <img src="../img/brazao.png" alt="">
            <h1 class="header__title">ESCOLA NSL</h1>
            </a>

        </div>


        <div class="user">
            <img src="../img/user.png" id="icone-menu-lateral">
        </div>

    </header>
    <div class="boton-header"></div>


    <!-- MENU LATERAL -->


    <div id="area_menu_lateral" class="area_menu_lateral"></div>

    <div id="menu-lateral-icone-conteudo" class="menu-lateral-main">

        <div class="icone-menu-lateral-fechar">
            <img src="../img/close.png" alt="">
        </div>

        <div class="conteudo-menu-lateral">

            <div class="menu-lateral-main-header">

                <div>
                    <img src="../img/brazao.png" alt="BRAZÃO NSL">
                </div>

                <h2>Perfil</h2>
            </div>
            <div class="menu-lateral-main-main">
                    <h4>NOME:</h4>
                    <span><?= $_SESSION["nome"] ?></span>
                    <hr>
                    <h4>RA:</h4>
                    <span><?= $_SESSION["RA"] ?></span>
                    <hr>
                    <h4>TURMA:</h4>
                    <span><?= $_SESSION["serie"] ?></span>
                    <hr>
                    <br>

                <br>
                <a href="session.php">Sair</a>

            </div>

            <div class="menu-lateral-main-footer">
                <a href="http://wa.me/+5527996121313" target="_blank" >Gabriel Cirqueira</a>
                <img src="../img/coding.png" alt="">
            </div>
        </div>

    </div>


    <main class="main-bg">
        <br>
        <br>
        <br>
        <center>
        <h3> <span> NSL - SISTEMA DE ELETIVAS E TUTORIA</span></h3><br><br>

        </center>
        <a <?php
            if ($dado["eletiva"] == "DESATIVADO") {
                echo "href='#'";
            } else {
                echo "href='../php/eletiva.php'";
            }
            ?> Class="button-ir-pag">
            <img src="../img/light-bulb.png" alt="">
            <br>
            <h3>ELETIVA</h3>
            <br>
            <span class="">SISTEMA <?php echo $dado["eletiva"] ?></> 
        </a>
        <a  href='#' Class="button-ir-pag">

            <img src="../img/conversation.png" alt="">
            <br>
            <h3>TUTORIA</h3>
            <br>
            <span class="">SISTEMA DESATIVADO</span>
 </a>
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

        const menuBtn = document.getElementById("icone-menu-lateral")
        const menu = document.getElementById("area_menu_lateral")
        const menu_conteudo = document.getElementById("menu-lateral-icone-conteudo")
        const icone_fechar_menu = document.querySelector(".icone-menu-lateral-fechar")

        function fecharMenu() {
            menu.style.display = "none"
            menu.style.backgroundColor = "rgba(0, 0, 0, 0)"
            menu_conteudo.style.right = '-320px'
            localStorage.setItem('menuAberto', 'false')
        }

        function abrirMenu() {
            menu.style.display = "block"
            menu.style.backgroundColor = "rgba(0, 0, 0, 0.507)"
            menu_conteudo.style.right = '0px'
            localStorage.setItem('menuAberto', 'true')
        }

        icone_fechar_menu.addEventListener('click', fecharMenu)

        menuBtn.addEventListener('click', abrirMenu)

        document.addEventListener('DOMContentLoaded', (event) => {
            const menuAberto = localStorage.getItem('menuAberto') === 'true';
            if (menuAberto) {
                abrirMenu();
            }
        });
    </script>

    <footer>
    <br>
        <div class="creditos">
            <p class="projeto-info">Projeto realizado pelos alunos de Altas Habilidades da escola "EEEM Nossa Senhora de Lourdes"
            </p>
            </div>
        <br>
    </footer>

</body>

</html>