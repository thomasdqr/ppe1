<?php
//include 'interface.php';
define("PASSWORD", "legrascestlavie");
//LOCAL DB :
//$BaseDeDonnees = new PDO('mysql:host=localhost;dbname=gsb', 'root','');
//ONLINE DB :
$BaseDeDonnees = new PDO('mysql:host=thomasdeltroot.mysql.db;dbname=thomasdeltroot', 'thomasdeltroot', 'Password98');


$id_user = $_POST['id_user'];
$action = $_POST['action'];
$hash = $_POST['hash'];
$timestamp = substr($hash, strpos($hash, "_") + 1);

//$current_month = date('m');
//$current_year = date("Y");
$current_month = $_POST['month'];
$current_year = $_POST['year'];

//echo "id_user : ".$id_user." action : ".$action;

if (sha1($id_user.$timestamp.PASSWORD)."_".$timestamp == $hash) {

	if ($action == "new_month") {
		$current_date_txt = $current_year."-".$current_month."-01";
		$current_moment = date('Y-m-d', strtotime($current_date_txt));

		$tmp = "null";
		foreach($BaseDeDonnees->query("SELECT nuits FROM frais_forfait WHERE id_visiteur='$id_user' AND YEAR(date) = '$current_year' AND MONTH(date) = '$current_month'") as $row) {
			$tmp = $row[0];
		}
		if ($tmp == "null") {
			$BaseDeDonnees->query("INSERT INTO frais_forfait(id_visiteur, nuits, repas, kilometres, date) VALUES ('$id_user', '0', '0', '0', '$current_moment')");
			echo $current_moment." | ".$id_user." | ";
			echo "new data month created";
		}
		else {
			echo "everything is ok";
		}
	}

	if ($action == "forfait") {
		$nuits = $_POST['nuits'];
		$repas = $_POST['repas'];
		$km = $_POST['km'];
		$current_date_txt = $current_year."-".$current_month."-01";
		$current_moment = date('Y-m-d', strtotime($current_date_txt));

		//$BaseDeDonnees->query("INSERT INTO frais_forfait(id_visiteur, nuits, repas, kilometres, date) VALUES ('$id_user', '0', '0', '0', '$current_moment')");
		$BaseDeDonnees->query("UPDATE frais_forfait SET nuits='$nuits', repas='$repas', kilometres='$km' WHERE id_visiteur='$id_user' AND YEAR(date) = '$current_year' AND MONTH(date) = '$current_month'");
	}

	if ($action == "hf") {
		$libelle = str_replace(";", "", $_POST['libelle']);
		$date = $_POST['date'];
		$montant = $_POST['montant'];
		$justif = $_FILES['file'];
		if (isset($_FILES['file']['name'])) {
		     $justif_value = "justificatifs/".$id_user."/".time().$_FILES['file']['name'];
	    }
	    else {
	    	$justif_value = "";
	    }

		if (strlen($libelle) > 0 && strlen($date) > 0) {
			$BaseDeDonnees->query("INSERT INTO hors_forfait(id_user, libelle, date, montant, justificatif, statut) VALUES ('$id_user', '$libelle', '$date', '$montant', '$justif_value', '0')");
			if (!file_exists("justificatifs/".$id_user)) {
				mkdir("justificatifs/".$id_user, 0777, true);
			}
			move_uploaded_file($_FILES['file']['tmp_name'],"justificatifs/".$id_user."/".time().$_FILES['file']['name']);
	    }
	}

	if ($action == "deletehf") {
		$id_hf = $_POST['id_hf'];
		foreach($BaseDeDonnees->query("SELECT justificatif FROM hors_forfait WHERE id='$id_hf'") as $row) {
			unlink($row[0]);
		}
		
		$BaseDeDonnees->query("DELETE FROM hors_forfait WHERE id='$id_hf'");
	}

	if ($action == "get_ff") {
		foreach($BaseDeDonnees->query("SELECT nuits, repas, kilometres, statut FROM frais_forfait WHERE id_visiteur='$id_user' AND YEAR(date) = '$current_year' AND MONTH(date) = '$current_month'") as $row) {
			echo $row[0].";".$row[1].";".$row[2].";".$row[3];
		}
	}

	if ($action == "get_hf") {
		foreach($BaseDeDonnees->query("SELECT libelle, date, montant, id, justificatif, statut FROM hors_forfait WHERE id_user='$id_user' AND YEAR(date) = '$current_year' AND MONTH(date) = '$current_month'") as $row) {
			echo $row[0].";".$row[1].";".$row[2].";".$row[3].";".$row[4].";".$row[5]."|";
		}
	}

	if ($action == "connect_comptable") {
		$password = $_POST['password'];
		$username= filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);

		if (!is_null($username) AND isset($password)) {
			$user_exist = false;
			foreach($BaseDeDonnees->query("SELECT mdp, id FROM comptables WHERE utilisateur = '$username'") as $row) {
				$user_exist = true;
				if ($row[0]==$password) {
					echo 'chevalierisation;'.$row[1];
				}
				else{
					echo 'mot de passe incorrect';
				}
			}
			if($user_exist == false){
				echo 'Cet identifiant n\'existe pas';
			}
		}

	}

	if ($action == "get_visiteurs") {
		foreach($BaseDeDonnees->query("SELECT id, utilisateur FROM visiteur") as $row) {
			echo $row[0].";".$row[1]."|";
		}
	}

	if ($action == "get_period") {
		foreach($BaseDeDonnees->query("SELECT id, date FROM frais_forfait WHERE id_visiteur = '$id_user'") as $row) {
			echo $row[0].";".$row[1]."|";
		}
	}

	if ($action == "say_hello") {
		echo "hello :D";
	}

	if ($action == "validate_hf") {
		$id_hf = $_POST['id_hf'];
		$status = $_POST['status'];

		$BaseDeDonnees->query("UPDATE hors_forfait SET statut='$status' WHERE id='$id_hf'");
	}

	if ($action == "change_status") {
		$status = $_POST["status"];
		$current_date_txt = $current_year."-".$current_month."-01";
		$current_moment = date('Y-m-d', strtotime($current_date_txt));
		$BaseDeDonnees->query("UPDATE frais_forfait SET statut='$status' WHERE id_visiteur='$id_user' AND YEAR(date) = '$current_year' AND MONTH(date) = '$current_month'");
	}
}
else {
	echo "wrong hash";
}

?>
