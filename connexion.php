<?php
function POST_secure($name)
{	
	return filter_input(INPUT_POST,$name, FILTER_SANITIZE_STRING);
}
session_start();

try
{
    $bdd = new PDO('mysql:host=localhost;dbname=espace;charset=utf8', 'root', '');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

if (isset($_POST['submit_connexion'])) {
	$mailconnexion = htmlspecialchars(POST_secure('mailconnexion'));
	$motdepasseconnexion = sha1(POST_secure('motdepasseconnexion'));
	if (!empty($mailconnexion) AND !empty($motdepasseconnexion)) {
		$requser = $bdd->prepare('SELECT * FROM espace_membres WHERE mail = ? AND motdepasse = ?');
		$requser->execute(array($mailconnexion, $motdepasseconnexion));
		$userexist = $requser->rowCount();
		if ($userexist == 1) {
			$userinfo = $requser->fetch();
			$_SESSION['id'] = $userinfo['id'];
			$_SESSION['pseudo'] = $userinfo['pseudo'];
			$_SESSION['mail'] = $userinfo['mail'];
			header("Location: profil.php?id=".$_SESSION['id']);
		}
		else
		{
			$erreur = "<h5>Idenfiants incorrects<h5>";
		}
	}
	else
	{
		$erreur = "<h5>Tous les champs doivent être complétés<h5>";
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
    <link rel="stylesheet" href="prologue.css" />
	<title>Blog de isilia03</title>
</head>
<body>
	<div align="center">
		<h3>Connexion</h3>
		<br /><br /><br />
		<form method="POST" action="">
		<table>
			<tr>
				<td align="right"><label for="mailconnexion">Votre mail :</label></td>
				<td><input type="text" placeholder="Votre mail" name="mailconnexion"/></td>
			</tr>
			<tr>
				<td align="right"><label for="motdepasseconnexion">Votre mot de passe :</label></td>
				<td><input type="password" placeholder="Votre mot de passe" name="motdepasseconnexion"/></td>
			</tr>
		</table>
		<br />
		<input id="bouton" type="submit" value="Connexion" name="submit_connexion" />
		<<?php if (isset($erreur)) {
			echo ($erreur);
		} ?>
	</div>
</body>
</html>