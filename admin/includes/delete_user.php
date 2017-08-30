<?php 

	include_once("init.php") ;

	$todelete = $_GET['foto_id'];

	User::delete($todelete);

	header('Location: index.php?page=users');

	exit();

?>