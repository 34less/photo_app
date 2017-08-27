<?php include_once("init.php") ;


	User::logout();

	header('Location: index.php');

	exit();

?>