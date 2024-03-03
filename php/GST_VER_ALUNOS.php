<?php
include 'database.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alunos | Nsl</title>
    <link rel="shortcut icon" href="../img/favicon (3).ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/style_VerAlunos.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
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

    <main class="main">
        <div class="alunos">
            <h1>Selecione</h1>
            <form class="formulario" action="" method="post">

                <label for="turno">Selecione o turno do aluno:</label>
                <select name="turno" id="turno" required>
                    <option value="INTERMEDIÁRIO">INTERMEDIÁRIO</option>
                    <option value="VESPERTINO">VESPERTINO</option>
                    <option value="NOTURNO">NOTURNO</option>
                </select>

                <label for="curso">Selecione o curso do aluno:</label>
                <select name="cursos" id="curso" required>
                    <option value="INFORMÁTICA">INFORMÁTICA</option>
                    <option value="ADMINISTRAÇÃO">ADMINISTRAÇÃO</option>
                    <option value="HUMANIDADES">HUMANIDADES</option>
                    <option value="EJA">EJA</option>
                </select>


                <button type="submit" class="botao" name="enviar">Enviar</button>
            </form>

            <!-- Pop-up -->
            <div id="sobreposicao-popup" class="sobreposicao-popup">
                <div id="conteudo-popup" class="conteudo-popup">
                    <h2>Sucess</h2>
                    <p> aluno excluido com sucesso! <br> recarregue a pagina </p>
                    <button class="fechar-popup" id="fechar-popup">Fechar</button>
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

            <?php
            if (isset($_POST["enviar"])) {
                $curso = $_POST["cursos"];
                $turno = $_POST["turno"];
                $consulta = query("SELECT ra, nome_aluno,serie_aluno FROM alunos WHERE curso_aluno = '$curso' AND  turno = '$turno' ORDER BY serie_aluno ASC");
                echo "<table class='teste'>";
                echo "<h2> Alunos  do curso de " . $curso .  " <br> do turno " . $turno . " </h2><br><br>";
                echo "<tr><th>Nome do Aluno</th><th>Série</th><th>RA</th></tr> ";
                foreach ($consulta as $row) {
                    echo "<tr>";
                    echo "<td>" .   $row["nome_aluno"] . "</td>";
                    echo "<td>" . $row["serie_aluno"] . "</td>";
                    echo "<td>" . $row["ra"] . "</td>";
                    echo "<td>" . "<form method='post'> <button type='submit' class='excluir-registro' name='excluir-registro' value='" . $row["ra"] . "  ' >Excluir</button> </form> " . "</td>";
                    echo "</tr>";
                    echo "<tr><td colspan='4'><hr></td></tr>";
                }
                echo "</table>";
                echo "  <button class='export' onclick='exportToExcel()' >Exportar para Excel</button>";
            }

            if (isset($_POST["excluir-registro"])) {
                $ra = $_POST["excluir-registro"];
                $deletar_registro = query("DELETE FROM alunos WHERE ra = $ra");
                if ($deletar_registro) {
                    echo "<script>mostrarPopup()</script>";
                }
            }
            ?>
        </div>
    </main>
    <center>
        <br><br>
        <a href="../html/pag_gestor.html" class="btn-submit">Voltar</a>
    </center>
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