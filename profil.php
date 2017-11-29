<?php
session_start();
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=espace;charset=utf8', 'root', '');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
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
		<h3>Profil de ...</h3>
		<br /><br /><br />
		
		<?php if (isset($erreur)) {
			echo ($erreur);
		} ?>
	</div>
</body>
</html>