<?php
include 'database.php';

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

function mostarEletivas()
{
}

if (isset($_POST["eletivas"])) {
    $verificar_escolha = query("SELECT * FROM todas_escolhas_eletiva WHERE RA = '$RA'");

    if ($verificar_escolha->num_rows == 0) {
        $consulta = query("SELECT * FROM eletivas");
        $botaoclicado = $_POST["eletivas"];

        foreach ($consulta as $row) {
            if ($botaoclicado == "escolher-" . $row["nome_eletiva"] . $row["turno"]) {
                if ($row["vagas"] > 0) {
                    //definindo algumas variaveis
                    $nome_eletiva = $row["nome_eletiva"];

                    $vagas = $row["vagas"] - 1;

                    $atualizar_vagas = query("UPDATE eletivas SET vagas = '$vagas' WHERE nome_eletiva = '$nome_eletiva' AND turno = '$turno'");

                    $inserir_tabela_tudo = query("INSERT INTO todas_escolhas_eletiva (RA, nome_aluno, nome_eletiva, serie_aluno, curso, turno) VALUES ('$RA', '$nome_aluno', '$nome_eletiva', '$serie', '$curso_tec','$turno')");

                    if ($atualizar_vagas && $inserir_tabela_tudo) {
                        header("location: ?status=true");
                    }
                } else {
                    header("location: ?status=notvagas");
                }
            }
        }
    } else {
        header("location: ?status=jaEscolheu");
    }
}
$pegar_eletiva = query("SELECT * FROM todas_escolhas_eletiva WHERE RA = '$RA' ");

$eletiva_selecionado = mysqli_fetch_assoc($pegar_eletiva);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../css/header-menu.css">
    <link rel="stylesheet" href="../css/style_eletiva.css">
    <link rel="shortcut icon" href="../img/favicon (3).ico" type="image/x-icon">
    <title>Eletiva | nsl</title>
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


    <?php
        if (!empty($eletiva_selecionado)) {
            echo "<h3 class='title-eletiva'  > VOCÊ ESCOLHEU A ELETIVA: <br> {$eletiva_selecionado["nome_eletiva"]} </h3>";
        } else {
            echo "<h3 class='title-eletiva' > VOCÊ AINDA NÃO ESCOLHEU SUA ELETIVA. </h3>";
        }
        ?>
    <main class="eletiva-bg">
        <?php
        $consulta = query("SELECT * FROM eletivas ORDER BY vagas DESC");
        if ($consulta->num_rows > 0) {
            foreach ($consulta as $row) {

                if ($row["turno"] == $turno) { 
                    // STRPOS função para verificar se uam determinada palvra está em uma frase ou string
                    if (strpos($row["turmas"], $serie) !== false || $row["turmas"] == $serie) { 
                        if ($row["vagas"] > 0) {
                            $status_vagas = "HÁ VAGAS";
                        } else {
                            $status_vagas = "VAGAS ESGOTADAS";
                        }
        ?>
                        <div class='eletivas' <?php if ($row["vagas"] == 0) {

                                                    echo "style='background-color: #b9b9b993; box-shadow: none;'";
                                                } ?>>
                            <h2>ELETIVA:</h2>
                            <span class='nome-tutor'><?php echo $row["nome_eletiva"]; ?><br></span>
                            <h2>Professores:</h2>
                            <span class='nome-eletiva'><?php echo $row["professor_1"]; ?><br></span>
                            <span class='nome-eletiva'><?php echo $row["professor_2"]; ?><br></span>
                            <span class='nome-eletiva'><?php echo $row["professor_3"]; ?><br></span>
                            <span class='nome-eletiva'>
                                <b></b>
                                <?php echo $status_vagas; ?>
                            </span>
                            <form action='' method='post'>
                                <?php
                                if ($row["vagas"] > 0) {
                                ?>
                                    <button type='submit' class='botao' name='eletivas' value='escolher-<?php echo $row["nome_eletiva"] . $row["turno"]; ?>'> Escolher </button>
                                <?php
                                } else {
                                    echo "<br><br><br>";
                                }
                                ?>

                            </form>
                        </div>
            <?php
                    }
                }
            }
        } else {
            ?>
            <div class='nada'>
                <h1>SEM ELETIVAS!</h1> <br>
                <span>peça algum gestor para adicionar Eletivas </span>
            </div>
        <?php
        }
        ?>
    </main>

    <!-- Pop-up -->
    <div id="sobreposicao-popup" class="sobreposicao-popup">
        <div id="conteudo-popup" class="conteudo-popup">
            <h2 style="padding:5px;">CONFIRMADO!</h2>
            <p>Você selecionou a eletiva com sucesso!</p>
            <div class="botoes">
                <button id="fechar-popup" class="fechar-popup" onclick="fecharPopup('sobreposicao-popup')">Fechar</button>
            </div>
        </div>
    </div>

    <!-- Pop-up -->
    <div id="sobreposicao-popup2" class="sobreposicao-popup">
        <div id="conteudo-popup2" class="conteudo-popup">
            <h2 style="padding:5px;">Eletiva já escolhida!</h2> <br>
            <p>Você escolheu a eletiva <br> <?php echo $eletiva_selecionado["nome_eletiva"] ?><br> </p>
            <div class="botoes">
                <button id="fechar-popup2" class="fechar-popup" onclick="fecharPopup('sobreposicao-popup2')">Fechar</button>
            </div>
        </div>
    </div>

    <!-- Pop-up -->
    <div id="sobreposicao-popup3" class="sobreposicao-popup">
        <div id="conteudo-popup3" class="conteudo-popup">
            <h2 style="padding:5px;">Sem Vagas!</h2>
            <p>Essa eletiva atingiu o limite de vagas! <br> </p>
            <button id="fechar-popup3" class="fechar-popup" onclick="fecharPopup('sobreposicao-popup3')">Fechar</button>
        </div>
    </div>
    <center>
        <button class="botao" onclick="window.location.href = 'Tutoria-Eletiva.php' ">Voltar</button>
    </center>
    <script>
        setTimeout(function() {
            location.reload()
        }, 15000)

        const param = new URLSearchParams(window.location.search)
        const verif = param.get("status")

        if (verif == "true") {
            mostrarPopup('sobreposicao-popup')
            history.replaceState({}, document.title, window.location.pathname)
        }
        if (verif == "notvagas") {
            mostrarPopup('sobreposicao-popup3')
            history.replaceState({}, document.title, window.location.pathname)
        }
        if (verif == "jaEscolheu") {
            mostrarPopup('sobreposicao-popup2')
            history.replaceState({}, document.title, window.location.pathname)
        }

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
            <p class="projeto-info">Projeto realizado pelos alunos de Altas Habilidades da escola "EEEM Nossa Senhora de
                Lourdes"
            </p>
          
    </footer>
</body>

</html>