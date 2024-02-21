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


     <title>Gestor | Nsl</title>
     <link rel="shortcut icon" href="../img/favicon (3).ico" type="image/x-icon">
     <link rel="stylesheet" href="../css/style-GST.css">
     <link rel="stylesheet" href="../css/style-tabela.css">
     <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
     <link rel="preconnect" href="https://fonts.googleapis.com">
     <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
     <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;800&display=swap" rel="stylesheet">


     <style>
     #sobreposicao-popup2 {
         display: none;
         /* Inicialmente oculto */
         position: fixed;
         top: 0;
         left: 0;
         width: 100%;
         height: 100%;
         background-color: rgba(0, 0, 0, 0.5);
     }

     #conteudo-popup2 {
         position: absolute;
         top: 50%;
         left: 50%;
         transform: translate(-50%, -50%);
         background-color: #fff;
         padding: 20px;
         border-radius: 5px;
         box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
     }

     #fechar-popup2 {
         border: none;
         width: 82px;
         height: 40px;
         font-weight: bold;
         text-align: center;
         border-radius: 5px;
         background-color: #007bff;
         font-size: 20px;
     }

     .enviar {
         border: none;
         width: 82px;
         height: 40px;
         font-weight: bold;
         text-align: center;
         border-radius: 5px;
         background-color: #007bff;
         font-size: 20px;
     }
     select{
            min-width: 100px;
            width: 80%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 17px;
            outline: none; 
          
          }

     button:hover {
         cursor: pointer;
     }

     input[type='submit'] {
         cursor: pointer;
     }
     td{
        padding: 0px 3px;
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
                if($consulta->num_rows > 0){
                    echo "<h1>Todas as escolhas</h1><h2>Eletivas e Alunos<br> Turno: ".$turno."</h2>";
                    echo "<table class='teste'>";
                    echo "<tr><th>Nome da Eletiva</th><th>Nome do Aluno</th><th>Série</th><th>RA</th><th>Curso</th></tr>";
     
                    foreach($consulta as $row){
                        echo "<tr>";
                        echo "<td>" . str_replace("_"," ",$row["nome_eletiva"])  . "</td>";
                        echo "<td>" . $row["nome_aluno"] . "</td>";
                        echo "<td>" . $row["serie_aluno"] . "</td>";
                        echo "<td>" . $row["RA"] . "</td>";
                        echo "<td>" . $row["curso"] . "</td>";
                        echo "</tr>";
                        echo "<tr><td colspan='5'><hr></td></tr>";  
                    }
                    echo "</table>"; 

                    echo "<button class='export' onclick='exportToExcel()'>Exportar para Excel</button>
                    <button class='excluir-dados' onclick='mostrarPopup()'>Excluir dados</button>";
                }else{
                    echo "<h1>SEM DADOS</h1>";
                }
                
                 
            }
                ?>
         </div>

         <!-- Pop-up -->
         <div id="sobreposicao-popup">
             <div id="conteudo-popup">
                 <h2>Excluir dados</h2>
                 <p>Tem certeza que deseja <br>excluir todos os dados?</p>
                 <button id="fechar-popup"> Fechar</button>
                 <form method="post">
                     <button class="enviar" type="submit" name="enviar">Sim</button>
                 </form>
             </div>
         </div>

         <!-- Pop-up -->
         <div id="sobreposicao-popup2">
             <div id="conteudo-popup2">
                 <h2>Sucess</h2>
                 <p>Você excluiu os dados <br>com sucesso!</p>
                 <button id="fechar-popup2">Fechar</button>

             </div>
         </div>
        <center>
            <br><br>
         <a  href="../html/pag_gestor.html" class="btn-submit">Voltar</a>
        </center>

         <!-- Script JavaScript -->
         <script>
         const botaoFecharPopup = document.getElementById('fechar-popup');
         const sobreposicaoPopup = document.getElementById('sobreposicao-popup');
         const botaoFecharPopup2 = document.getElementById('fechar-popup2');
         const sobreposicaoPopup2 = document.getElementById('sobreposicao-popup2');
         const enviar = document.getElementById('enviar_sim');



         function fecharPopup() {
             sobreposicaoPopup.style.display = 'none';
         }

         function mostrarPopup() {
             sobreposicaoPopup.style.display = 'block';
         }

         function fecharPopup2() {
             sobreposicaoPopup2.style.display = 'none';
         }

         function mostrarPopup2() {
             sobreposicaoPopup2.style.display = 'block';
         }



         botaoFecharPopup.addEventListener('click', fecharPopup);
         botaoFecharPopup2.addEventListener('click', fecharPopup2);

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