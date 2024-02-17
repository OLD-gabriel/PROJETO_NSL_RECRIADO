<?php
include "database.php";

function Exibir_eletivas()
{

    $consulta = query("SELECT * FROM eletivas ORDER BY turno ASC ");
    if ($consulta->num_rows > 0) {
        foreach ($consulta as $row) {
            echo "                                                  
            <div class='eletivas'> 
            <h2>ELETIVA:</h2>  
            <span class='nome-tutor'>" . str_replace($row["turno"] . "_","",$row["nome_eletiva"])  . " <br> </span>                     
            <h2>Professores:</h2>  
            <span class='nome-eletiva'>" . str_replace("_", " ", $row["professor_1"]) . "  </span>
            <span class='nome-eletiva'>" . str_replace("_", " ", $row["professor_2"]) . "  </span>
            <span class='nome-eletiva'>" . str_replace("_", " ", $row["professor_3"]) . "  </span>
            <h2>Turno da eletiva:</h2>  
            <span class='nome-eletiva'>" . str_replace("_", " ", $row["turno"]) . "  </span>
            <span class'nome-eletiva'>
            <b>vagas:</b>
            " . $row["vagas"] . "
            </span>
            <form action='' method='post'>
                <button type='submit' class='botao' name='eletiva' value='escolher-" . $row["nome_eletiva"] . "' > Ver alunos   </button> 
            </form> 
            <form action='' method='post'>
                <button type='submit' class='botao-excluir' name='excluir' value='excluir-" . $row["nome_eletiva"] . "'>Excluir</button> 
            </form> 
    
                    </div>";
        }
    } else {
        echo "  
    <div class='eletivas'>
    <h1>SEM ELETIVAS!</h1> <br> 
<span> Adicione Eletivas<a href='../html/add-eletiva.html'> Aqui </a> </span>
</div> 
    ";
    }
}

if (isset($_POST["excluir"])) {
    $consulta = query("SELECT * FROM eletivas");
    $botaoclicado = $_POST["excluir"];
    foreach ($consulta as $row) {
        if ($botaoclicado == "excluir-" . $row["nome_eletiva"]) {

            if($row["turno"] == "INTEGRAL"){
                $nome_eletiva = str_replace("INTEGRAL_","",$row["nome_eletiva"]);
                $nome_tabela_eletiva = "eletiva_I_" . str_replace(' ','_',$nome_eletiva);
            }else if($row["turno"] == "TARDE"){
                $nome_eletiva = str_replace("TARDE_","",$row["nome_eletiva"]);
                $nome_tabela_eletiva = "eletiva_T_" . str_replace(' ','_',$nome_eletiva);
            }else{
                $nome_eletiva = str_replace("NOTURNO_","",$row["nome_eletiva"]);
                $nome_tabela_eletiva = "eletiva_N_" . str_replace(' ','_',$nome_eletiva);
            }

            $nome_registro_eletiva = $row["nome_eletiva"]; 

            $apagar_registro = query("DELETE FROM eletivas where nome_eletiva = '$nome_registro_eletiva'");
            
            $apagar_tabela = query("DROP TABLE " . $nome_tabela_eletiva);

            if ($apagar_registro && $apagar_tabela) {
                echo "<script>mostrarPopup()</script>";
            }
        }
    }
 }

if(isset($_POST["eletiva"])){
    $consulta = query("SELECT * FROM eletivas");
    $botaoclicado = $_POST["eletiva"];
    foreach($consulta as $row){
        if($botaoclicado == "escolher-" . $row["nome_eletiva"]){
            if($row["turno"] == "INTEGRAL"){
                $prefixo_tabela = "eletiva_I_";
                $prefixo = "INTEGRAL_";
            }else if ($row["turno"] == "TARDE"){
                $prefixo_tabela = "eletiva_T_";
                $prefixo = "TARDE_";
            }else{
                $prefixo_tabela = "eletiva_N_";
                $prefixo = "NOTURNO_";
            }
            session_start();
            $_SESSION["eletiva"] = $prefixo_tabela . str_replace($prefixo,"",$row["nome_eletiva"]);
            $_SESSION["prefixo_tabela"] = $prefixo_tabela;
            $_SESSION["prefixo"] = $prefixo;
            header("location: eletivandos.php");
        }
    }

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gestor | Nsl</title>
    <link rel="shortcut icon" href="../img/favicon (3).ico" type="image/x-icon">

    <link rel="stylesheet" href="../css/style.ELET.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;800&display=swap" rel="stylesheet">
</head>

<body>
    <!-- Pop-up -->
    <div id='sobreposicao-popup'>
        <div id='conteudo-popup'>
            <h2>Sucess</h2>
            <p> Eletiva Excluida com <br> sucesso!</p>
            <button id='fechar-popup'>Fechar</button>
        </div>
    </div>

    <!-- Script JavaScript -->
    <script>
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


    <header class="header">
        <div class="brazao">
            <a href="../Tutoria-Eletiva.html"><img src="../img/brazao.png" alt="Brazao" class="brazao"></a>
        </div>

        <div class="header-user">
            <a href="#" class="nome">
                ADMINISTRADOR
            </a>
            <img src="../img/Imagem1.svg" alt="" class="user">
        </div>
    </header>

    <main class="eletiva-bg">
        <?php
        Exibir_eletivas();
        ?>
    </main>

    <?php
  
    ?>

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