<?php 
	include 'connection.php';
	$id = $_GET['id'];
	$sql_delete = "DELETE FROM `artikel` WHERE `id` = ?";
	$query = $pdo->prepare($sql_delete);
	$query->execute(array($id));
	header("Location : crud.php");
?>