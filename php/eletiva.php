<?php
include 'database.php';

session_start();

$RA = $_SESSION['RA'];
$serie = $_SESSION['serie'];
$curso_tec = $_SESSION['curso'];
$nome_aluno = $_SESSION['nome'];
$turno = $_SESSION['turno'];

if($turno == "INTERMEDIÁRIO"){
    $prefixo = "INT_";
}else if ($turno == "VESPERTINO"){
    $prefixo = "VES_";
}else{
    $prefixo = "NOT_";
}

function mostarEletivas()
{
    $consulta = query("SELECT * FROM eletivas");
    global $curso_tec;
    global $prefixo;
    global $turno;
    if ($consulta->num_rows > 0) {
        foreach ($consulta as $row) {
           
            if($row["turno"] == $turno){
                if ($row["curso"] == $curso_tec) {
                    echo "
                            <div class='eletivas'> 
                                <h2>ELETIVA:</h2>  
                                <span class='nome-tutor'>" . str_replace($prefixo, "", $row["nome_eletiva"]) . " <br> </span>                     
                                <h2>Professores:</h2>  
                                <span class='nome-eletiva'>" . str_replace("_", " ", $row["professor_1"]) . " <br> </span>
                                <span class='nome-eletiva'>" . str_replace("_", " ", $row["professor_2"]) . " <br> </span>
                                <span class='nome-eletiva'>" . str_replace("_", " ", $row["professor_3"]) . " <br> </span>
                                <h2>Curso:</h2>
                                <span class='nome-eletiva'>" . str_replace("_", " ", $row["curso"]) . " <br> </span>
                                <span class='nome-eletiva'>
                                    <b>vagas:</b>
                                    " . $row["vagas"] . " 
                                </span>
                                <form action='' method='post'>
                                    <button type='submit' class='botao' name='eletivas' value='escolher-" . $row["nome_eletiva"] . "'> Escolher </button>
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

if(isset($_POST["eletivas"])) {
    $verificar_escolha = query("SELECT * FROM todas_escolhas_eletiva WHERE RA = '$RA'");
    
    if($verificar_escolha->num_rows == 0) {
        $consulta = query("SELECT * FROM eletivas");
        $botaoclicado = $_POST["eletivas"];
        
        foreach($consulta as $row) {
            if($botaoclicado == "escolher-" . $row["nome_eletiva"]) {
                if($row["vagas"] > 0) {
                    //definindo algumas variaveis
                    $vagas = $row["vagas"] - 1;
                    $nome_eletiva = $row["nome_eletiva"];
                    $nome_registro =  $row["nome_eletiva"];

                    if($turno == "INTERMEDIÁRIO"){
                        $nome_eletiva = str_replace("INT_","",$nome_registro);
                        $nome_tabela_eletiva = "eletiva_I_" . str_replace(' ','_',$nome_eletiva);

                    }elseif($turno == "VESPERTINO"){
                        $nome_eletiva = str_replace("VES_","",$nome_registro);
                        $nome_tabela_eletiva = "eletiva_V_" . str_replace(' ','_',$nome_eletiva);

                    }else{
                        $nome_eletiva = str_replace("NOT_","",$nome_registro);
                        $nome_tabela_eletiva = "eletiva_N_" . str_replace(' ','_',$nome_eletiva); 
                    }

                    //atualizar as vagas da tabela selecionada
                    $atualizar_vagas = query("UPDATE eletivas SET vagas = '$vagas' WHERE nome_eletiva = '$nome_registro'");

                    //inserir dados na tabela da eletiva
                    $inserir_tabela_eletiva = query("INSERT INTO $nome_tabela_eletiva (RA, nome_aluno, serie_aluno) VALUES ('$RA', '$nome_aluno', '$serie')");

                    //inserir dados na tabela que armazena todas as escolhas
                    $inserir_tabela_tudo = query("INSERT INTO todas_escolhas_eletiva (RA, nome_aluno, nome_eletiva, serie_aluno, curso, turno) VALUES ('$RA', '$nome_aluno', '$nome_eletiva', '$serie', '$curso_tec','$turno')");
                    
                    //verificando... se tudo deu certo irá enviar um parametro para URL e o JS captura e ebibe um popup
                    if($atualizar_vagas && $inserir_tabela_tudo && $inserir_tabela_eletiva) {
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

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 

    <link rel="stylesheet" href="../css/style.ELET.css">
    <link rel="shortcut icon" href="../img/favicon (3).ico" type="image/x-icon">

    <title>Eletiva | nsl</title>
    <style>
        a {
            color: black;
            text-decoration: none;
            font-size: 18px;
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
                <?php echo $nome_aluno . "<br>" . $serie . "<br>" . $curso_tec;   ?>
            </a>
            <img src="../img/Imagem1.svg" alt="" class="user">
        </div>
    </header>

    <h1 class="title-eletiva">eletivas do curso de <br> <?php echo "{$curso_tec} <br> Turno:  {$turno}" ;?></h1>

    <main class="eletiva-bg">
        <?php

        mostarEletivas();
         
        ?>
    </main>

    <!-- Pop-up -->
    <div id="sobreposicao-popup">
        <div id="conteudo-popup">
            <h2 style="padding:5px;">CONFIRMADO!</h2>
            <p>Você selecionou a eletiva com <br> sucesso!</p>
            <div class="botoes">
                <button id="fechar-popup"  onclick="fecharPopup('sobreposicao-popup')" >Fechar</button>
            </div>
        </div>
    </div>

    <!-- Pop-up -->
    <div id="sobreposicao-popup2">
        <div id="conteudo-popup">
            <h2 style="padding:5px;">Erro!</h2>
            <p>Ocorreu um erro ao inserir registro! <br><br> Talvez você já tenha selecionado a eletiva! <br> </p>
            <div class="botoes">
                <button id="fechar-popup2"  onclick="fecharPopup('sobreposicao-popup2')" >Fechar</button>
            </div>
        </div>
    </div>

    <!-- Pop-up -->
    <div id="sobreposicao-popup3">
        <div id="conteudo-popup">
            <h2 style="padding:5px;">Erro!</h2>
            <p>Essa eletiva atingiu o limite de vagas! <br> </p>
            <div class="botoes">
                <button id="fechar-popup3"  onclick="fecharPopup('sobreposicao-popup3')" >Fechar</button>
            </div>
        </div>
    </div>

    <script>

        setTimeout(function(){
            location.reload()
        },15000)

        const param = new URLSearchParams(window.location.search)
        const verif = param.get("status")
    
        if(verif == "true"){
            mostrarPopup('sobreposicao-popup')
            history.replaceState({},document.title,window.location.pathname)
        }
        if(verif == "notvagas"){
            mostrarPopup('sobreposicao-popup3')
            history.replaceState({},document.title,window.location.pathname)
        }
        if(verif =="jaEscolheu"){
            mostrarPopup('sobreposicao-popup2')
            history.replaceState({},document.title,window.location.pathname)
        }

         function mostrarPopup(id){
            document.getElementById(id).style.display = 'block'
        }
    
        function fecharPopup(id){
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