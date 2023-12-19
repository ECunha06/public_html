<?php
session_start();
if (!isset($_SESSION['Num_Utilizador'])) { header('location: index.php'); exit; }

include "adicionalmente/config.php";

$Cod_Equipamento=$_GET['Cod_Equipamento'];

$sql = "DELETE FROM equipamentos WHERE Cod_Equipamento= '$Cod_Equipamento'";
// echo $sql;

if (mysqli_query($conn, $sql)) {
    //echo "Registo apagado com sucesso!";
    header("location:produtos.php?apagar=1");
	} 
	else 
	{
    echo "Erro ao apagar registo: " . mysqli_error($conn);
	}
include "adicionalmente/close.php"

?>