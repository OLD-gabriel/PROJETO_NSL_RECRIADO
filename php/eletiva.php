<?php
include 'database.php';

session_start();

$RA = $_SESSION['RA'];
$serie = $_SESSION['serie'];
$curso_tec = $_SESSION['curso'];
$nome_aluno = $_SESSION['nome'];
$turno = $_SESSION['turno'];

function mostarEletivas()
{
    $consulta = query("SELECT * FROM eletivas");
    global $curso_tec;
    global $prefixo;
    global $turno;
    if ($consulta->num_rows > 0) {
        foreach ($consulta as $row) {

            if ($row["turno"] == $turno) {
                // STRPOS função para verificar se uam determinada palvra está em uma frase ou string
                if (strpos($row["curso"], $curso_tec) || $row["curso"] == $curso_tec) {
                    echo "
                            <div class='eletivas'> 
                                <h2>ELETIVA:</h2>  
                                <span class='nome-tutor'>" .    $row["nome_eletiva"] . " <br> </span>                     
                                <h2>Professores:</h2>             <span class='nome-eletiva'>" . $row["professor_1"] . " <br> </span>
                                <span class='nome-eletiva'>" . $row["professor_2"] . " <br> </span>
                                <span class='nome-eletiva'>" . $row["professor_3"] . " <br> </span>
                               
                                <span class='nome-eletiva'>
                                    <b>vagas:</b>
                                    " . $row["vagas"] . " 
                                </span>
                                <form action='' method='post'>
                                    <button type='submit' class='botao' name='eletivas' value='escolher-" . $row["nome_eletiva"] . $row["turno"] . "'> Escolher </button>
                                </form>
                            </div>";
                }
            }
        }
    } else {
        echo "  
    <div class='nada'>
    <h1>SEM ELETIVAS!</h1> <br> 
<span>peça algum gestor para adicionar Eletivas </span>
</div> 
    ";
    }
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

    <link rel="stylesheet" href="../css/style_eletiva.css">
    <link rel="shortcut icon" href="../img/favicon (3).ico" type="image/x-icon">

    <title>Eletiva | nsl</title>

</head>

<body>
    <header>
        <div class="header">
            <div class="brazao">
                <a href="../Tutoria-Eletiva.html"><img src="../img/brazao.png" alt="Brazao" class="brazao"></a>
            </div>

            <div class="header-user">
                <a href="#" class="nome">
                    <?php echo $nome_aluno . "<br>" . $serie . "<br>" . $curso_tec . "<br>" . $turno;   ?>
                </a>
                <img src="../img/Imagem1.svg" alt="" class="user">
            </div>
        </div>

        <?php
        if (!empty($eletiva_selecionado)) {
            echo "<h3 class='title-eletiva'  > Você escolheu a eletiva <br> {$eletiva_selecionado["nome_eletiva"]} </h3>";
        } else {
            echo "<h3 class='title-eletiva' > Você ainda não escolheu sua eletiva. </h3>";
        }
        ?>
    </header>


    <main class="eletiva-bg">
        <?php

        mostarEletivas();

        ?>
    </main>

    <!-- Pop-up -->
    <div id="sobreposicao-popup" class="sobreposicao-popup">
        <div id="conteudo-popup" class="conteudo-popup">
            <h2 style="padding:5px;">CONFIRMADO!</h2>
            <p>Você selecionou a eletiva com <br> sucesso!</p>
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
        <button class="botao" onclick="window.location.href = '../html/Tutoria-Eletiva.html' ">Voltar</button>
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