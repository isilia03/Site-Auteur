<?php
try

{

    $bdd = new PDO('mysql:host=localhost;dbname=espace;charset=utf8', 'root', '');

}

catch(Exception $e)

{

        die('Erreur : '.$e->getMessage());

}

if (isset($_GET['t'], $_GET['id']) AND !empty($_GET['t']) AND !empty($_GET['id']))
{
   $getid = (int) $_GET['id'];
   $gett = (int) $_GET['t'];


   $check = $bdd->prepare('SELECT id FROM articles  WHERE id = ?');
   $check->execute(array($getid));

   if ($check->rowCount() == 1) {
      if ($gett == 1) {
         $ins = $bdd->prepare('INSERT INTO likes (id_article) VALUES (?)');
         $ins->execute(array($getid));
      }
      header("location:".  $_SERVER['HTTP_REFERER']); 
   }
   else
   {
      exit('Erreur fatale. <a href="http://localhost/site/">Revenir à l\'accueil</a>');
   }
}

else
   {
      exit('Erreur fatale. <a href="http://localhost/site/">Revenir à l\'accueil</a>');
   }

?>
