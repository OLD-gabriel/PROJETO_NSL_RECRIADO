<?php
include 'database.php';

session_start();

if(!isset($_SESSION["RA"])){
    header("location: ../index.html");
    exit();
}

$RA = $_SESSION['RA'];
$serie = $_SESSION['serie'];
$curso_tec = $_SESSION['curso'];
$nome_aluno = $_SESSION['nome'];
$turno = $_SESSION["turno"];

function mostarTutorias()
{

}

if (isset($_POST["tutores"])) {
    $botaoclicado = $_POST["tutores"];
    $verificar_escolha = query("SELECT * FROM todas_escolhas_tutoria WHERE RA = '$RA'");
    if ($verificar_escolha->num_rows == 0) {
        $consulta = query("SELECT * FROM tutoria");
        foreach ($consulta as $row) {
            if ($botaoclicado == "escolher-" . $row["nome_professor"] . $row["turno"]) {
                if ($row["vagas"] > 0) {

                    $nome_professor_registro = $row["nome_professor"];
                    $vagas = $row["vagas"] - 1;

                    $atualizar_vagas = query("UPDATE tutoria SET vagas = '$vagas' WHERE nome_professor = '$nome_professor_registro' AND turno = '$turno'");

                    $inserir_tabela_tudo = query("INSERT INTO todas_escolhas_tutoria (RA, nome_aluno, nome_tutoria, serie_aluno,turno) VALUES ('$RA', '$nome_aluno', '$nome_professor_registro', '$serie','$turno')");

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

$pegar_tutor = query("SELECT * FROM todas_escolhas_tutoria WHERE RA = '$RA' ");

$tutor_selecionado = mysqli_fetch_assoc($pegar_tutor);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style_tutoria.css">
    <title>Tutoria | nsl</title>

    <!-- <meta http-equiv="refresh" content="10"> -->

    <link rel="shortcut icon" href="../img/favicon (3).ico" type="image/x-icon">
</head>

<body>
    <header>
        <div class="header">
            <div class="brazao">
                <a href="#"><img src="../img/brazao.png" alt="Brazao" class="brazao"></a>
            </div>

            <div class="header-user">
                <a href="#" class="nome">
                    <?php echo $nome_aluno . "<br>" . $serie . "<br>" . $turno; ?>

                </a>
                <img src="../img/Imagem1.svg" alt="" class="user">
            </div>
        </div>
        <?php
    if (!empty($tutor_selecionado)) {
        echo "<h3 class='title-eletiva' > Você escolheu o tutor(a) {$tutor_selecionado["nome_tutoria"]} </h3>";
    } else {
        echo "<h3 class='title-eletiva'> Você ainda não escolheu seu tutor. </h3>";
    }
    ?>
    </header>
    <br>
    

    <main class="tutor">
        <?php
            global $turno;
            global $prefixo;
            $consulta = query("SELECT * FROM tutoria ORDER BY vagas DESC");
            if ($consulta->num_rows > 0) {
                foreach ($consulta as $row) {
                    if ($row["turno"] == $turno) {
                        if($row["vagas"] > 0){
                            $status_vagas = "DISPONIVEL";
                        }else{
                            $status_vagas = "INDISPONÍVEL";
                        }
                        ?>
                        <div class='tutores'  <?php if ($row["vagas"] == 0) {
                            echo "style='background-color: #b9b9b993;'";
                            } ?>>
                            <img src='../img/avatar.png' alt='' class=''>
                            <span class='nome-tutor'><?php echo $row["nome_professor"]; ?><br><br>
                            </span>

                                <b>vagas:</b><br>
                                <?php echo $status_vagas; ?>
                            <form action='' method='post'>
                            <?php
                                if ($row["vagas"] > 0) {
                                ?>
                                    <button type='submit' class='botao' name='eletivas' value='escolher-<?php echo $row["nome_eletiva"] . $row["turno"]; ?>'> Escolher </button>
                                <?php
                                } else {
                                    echo "<br><br><br><br>  ";
                                }
                                ?>
                            </form>
                        </div>
                        <?php 
                    }
                }
            } else {
                ?>  
                <div class='tutores'>
                <h1>SEM TUTORIAS!</h1> <br> 
            <span>peça algum gestor para adicionar Tutores </span>
            </div> 
                <?php 
            }
        ?>
    </main>
    <!-- Pop-up -->
    <div id="sobreposicao-popup" class="sobreposicao-popup">
        <div id="conteudo-popup" class="conteudo-popup">
            <h2 style="padding:5px;">CONFIRMADO!</h2>
            <p>Você selecionou tutor com <br> sucesso!</p>
            <div class="botoes">
                <button id="fechar-popup" class="fechar-popup" onclick="fecharPopup('sobreposicao-popup')">Fechar</button>
            </div>
        </div>
    </div>

    <!-- Pop-up -->
    <div id="sobreposicao-popup2" class="sobreposicao-popup">
        <div id="conteudo-popup" class="conteudo-popup">
            <h2 style="padding:5px;">Tutoria já escolhida!</h2> <br>
            <p>Você escolheu o Tutor(a) <?php echo $tutor_selecionado["nome_tutoria"] ?><br> </p>
            <div class="botoes">
                <button class="fechar-popup" id="fechar-popup2" onclick="fecharPopup('sobreposicao-popup2')">Fechar</button>
            </div>
        </div>
    </div>

    <!-- Pop-up -->
    <div id="sobreposicao-popup3" class="sobreposicao-popup">
        <div id="conteudo-popup" class="conteudo-popup">
            <h2 style="padding:5px;">Sem vagas!</h2>
            <p>Esse tutor atingiu o limite de vagas! <br> </p>
            <div class="botoes">
                <button class="fechar-popup" id="fechar-popup3" onclick="fecharPopup('sobreposicao-popup3')">Fechar</button>
            </div>
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

        if (verif === "true") {
            mostrarPopup('sobreposicao-popup')
            history.replaceState({}, document.title, window.location.pathname)
        }
        if (verif === "notvagas") {
            mostrarPopup('sobreposicao-popup3')
            history.replaceState({}, document.title, window.location.pathname)
        }
        if (verif === "jaEscolheu") {
            mostrarPopup('sobreposicao-popup2')
            history.replaceState({}, document.title, window.location.pathname)
        }


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