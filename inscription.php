<?php

function POST_secure($name)
{	
	return filter_input(INPUT_POST,$name, FILTER_SANITIZE_STRING);
}

try
{
    $bdd = new PDO('mysql:host=localhost;dbname=espace;charset=utf8', 'root', '');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
if (isset($_POST['submit_incription']))
{
	if (!empty($_POST['pseudo']) AND !empty($_POST['mail']) AND !empty($_POST['motdepasse']) AND !empty($_POST['motdepasse2'])) {
		$pseudo = htmlspecialchars(POST_secure('pseudo'));
		$mail = htmlspecialchars(POST_secure('mail'));
		$motdepasse = sha1(POST_secure('motdepasse'));
		$motdepasse2 = sha1(POST_secure('motdepasse2'));
		 if(strlen($pseudo) < 250)
		 {
		 	if (strlen($mail) < 250) {
		 		if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
			 			$reqmail = $bdd->prepare('SELECT * FROM espace_membres WHERE mail = ?');
			 			$reqmail->execute(array($mail));
			 			$mailexist = $reqmail->rowCount();
			 			if ($mailexist == 0)
			 			{
			 				if ($motdepasse == $motdepasse2) {
			 					$erreur = "<h4>Création du compte terminée !</h4>";
			 					$insert_membre = $bdd->prepare('INSERT INTO espace_membres (pseudo, mail, motdepasse) VALUES (?, ?, ?)');
			 					$insert_membre->execute(array($pseudo, $mail, $motdepasse));
			 				}
						 	else
						 	{
						 		$erreur = "<h5>Erreur: Votre mot de passe est différent veuiller le ressaisir</h5>";
						 	}
			 			}	
			 			else
			 			{
			 				$erreur = "<h5>Ce mail est déjà utilisé<h5>";
			 			}	
		 			}
		 		else
		 		{
		 			$erreur = "<h5>Erreur: Votre adresse mail n'est pas valide</h5>";
		 		}
		 	}
		 	else
		 	{
		 		$erreur = "<h5>Erreur: Votre adresse mail est trop longue veuiller en choisir une autre</h5>";
		 	}
		 }
		 else
		 {
		 	$erreur = "<h5>Erreur: Le pseudo choisi est trop long veuiller en choisir un autre</h5>";
		 }
	}
	else
	{
		$erreur = "<h5>Erreur: Tous les champs doivent être complétés</h5>";
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
    <link rel="stylesheet" href="inscription.css" />
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

            	<div align="center" id="section">
					<h3>Inscription</h3>
					<br /><br /><br />
					<form method="POST" action="">

						<table>
							<tr>
								<td align="right"><label for="pseudo">Votre pseudo :</label></td>
								<td><input type="text" placeholder="Votre pseudo" name="pseudo"/></td>
							</tr>
							<tr>
								<td align="right"><label for="mail">Votre mail :</label></td>
								<td><input type="text" placeholder="Votre mail" name="mail"/></td>
							</tr>
							<tr>
								<td align="right"><label for="motdepasse">Votre mot de passe :</label></td>
								<td><input type="password" placeholder="Votre mot de passe" name="motdepasse"/></td>
							</tr>
							<tr>
								<td align="right"><label for="motdepasse2">Confirmation mot de passe :</label></td>
								<td><input type="password" placeholder="Confirmer votre mot de passe" name="motdepasse2"/></td>
							</tr>
						</table>
					<br /><br />
					<input id="bouton" type="submit" value="Je m'inscris" name="submit_incription" />
					<?php if (isset($erreur)) {
						echo ($erreur);
					} ?>
					</form>
						<br /><br /><br />
						<a href="accueil.html">Retour vers l'accueil</a>

				
			</div>

            <div id ="délimitation2">
                     <img src="délimitation.png" alt="délimitation des parties">                       	
            </div>
	</body>

	<footer>
		<p>© 2016 | Tout droit réservé sur la fiction | Design : HTML5</p> 
	</footer>
