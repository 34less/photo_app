<?php 

/* Definisce come costante il punto in cui è locato l'index.php*/
define ('SITE_ROOT', realpath(dirname(__FILE__)));

/* INCLUDIAMO IL FILE DI INIZIALIZZAZIONE */
include_once("init.php");

/* CONTROLLA SE E' STATA SCELTA UNA PAGINA, IN CASO CONTRARIO -->HOME.PHP */
if (!isset($_GET['page'])) $page = 'home';
else $page = $_GET['page'];

/* CONTROLLA SE L'UTENTE HA FATTO IL LOGIN, IN CASO CONTRARIO -->LOGIN.PHP */
if (!User::isLogged())
{
    $page = "login";
}

/* CONTROLLA SE ESISTE UNA PAGINA INIT E LA CARICA */
if (file_exists('includes/init_pages/'.$page.'.php')){
    include('includes/init_pages/'.$page.'.php');
}


/* CONTROLLA SE ESISTE LA PAGINA CHE VOGLIAMO CARICARE */
if (file_exists('includes/pages/'.$page.'.php'))
{

    /* CARICA L'HEAD DEL NOSTRO DOCUMENTO */
    /* contiene <head></head><body> */
    include("includes/pages/header.php"); 

    /* CARICA LA PAGINA SELEZIONATA */
    include('includes/pages/'.$page.'.php');

    /* CARICA IL FOOTER */
    /* contiene </body> */
    include("includes/pages/footer.php"); 

} 
?>
