<?php
include 'database.php';

session_start();
$eletiva = $_SESSION["eletiva"];
$turno = $_SESSION["turno"];

$consulta = query("SELECT * FROM todas_escolhas_eletiva WHERE nome_eletiva = '$eletiva' AND turno = '$turno' ");

if (isset($_POST["excluir-registro"])) {
    $ra = $_POST["excluir-registro"];

    $deletar_tabela_todos = query(" DELETE FROM todas_escolhas_eletiva WHERE RA = '$ra'");

    $atualizar_vagas = query("UPDATE eletivas SET vagas = vagas + 1 WHERE nome_eletiva = '$eletiva' AND turno = '$turno'");

    header("location: eletivandos.php");
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Eletiva Alunos | Nsl</title>
    <link rel="shortcut icon" href="../img/favicon (3).ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/style_eletivandos.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;800&display=swap" rel="stylesheet">
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
            <h1>Alunos da eletiva <br>
                <?php echo $eletiva ?>
            </h1>
            <h3>
                Turno: <br> <?php echo $turno ?>
            </h3>

            <h2>Alunos</h2>

            <?php
            echo "<table class='teste'>";
            echo "<tr><th>Nome do Aluno</th><th>Série</th><th>RA</th></tr>";

            // Loop através dos resultados e exiba cada linha na tabela

            foreach ($consulta as $row) {
                echo "<tr>";

                echo "<td>" .   $row["nome_aluno"] . "</td>";
                echo "<td>" . $row["serie_aluno"] . "</td>";
                echo "<td>" . $row["RA"] . "</td>";
                echo "<td>" . "<form method='post'> <button type='submit' class='excluir-registro' name='excluir-registro' value='" . $row["RA"] . "  ' >Excluir</button> </form> " . "</td>";
                echo "</tr>";
                echo "<tr><td colspan='4'><hr></td></tr>"; // Adicione uma linha horizontal após cada linha de dados
            }

            echo "</table>";
            ?>

            <button class="export" onclick="exportToExcel()">Exportar para Excel</button>
        </div>
    </main>
    <center>
        <br><br>
        <a href="GST_ELT.php" class="btn-submit">Voltar</a>
    </center>
    <script>
        function exportToExcel() {

            var table = XLSX.utils.table_to_sheet(document.querySelector('table'));

            var wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, table, 'Dados');

            XLSX.writeFile(wb, 'dados_alunos.xlsx');
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