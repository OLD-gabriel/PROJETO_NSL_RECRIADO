 <?php
    include 'database.php';


    if (isset($_POST["enviar"])) {

        $sql =  query("DELETE FROM todas_escolhas_eletiva");

        if ($sql) {
            echo "<Script> fecharPopup() </script>";
            echo "<Script> mostrarPopup2() </script>";
        }
    }
    ?>
 <!DOCTYPE html>
 <html lang="pt-br">

 <head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">


     <title>Escolhas Eletivas | Nsl</title>
     <link rel="shortcut icon" href="../img/favicon (3).ico" type="image/x-icon">
     <link rel="stylesheet" href="../css/style_EscolhasEletivas.css">
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

             <form method="post">
                 <h1>Selecione o turno</h1><br>
                 <select name="turno" id="turno" required>
                     <option value="INTERMEDIÁRIO">INTERMEDIÁRIO</option>
                     <option value="VESPERTINO">VESPERTINO</option>
                     <option value="NOTURNO">NOTURNO</option>
                 </select>
                 <input type="submit" name="enviar-turno" class="btn-submit">
             </form>

             <?php
                if (isset($_POST["enviar-turno"])) {
                    $turno = $_POST["turno"];
                    $consulta = query("SELECT * FROM todas_escolhas_eletiva WHERE turno = '$turno'");
                    if ($consulta->num_rows > 0) {
                        echo "<h1>Todas as escolhas</h1><h2>Eletivas e Alunos<br> Turno: " . $turno . "</h2>";
                        echo "<table class='teste'>";
                        echo "<tr><th>Nome da Eletiva</th><th>Nome do Aluno</th><th>Série</th><th>RA</th><th>Curso</th></tr>";

                        foreach ($consulta as $row) {
                            echo "<tr>";
                            echo "<td>" . str_replace("_", " ", $row["nome_eletiva"])  . "</td>";
                            echo "<td>" . $row["nome_aluno"] . "</td>";
                            echo "<td>" . $row["serie_aluno"] . "</td>";
                            echo "<td>" . $row["RA"] . "</td>";
                            echo "<td>" . $row["curso"] . "</td>";
                            echo "</tr>";
                            echo "<tr><td colspan='5'><hr></td></tr>";
                        }
                        echo "</table>";

                        echo "<button class='export' onclick='exportToExcel()'>Exportar para Excel</button>";
                    } else {
                        echo "<h1>SEM DADOS</h1>";
                    }
                }
                ?>
         </div>
         <center>
             <br><br>
             <a href="../html/pag_gestor.html" class="btn-submit">Voltar</a>
         </center>

         <!-- Script JavaScript -->
         <script>
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