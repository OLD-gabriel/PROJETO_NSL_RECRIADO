<?php
include 'database.php';

session_start();

$tutor = $_SESSION["tutor"];
$turno = $_SESSION["turno"];

$consulta = query("SELECT * FROM todas_escolhas_tutoria WHERE nome_tutoria = '$tutor' AND turno = '$turno' ");


if(isset($_POST["excluir-registro"])){
    $ra = $_POST["excluir-registro"];

    $deletar_tabela_todos = query(" DELETE FROM todas_escolhas_tutoria WHERE RA = '$ra'");

    $atualizar_vagas = query("UPDATE tutoria SET vagas = vagas + 1 WHERE nome_professor = '$tutor' AND turno = '$turno' ");
    header("location: tutorandos.php");
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gestor | Nsl</title>
    <link rel="shortcut icon" href="../img/favicon (3).ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/style-GST.css">
    <link rel="stylesheet" href="../css/style-tabela.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;800&display=swap" rel="stylesheet">
    <style>
    td {
        padding: 2px 1.5vw;
    }
    </style>
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

    <br><br><br>

    <main class="main">
        <div class="alunos">
            <h1>Tutorando de
                <?php echo $tutor ?>
            </h1>
            <h3>
                Turno: <br> <?php echo $turno ?>
            </h3>

            <h2>Alunos</h2>

            <?php

            echo "<table class='teste'>";
            echo "<tr><th>Nome do Aluno</th><th>Série</th><th>RA</th></tr>";
            $vagas = 0;
            // Loop através dos resultados e exiba cada linha na tabela
           foreach($consulta as $row) {
                echo "<tr><td>" . $row["nome_aluno"] . "</td><td>" . $row["serie_aluno"] . "</td><td>" . $row["RA"] . "</td><td>" . "<form method='post'> <button type='submit' class='excluir-registro' name='excluir-registro' value='" . $row["RA"] . "  ' >Excluir</button> </form> " . "</td></tr>";
                echo "<tr><td colspan='4'><hr></td></tr>";
            }

            echo "</table>";
            ?>

            <button class="export" onclick="exportToExcel()">Exportar para Excel</button>
        </div>

        <!-- Pop-up -->
        <div id="sobreposicao-popup">
            <div id="conteudo-popup">
                <h2>Sucess</h2>
                <p> aluno excluido com sucesso! <br> recarregue a pagina </p>
                <button id="fechar-popup">Fechar</button>
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

        function exportToExcel() {

            var table = XLSX.utils.table_to_sheet(document.querySelector('table'));

            var wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, table, 'Dados');

            XLSX.writeFile(wb, 'dados_alunos.xlsx');
        }
        </script>
    </main>
 
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