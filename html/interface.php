<!DOCTYPE html>
<?php

session_start();
echo "<div id='id_user' style='display:none'>".$_SESSION['id_visiteur']."</div>";

?>
<html>
<head>
	<title>GSB</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="interface.css">
	<meta http-equiv="refresh" content="s">
	<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.min.js"></script>

</head>
<body>
	<!--BAR-->
	<div id="top_bar">
		<label id="top_title">GSB</label>
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

	<!-- Elements hors forfaitisés -->

	<div id="horsforfait_elements">

	<label id="horsforfait_title">Elements hors forfait</label>
	<div id="hf_div" onclick="addHF()">
		<label id="hf_btn_txt">+&#160 &#160 Hors forfait</label>
	</div>

	<div id="hf_blocks"></div>

    </div>




    <!-- /////////////////////////// HISTORY ////////////////////////////// -->
    <div id="calendar">
    	<div id="next_btn"></div>
    	<label id="month">Octobre</label>
    	<div id="prev_btn"></div>
    </div>
    <div id="history_div">
    	<label id="hist_nuits">Nuits d'hotel : 0</label>
    	<label id="hist_repas">Repas : 0</label>
    	<label id="hist_km">Kilomètres : 0</label>
    	<div id="hist_line"></div>
    	<label id="hist_hf">Hors forfait :</label>
    </div>

	<script type="text/javascript" src="js/interface.js"></script>
</body>
</html>