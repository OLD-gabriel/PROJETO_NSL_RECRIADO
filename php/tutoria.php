<?php
include 'database.php';

session_start();

$RA = $_SESSION['RA'];
$serie = $_SESSION['serie'];
$curso_tec = $_SESSION['curso'];
$nome_aluno = $_SESSION['nome'];
$turno = $_SESSION["turno"];

function mostarTutorias(){
    global $turno;
    global $prefixo;
    $consulta = query("SELECT * FROM tutoria");
    if ($consulta->num_rows > 0) {
        foreach ($consulta as $row) {
            if($row["turno"] == $turno){
                echo "
                <div class='tutores'>
                    <img src='../img/avatar.png' alt='' class=''>
                    <span class='nome-tutor'>" . $row["nome_professor"]  . "<br>
                        vagas:
                        " . $row["vagas"] . "
                    </span>
                    <form action='' method='post'>
                        <button type='submit' class='botao' name='tutores' value='escolher-" . $row["nome_professor"].$row["turno"] . "' >Escolher</button>
                    </form>
                </div>
            ";
            }
        }
    }    else {
        echo "  
        <div class='tutores'>
        <h1>SEM TUTORIAS!</h1> <br> 
    <span>peça algum gestor para adicionar Tutores </span>
    </div> 
        ";
    }
}

if (isset($_POST["tutores"])) {
    $botaoclicado = $_POST["tutores"];
    $verificar_escolha = query("SELECT * FROM todas_escolhas_tutoria WHERE RA = '$RA'");
    if ($verificar_escolha->num_rows == 0) {
        $consulta = query("SELECT * FROM tutoria");
        foreach ($consulta as $row) {
            if ($botaoclicado == "escolher-" . $row["nome_professor"].$row["turno"]) {
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
    <link rel="stylesheet" href="../css/style.TUT.css">
    <title>Escolha Tutoria</title>

    <!-- <meta http-equiv="refresh" content="10"> -->

    <link rel="shortcut icon" href="../img/favicon (3).ico" type="image/x-icon">
    <style>
        .title-eletiva{
  background-color: #ffffff82;
  width: 400px;
  padding: 12px;
  border-radius: 10px;
  text-align: center;
  margin: 0 auto;
  box-shadow: 3px 3px 6px rgba(0, 0, 0, 0.226);
}

        body {
            margin: 0px;
            padding: 0px;
        }

        footer {
            margin-top: 130px;
            padding: 10px;
            background-color: #161616;
            text-align: center;
            color: white;
        }


        .nomes-grupos {
            display: flex;
            justify-content: center;
            margin-top: 16px;
        }

        .vertical {
            height: 200px;
            border-left: 2px solid;
        }

        .back {
            width: 200px;

        }

        .front {
            width: 200px;

        }

        .bd {
            width: 200px;

        }

        .creditos {
            margin-bottom: 10px;
        }

        .creditos p {
            margin-bottom: 1px;
        }

        .informacoes-escola p {
            margin-bottom: 7px;
        }

        .instagram-links {
            display: flex;
            margin: 0 auto;
            width: 190px;

        }

        .tecnico-sala {
            display: flex;
            flex-direction: row;
            align-items: center;
            text-align: center;
            width: 100px;

        }

        .escola-insta {
            display: flex;
            flex-direction: row;
            align-items: center;
            text-align: center;
            width: 90px;

        }

        .informacoes-escola img {
            width: 20px;
            margin: 0 5px;
        }

        .informacoes-escola a {
            text-decoration: none;
            color: #919191;
            margin: 0 5px;
        }

        .linha-horizontal {
            border: 1px solid #ccc;
            margin: 10px 0;
        }

        a {
            color: black;
            text-decoration: none;
            font-size: 16px;
            text-align: justify;
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="brazao">
            <a href="../Tutoria-Eletiva.html"><img src="../img/brazao.png" alt="Brazao" class="brazao"></a>
        </div>

        <div class="header-user">
            <a href="#" class="nome">
                <?php echo $nome_aluno . "<br>" . $serie . "<br>" . $turno ; ?>

            </a>
            <img src="../img/Imagem1.svg" alt="" class="user">
        </div>
    </header>
    <h3 class="title-eletiva">TUTORIAS do TURNO: <?php echo " {$turno}" ;?></h3>
<br>
    <?php 
        if(!empty($tutor_selecionado)){
            echo "<h3 class='title-eletiva' > Você escolheu o tutor {$tutor_selecionado["nome_tutoria"]} </h3>" ;
        }else{
            echo "<h3 class='title-eletiva'> Você ainda não escolheu seu tutor. </h3>" ;
        }
    ?>

    <main class="tutor">
        <?php
        mostarTutorias();
        ?>
    </main>
    <!-- Pop-up -->
    <div id="sobreposicao-popup">
        <div id="conteudo-popup">
            <h2 style="padding:5px;">CONFIRMADO!</h2>
            <p>Você selecionou tutor com <br> sucesso!</p>
            <div class="botoes">
                <button id="fechar-popup" onclick="fecharPopup('sobreposicao-popup')">Fechar</button>
            </div>
        </div>
    </div>

    <!-- Pop-up -->
    <div id="sobreposicao-popup2">
        <div id="conteudo-popup">
        <h2 style="padding:5px;">Tutoria já escolhida!</h2> <br>
            <p>Você escolheu o Tutor <?php echo $tutor_selecionado["nome_tutoria"] ?><br> </p>
            <div class="botoes">
                <button id="fechar-popup2" onclick="fecharPopup('sobreposicao-popup2')">Fechar</button>
            </div>
        </div>
    </div>

    <!-- Pop-up -->
    <div id="sobreposicao-popup3">
        <div id="conteudo-popup">
            <h2 style="padding:5px;">Sem vagas!</h2>
            <p>Esse tutor atingiu o limite de vagas! <br> </p>
            <div class="botoes">
                <button id="fechar-popup3" onclick="fecharPopup('sobreposicao-popup3')">Fechar</button>
            </div>
        </div>
    </div>

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