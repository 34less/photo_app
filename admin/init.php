<!-- QUESTO FILE INIZIALIZZA I CONTENUTI PHP AL PRIMO CARICAMETO DELLA PAGINA-->

<?php 

//start the session	
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 

//output buffer initialization
ob_start();

//crypt_key- used to crypt the database password
define('CRYPT_KEY', 'uuuudhhhdajkhdkad');

// spl_autoload_register serve per verificare che la classe che stiamo caricando esiste davvero, in caso non esiste, blocca l'applicazione e mostra un errore.

	spl_autoload_register(function ($class) {
		
		$class = strtolower($class);

		if (file_exists('includes/'.$class.'.php'))
			include_once('models/'.$class.'.php');
		else if (file_exists('includes/Classes/'.$class.'.php'))
			include_once('classes/'.$class.'.php');
		else die("This file name {$class}.php was not found");
	
	});



//include classes used
include("includes/Classes/Database.php");
include("includes/Classes/User.php");


?>