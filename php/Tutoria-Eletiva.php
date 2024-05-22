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
    <img src="../img/user.png"  id="icone-menu-lateral" > 
</div>

</header>
<div class="boton-header"></div>


  <!-- MENU LATERAL -->


  <div id="area_menu_lateral" class="area_menu_lateral"></div>

  <div id="menu-lateral-icone-conteudo" class="menu-lateral-main">

    <div class="icone-menu-lateral-fechar">
      <i class="fas fa-times fa-2x" style="color: gray;"></i>
    </div>

    <div class="conteudo-menu-lateral">

      <div class="menu-lateral-main-header">

        <div>
          <img src="public/assents/img/imagem3.png" alt="BRAZÃO NSL">
        </div>

        <h2>Perfil</h2>
      </div>
      <div class="menu-lateral-main-main">
        <?php if ($user == "ALUNO") { ?>
          <h4>NOME:</h4>
          <span><?= $_SESSION["nome_aluno"] ?></span>
          <hr>
          <h4>RA:</h4>
          <span><?= $_SESSION["ra"] ?></span>
          <hr>
          <h4>TURMA:</h4>
          <span><?= $_SESSION["turma"] ?></span>
          <hr>
          <br>

        <?php } else if ($user == "PROFESSOR") { ?>
          <h4>NOME:</h4>
          <span><?= $_SESSION["nome_professor"] ?></span>
          <hr>
          <h4>DISCIPLINA(S):</h4>
          <span>
            <?php 
            
            if(strpos($_SESSION["disciplinas"],";")){
              $materias = explode(";",$_SESSION["disciplinas"]);
              foreach ($materias as $materia) { ?>
              <span><?= $materia ?> <br> </span>
              <?php }}else{?>
                <span><?= $_SESSION["disciplinas"] ?></span>
              <?php }?>
          </span>
          <hr>
        <?php } else if ($user == "GESTOR") { ?>


        <?php } ?>
        <br>
        <a href="encerrar_sessao" >Sair</a>

      </div>

      <div class="menu-lateral-main-footer">
        Gabriel Cirqueira $)
      </div>
    </div>

  </div>


    <main class="main-bg">
        <div class="main-caixa">
            <div class="caixas">
                <div>
                    <div class="status">
                        <h3 class="">SISTEMA <?php echo $dado["eletiva"] ?></h3>
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
                            <h3 class="">SISTEMA <?php echo $dado["tutoria"] ?></h3>
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
