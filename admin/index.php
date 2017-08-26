<?php 
/* INCLUDIAMO IL FILE DI INIZIALIZZAZIONE */
include_once("init.php");

/* CONTROLLA SE E' STATA SCELTA UNA PAGINA, IN CASO CONTRARIO -->HOME.PHP */
if (!isset($_GET['page'])) $page = 'home';
else $page = $_GET['page'];

/* CONTROLLA SE L'UTENTE HA FATTO IL LOGIN, IN CASO CONTRARIO -->LOGIN.PHP */
if (!User::isLogged())
{
    header('Location: index.php?page=login');
    exit();
}

/* CONTROLLA SE ESISTE UNA PAGINA INIT E LA CARICA */
if (file_exists('init_pages/init_'.$page.'.php'))
include('init_pages/init_'.$page.'.php');

/* CONTROLLA SE ESISTE UNA PAGINA*/
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









<?php
  /*          $Marta = new User();
            $Marta->username="M";
            $Marta->password="MM";
            $Marta->first_name="marta";
            $Marta->last_name="Audisio";
            foreach ($Marta as $marta){
                            echo $marta;
            }
            $Marta->save();*/
 ?>