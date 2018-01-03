<?php
session_start();
define("PASSWORD", "legrascestlavie");

echo "<div id='id_user' style='display:none'>".$_SESSION['id_visiteur']."</div>";
$timestamp = time();
$hash = sha1($_SESSION['id_visiteur'].$timestamp.PASSWORD)."_".$timestamp;
echo "<div id='hash' style='display:none'>".$hash."</div>";
?>
<!DOCTYPE html>
<html>
<head>
	<title>GSB</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.min.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<link rel="stylesheet" href="interface.css">



</head>
<body>

	<!--BAR-->
	<div id="top_bar">
		<label id="top_title">GSB</label>
		<div id="sign_out" onclick="sign_out()"></div>
	</div>


	<!-- TOP BAR ELEMENTS -->
	<label id="new_remboursement_txt" onclick="showMonth()">Mois en cours</label>
	<div id="new_remboursement_div"></div>
	<label id="my_remboursements_txt" onclick="showHistory()">Historique</label>
	<div id="my_remboursements_div"></div>

	<!-- Elements forfaitarisés -->
    <div id="forfait_elements">
    	
    <label id="forfait_title">Elements forfaitarisés</label>
	<div id='add_repas' onclick="addRepas()">+</div>
	<input id="repas_input" onchange="preventEmpty(this)" value="0" pattern="[0-9]"/>
	<div id='less_repas' onclick="lessRepas()">-</div>
	<label id="repas_txt">Repas</label>

	<div id='add_nuits' onclick="addNuit()">+</div>
	<input id="nuits_input" onchange="preventEmpty(this)" value="0" pattern="[0-9]"/>
	<div id='less_nuits' onclick="lessNuit()">-</div>
	<label id="nuits_txt">Nuits d'hotel</label>

	<div id='add_km' onclick="addKm()">+</div>
	<input id="km_input" onchange="preventEmpty(this)" value="0" pattern="[0-9]"/>
	<div id='less_km' onclick="lessKm()">-</div>
	<label id="km_txt">Kilomètres</label>

	<div id="submit_btn" onclick="submit()"><label id="submit_txt">Valider les changements</label></div>
    
    </div>

    <div id="arriere"></div>
    <div id="cacher">
    	<p id="hautcacher">Ajouter un frais hors forfait</p>
    	<img id="close" src="close_btn.png" onclick="close_hf()">
    	<input type="date" id="date" name="bday">

    	<!-- <input id="date" type="date" name="Date" min="2017-11-00" max="2017-11-30"/> -->
    	<label id="textedate">Date :</label>
    	<input id="libelle" placeholder="nom du frais" />
    	<label id="textelibele">Libellé :</label>
    	<input id="montant_input" type="number" min="0" step="any" value="0" onchange="preventEmpty(this)" placeholder="montant du frais" />
    	<label id="montant">Montant en € :</label>

    	 <input id="justif" type="file" name="fileToUpload" id="fileToUpload" class="custom-file-input">
    	<div id="valider" onclick="addHF()">
		<h3>Valider</h3>
	</div>
    </div>

	<!-- Elements hors forfaitisés -->

	<div id="horsforfait_elements">

	<label id="horsforfait_title">Elements hors forfait</label>
	<div id="hf_div" onclick="showAddHF()">
		<label id="hf_btn_txt">+&#160 &#160 Hors forfait</label>
	</div>

	<div id="hf_blocks"></div>

    </div>

    <!-- /////////////////////////// HISTORY ////////////////////////////// -->
    <div id="calendar">
    	<div id="next_btn" onclick="updateMonth(1)"></div>
    	<label id="month">Octobre 2017</label>
    	<input id="datepicker">
    	<div id="prev_btn" onclick="updateMonth(-1)"></div>
    </div>
    <div id="history_div">
    	<label id="hist_nuits">Nuits d'hotel : 0</label>
    	<label id="hist_repas">Repas : 0</label>
    	<label id="hist_km">Kilomètres : 0</label>
    	<div id="hist_line"></div>
    	<label id="hist_hf">Hors forfait :</label>
    	<div id="hist_hf_blocks">
    	</div>
    </div>

	<script type="text/javascript" src="js/interface.js"></script>
</body>
</html>