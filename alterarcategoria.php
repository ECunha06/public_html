<?php
session_start();
if (!isset($_SESSION['Num_Utilizador'])) { header('location: index.php'); exit; }
	include "adicionalmente/config.php";

	if (isset($_POST)) {
		$Id_Categoria=$_POST["categoriasId"];
		$Nome_Categoria=$_POST["categoriaAlterar"];
		//print_r($_POST);

	$sql = "UPDATE Categorias SET Nome_Categoria='$Nome_Categoria' WHERE Id_Categoria=$Id_Categoria";
	//echo "Teste: ".$sql."Fim";

	if (mysqli_query($conn, $sql)) {
	    //echo "Record updated successfully";
	    header("location:produtos.php?alterar=1");
	} else {
	    echo "Erro ao atualizar: " . mysqli_error($conn);
	}
	}
	include "adicionalmente/close.php";
?>
