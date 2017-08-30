<?php 

	include_once("init.php") ;

	$todelete = $_GET['user_id'];

	Comment::delete($todelete);

	header('Location: index.php?page=comments');

	exit();

?>