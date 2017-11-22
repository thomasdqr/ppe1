var blocks_div = document.getElementById("hf_blocks");
var repas_input = document.getElementById("repas_input");
var nuit_input = document.getElementById("nuits_input");
var km_input = document.getElementById("km_input");
var forfait_elements = document.getElementById("forfait_elements");
var hf_elements = document.getElementById("horsforfait_elements");

var calendar = document.getElementById("calendar");
var history = document.getElementById("history_div");

document.getElementById("submit_btn").className  = "disabled";

////////////////////TESTING PURPOSE////////////////////////////////

showHistory();

///////////////////////////////////////////////////////////////////

function addHF() {
	document.getElementById("submit_btn").className  = "";
	blocks_div.innerHTML += "<div class='hf_block'></div>";
	blocks_div.scrollTop += 100;
}

function addRepas() {
	document.getElementById("submit_btn").className  = "";
	repas_input.value = parseInt(repas_input.value, 10) + 1;
}

function lessRepas() {
	if (repas_input.value > 0) {
		document.getElementById("submit_btn").className  = "";
		repas_input.value -= 1;
	}
}

function addNuit() {
	document.getElementById("submit_btn").className  = "";
	nuit_input.value = parseInt(nuit_input.value, 10) + 1;
}

function lessNuit() {
	if (nuit_input.value > 0) {
		document.getElementById("submit_btn").className  = "";
		nuit_input.value -= 1;
	}
}

function addKm() {
	document.getElementById("submit_btn").className  = "";
	km_input.value = parseInt(km_input.value, 10) + 1;
}

function lessKm() {
	if (km_input.value > 0) {
		document.getElementById("submit_btn").className  = "";
		km_input.value -= 1;
	}
}

function preventEmpty(element) {
	document.getElementById("submit_btn").className  = "";
	if (element.value.length == 0) {
		element.value = 0;
	}
}

function submit() {
	var id_user = document.getElementById("id_user").innerHTML;
	var repas = repas_input.value;
	var nuits = nuits_input.value;   
	var km = km_input.value;   

	$.ajax({
		type: "GET",
		url: "communicate.php",
		data: "id_user=" + id_user+ "&nuits=" + nuits+ "&repas=" + repas+ "&km="+km,
		dataType : 'html'
	});
	document.getElementById("submit_btn").className  = "disabled";
}

function showHistory () {
	forfait_elements.style.left = "-100vw";
	hf_elements.style.left = "-53.4vw";

	calendar.style.left = "42.5vw";
	document.getElementById("history_div").style.left = "30vw";

	document.getElementById("new_remboursement_div").style.backgroundColor = "#2d3845";
	document.getElementById("my_remboursements_div").style.backgroundColor = "white";
}

function showMonth() {
	forfait_elements.style.left = "6.6vw";
	hf_elements.style.left = "53.2vw";

	calendar.style.left = "130vw";
	document.getElementById("history_div").style.left = "117.5vw";

	document.getElementById("new_remboursement_div").style.backgroundColor = "white";
	document.getElementById("my_remboursements_div").style.backgroundColor = "#2d3845";
}