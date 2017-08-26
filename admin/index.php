<?php 
// INCLUDIAMO IL FILE DI INIZIALIZZAZIONE
include_once("init.php");

if (!isset($_GET['page'])) $page = 'home';
else $page = $_GET['page'];

if (!User::isLogged())
{
header('Location: index.php?page=login');
exit();
}


if (file_exists('init_pages/init_'.$page.'.php'))
include('init_pages/init_'.$page.'.php');

if (file_exists('includes/pages/'.$page.'.php'))
{

    include("includes/header.php"); 

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