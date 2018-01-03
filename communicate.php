<?php
//include 'interface.php';
define("PASSWORD", "legrascestlavie");
$BaseDeDonnees = new PDO('mysql:host=localhost;dbname=gsb', 'root','');

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
			$BaseDeDonnees->query("INSERT INTO hors_forfait(id_user, libelle, date, montant, justificatif) VALUES ('$id_user', '$libelle', '$date', '$montant', '$justif_value')");
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
		foreach($BaseDeDonnees->query("SELECT nuits, repas, kilometres FROM frais_forfait WHERE id_visiteur='$id_user' AND YEAR(date) = '$current_year' AND MONTH(date) = '$current_month'") as $row) {
			echo $row[0].";".$row[1].";".$row[2];
		}
	}

	if ($action == "get_hf") {
		foreach($BaseDeDonnees->query("SELECT libelle, date, montant, id, justificatif FROM hors_forfait WHERE id_user='$id_user' AND YEAR(date) = '$current_year' AND MONTH(date) = '$current_month'") as $row) {
			echo $row[0].";".$row[1].";".$row[2].";".$row[3].";".$row[4]."|";
		}
	}
}
else {
	// Wrong hash
}
?>
