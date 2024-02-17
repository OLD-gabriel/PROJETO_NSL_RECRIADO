<?php 
include "variables.php";

$senha = $_POST["senha"];

if($senha == $senha_pag_gestor){
    header("location: ../html/pag_gestor.html");
}
else{
    header("location: ../html/gestor.html?status=false");
}