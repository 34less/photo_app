<?php 

	include_once("init.php") ;

	$todelete = $_GET['foto_id'];

	Photo::delete($todelete);


	header('Location: index.php?page=photos');

	exit();

?>