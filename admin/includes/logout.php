<?php include_once("init.php") ;


	User::logout();
	 if (!User::isLogged()) {include("../inCphp"); exit();}
?>