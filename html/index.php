<!DOCTYPE html>
<?php
if (isset($_POST['username_comptable']) AND isset($_POST['password_comptable'])) {
	echo "WOOOOOOOORK";
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
		<p id="comptablee">Connexion comptable : </p>
	<form action="" method="post">
	<input name="username_comptable" placeholder="Nom d'utilisateur" >
	<input  name="password_comptable" type="password" id="input" placeholder="●●●●●●●●●●"></input>
	<div id="connect" onclick="document.getElementById('submit_comptable').click()">
		<p id="connexion" >Connexion</p>
	</div>
	<input type="submit" id="submit_comptable" style="display: none;">
	</form>
</div>
 <div id="divcomptable">
	<div id="previouss">
		<p id="retour">Retour</p>
	</div>	
	<img id="image" src="arrow.png">
		<p id="comptablee">Connexion visiteur : </p>
	<input placeholder="Nom d'utilisateur" >
	<input  type="password" id="input" placeholder="●●●●●●●●●●"></input>
	<div id="connect">
		<p id="connexion" >Connexion</p>
	</div>
</div>
</body>
<script src="js/sloat.js"></script> 
</html>