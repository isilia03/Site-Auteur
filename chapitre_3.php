<?php
try

{

    $bdd = new PDO('mysql:host=localhost;dbname=espace;charset=utf8', 'root', '');

}

catch(Exception $e)

{

        die('Erreur : '.$e->getMessage());

}
if(isset($_GET['id']) AND !empty($_GET['id'])) {
   $getid = htmlspecialchars($_GET['id']);
   $article = $bdd->prepare('SELECT * FROM articles WHERE id = ?');
   $article->execute(array($getid));
   $article = $article->fetch();
   if(isset($_POST['submit_commentaire'])) {
      if(isset($_POST['pseudo'],$_POST['commentaire']) AND !empty($_POST['pseudo']) AND !empty($_POST['commentaire'])) {
         $pseudo = htmlspecialchars($_POST['pseudo']);
         $commentaire = htmlspecialchars($_POST['commentaire']);

         if((strlen($pseudo) < 25) && (strlen($commentaire) < 40)){
            $ins = $bdd->prepare('INSERT INTO commentaires (pseudo, commentaire, id_article) VALUES (?,?,?)');
            $ins->execute(array($pseudo,$commentaire,$getid));
         } else {
            $c_msg = "<h5>Erreur: Le pseudo doit faire moins de 25 caractères et le commentaire moins de 40 caractères</h5>";
         }
      } else {
         $c_msg = "<h5>Erreur: Tous les champs doivent être complétés</h5>";
      }
   }
   $commentaires = $bdd->prepare('SELECT * FROM commentaires WHERE id_article = ? ORDER BY id DESC');
   $commentaires->execute(array($getid));
    $like = $bdd->prepare('SELECT id_like FROM likes WHERE id_article = ?');
    $like->execute(array($getid));
    $like = $like->rowCount();
?>






<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="chapitre_3.css" />
    <title>Blog de isilia03</title>
  </head>

  <body>
    <div id="bloc_page">
            <header>
                <div id="titre_principal">      
                    <div id="plume">
                        <img src="plume.png" alt="Logo de Zozor" />
                        <h1>Blog de isilia03</h1>    
                    </div>
                </div>
                
                <nav>
                    <ul>
                        <li id="accueil"><a href="accueil.html">Accueil</a></li>
                      <li id="rose"><a href="rose.html">La rose bleue</a></li>
                      <li id="contact"><a href="contact.html">Contact</a></li>
                   </ul>
                </nav>
            </header>
            
      <div id ="délimitation">
                     <img src="délimitation.png" alt="délimitation des parties">                        
            </div>

            <section>
                <h1>Chapitre 3:</h1>

                <div id = "coeur2">

                    <img src="vote2.png" width="90" height="70" alt="je vote" /> <h6><?= $like ?></h6>

                  </div>

                <article>
                     <p><?= $article['contenu'] ?></p>
                </article>
            </section>

            <div id ="liens">
                    <a href="chapitre_2.php?id=3"><img src="flèche2.png"  width="75" height="75" alt="deuxième flèche"></a>
                    <a href="sommaire.html"><img src="point.png" width="75" height="75" alt="point"></a>
                    <a href="chapitre_4.php?id=5"><img src="flèche.png"  width="75" height="75" alt="flèche"></a>                        
            </div>

            <section>
                <h2>Ca vous a plû ? Vous avez des remarques à faire à la suite de cette lecture ? Alors n'hésitez pas à commenter.</h2>
            </section>

            <div id = "coeur">

                Je vote <a href ="action.php?t=1&amp;id=4"><img src="vote.png" width="90" height="70" alt="je vote" /></a> 

              </div>


            <form method="post">


 
                   <fieldset>
                       <label for="cordonnées">Vos cordonnées</label>
                       <p>
                          <input id="pseudo" type="text" name="pseudo" placeholder="Votre pseudo" />         
                       </p>
                        
                        <label for="commentaire">Votre commentaire </label>
                         <p>
                           <textarea id="commentaire" name="commentaire" placeholder="Votre commentaire..."></textarea><br />
                       </p>
                   </fieldset>
                   <input id="bouton" type="submit" value="Commenter" name="submit_commentaire" />

                    
            </form>

            <?php if(isset($c_msg)) { echo $c_msg; } ?>
            
            <?php while($c = $commentaires->fetch()) { ?>
              <section id="com">
               <b><?= $c['pseudo'] ?>:<p id="com_corps"></b> <?= $c['commentaire'] ?></p>
               </section>
            <?php } ?>
            <?php
            }
            ?>

            <div id ="délimitation2">
                     <img src="délimitation.png" alt="délimitation des parties">                        
            </div>
  </body>

  <footer>
    <p>© 2016 | Tout droit réservé sur la fiction | Design : HTML5</p> 
  </footer>