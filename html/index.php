
<!DOCTYPE html>
<?php
session_start();

/* UTILISER LES FILTER INPUT */
$user_visiteur= filter_input(INPUT_POST, 'username_visiteur', FILTER_SANITIZE_STRING);

if (!is_null($user_visiteur) AND isset($_POST['password_visiteur'])) {
	$BaseDeDonnees = new PDO('mysql:host=localhost;dbname=gsb', 'root','');
	$user_exist = false;
	foreach($BaseDeDonnees->query("SELECT mdp, id FROM visiteur WHERE utilisateur = '$user_visiteur'") as $row) {
		$user_exist = true;
		if ($row[0]==$_POST['password_visiteur']) {
			echo 'It works';
			$_SESSION['id_visiteur'] = $row[1];
			header('Location: interface.php');

		}
		else{
			echo 'wrong password';
		}
	}
	if($user_exist == false){
		echo 'User doesn\'t exist';
	}
}
?>

<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="index.css">
	<link rel="stylesheet" href="connexion.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	
	<title>accueil</title>
</head>
<body>

	<div>
		<h1>GSB</h1>
	</div>
	<div id="divindex">
		<h2>Connexion :</h2>

		<div id="visiteur">
			<h3>Visiteur</h3>
		</div>

		<div id="comptable">
			<h4>Comptable</h4>
		</div>
	</div>

	<div id="divconnexion">
		<div id="previous">
			<p id="retour">Retour</p>
		</div>	
		<img id="image" src="arrow.png">
		<p id="comptablee">Veuillez télécharger GSB Desktop<br><a href='http://www.google.fr'>Download here</a></p>
	</div>
	<div id="divcomptable">
		<div id="previouss">
			<p id="retour">Retour</p>
		</div>	
		<img id="image" src="arrow.png">
		<p id="comptablee">Connexion visiteur : </p>
		<form action="" method="post">
			<input name="username_visiteur" placeholder="Nom d'utilisateur" required>
			<input name="password_visiteur" type="text" id="input" placeholder="Code numérique" readonly>
			<table id="mytable">
				
			</table>
			<div id="connect" onclick="document.getElementById('submit_visiteur').click()">
				<p id="connexion" >Connexion</p>
			</div>
			<input type="submit" id="submit_visiteur" style="display: none;">
		</div>
	</body>
	<script src="js/sloat.js"></script> 
	<script type="text/javascript" src="js/btsblanc.js"></script>
	</html>