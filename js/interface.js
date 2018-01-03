var blocks_div = document.getElementById("hf_blocks");
var repas_input = document.getElementById("repas_input");
var nuit_input = document.getElementById("nuits_input");
var km_input = document.getElementById("km_input");
var libelle_input = document.getElementById("libelle");
var date_input = document.getElementById("date");
var montant_input = document.getElementById("montant_input");
var forfait_elements = document.getElementById("forfait_elements");
var hf_elements = document.getElementById("horsforfait_elements");


var month_txt = document.getElementById("month");
var monthNames = ["Janvier", "Fevrier", "Mars", "Avril", "Mai", "Juin",
  "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Decembre"
];
var calendar = document.getElementById("calendar");
var history = document.getElementById("history_div");

var history_date = new Date();
var current_date = new Date();
date_input.min = "2017-"+(history_date.getMonth()+1)+"-01";
date_input.max = "2017-"+(history_date.getMonth()+1)+"-30";

document.getElementById("submit_btn").className  = "disabled";

check_data();
updateMonth(0);
////////////////////TESTING PURPOSE////////////////////////////////

//showHistory();

///////////////////////////////////////////////////////////////////
function updateMonth(modif) {
	history_date.setMonth(history_date.getMonth() + modif);
	month_txt.innerHTML=monthNames[history_date.getMonth()]+" "+history_date.getFullYear();

	var id_user = document.getElementById("id_user").innerHTML;
    var hash = document.getElementById("hash").innerHTML;
    var hf_block_div = document.getElementById("hist_hf_blocks");

    $.ajax({
		url : 'communicate.php',
		type : 'POST',
		dataType : 'html', 
		data:{
			hash:hash,
			id_user:id_user,
			month: history_date.getMonth() + 1,
			year: history_date.getFullYear(),
			action:'get_hf'
		},
		success : function(code_html, statut){
			hf_block_div.innerHTML = "";
			var results = code_html;
			var array = results.split("|");
			console.log(array);
			array.forEach(function(element) {
				var infos = element.split(";");
				if (infos.length > 1) {
                    var html_res = "<div class='hf_block'><label class='hf_block_title'>"+infos[0]+"</label><br><label class='hf_block_date'>"+infos[1]+"</label><label class='hf_block_montant'>"+infos[2]+" €</label><label class='id_hf' style='display:none'>"+infos[3]+"</label>";
					if (infos[4].length > 1) {
						html_res += "<a class='link2' href='"+infos[4]+"'>justificatif</a>";
					}
					html_res += "</div>";
					hf_block_div.innerHTML += html_res;
				}
			});
		}
	});

    

	
	$.ajax({
		url : 'communicate.php',
		type : 'POST',
		dataType : 'html', 
		data:{
			hash:hash,
			id_user:id_user,
			month: history_date.getMonth() + 1,
			year: history_date.getFullYear(),
			action:'get_ff'
		},
		success : function(code_html, statut){
			var results = code_html;
			var array = results.split(";");
			console.log(array);
			if (array.length > 1) {
			    hist_nuits.innerHTML = "Nuits d'hotel : " + array[0];
			    hist_repas.innerHTML = "Repas : " + array[1];
			    hist_km.innerHTML = "Kilomètres : "+ array[2];
		    }
		    else {
		    	hist_nuits.innerHTML = "Nuits d'hotel : 0";
			    hist_repas.innerHTML = "Repas : 0";
			    hist_km.innerHTML = "Kilomètres : 0";
		    }
		}
	});
	
}

function close_hf() {
	document.getElementById("arriere").style.display = "none";
	document.getElementById("cacher").style.display = "none";
}

function showAddHF() {
	document.getElementById("arriere").style.display = "block";
	document.getElementById("cacher").style.display = "block";
}

function addHF() {
	close_hf();
	var form_data = new FormData();  
	form_data.append('id_user', document.getElementById("id_user").innerHTML);
	form_data.append('libelle', libelle_input.value);
	form_data.append('date', date_input.value);
	form_data.append('montant', montant_input.value);
	form_data.append('hash', document.getElementById("hash").innerHTML);
	form_data.append('action', 'hf');
	form_data.append('file', document.getElementById('justif').files[0]);
	/*
	var id_user = document.getElementById("id_user").innerHTML;
	var libelle = libelle_input.value;
	var date = date_input.value;   
	var montant = montant_input.value; 
	var hash = document.getElementById("hash").innerHTML;
	*/

	$.ajax({
		url : 'communicate.php',
		type : 'POST',
		contentType: false,
		processData: false,
		data: form_data,
		/*
		data:{
			
			hash:hash,
			id_user:id_user,
			libelle:libelle,
			date:date,
			montant:montant,
			month: current_date.getMonth() + 1,
			year: current_date.getFullYear(),
			action:'hf'
			
		},
		*/
		success: function(response) {
			get_infos();
			updateMonth(0);
		}
	});
    /*
    var file_data = $('#sortpicture').prop('files')[0];   
    var form_data = new FormData();                  
    form_data.append('file', file_data);
    alert(form_data);                             
    $.ajax({
                url: 'upload.php', // point to server-side PHP script 
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
                success: function(php_script_response){
                    alert(php_script_response); // display response from the PHP script, if any
                }
     });
    */
}
function sign_out() {
	document.location.href = "index.php";
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
	var hash = document.getElementById("hash").innerHTML;
	var repas = repas_input.value;
	var nuits = nuits_input.value;   
	var km = km_input.value;   

	$.ajax({
		type: "POST",
		url: "communicate.php",
		data:{
			hash:hash,
			id_user:id_user,
			nuits:nuits,
			repas:repas,
			km:km,
			month: current_date.getMonth() + 1,
			year: current_date.getFullYear(),
			action:'forfait'
		},
		dataType : 'html',
	});
	document.getElementById("submit_btn").className  = "disabled";
	updateMonth(0);
}

function showHistory () {
	forfait_elements.style.left = "-100vw";
	hf_elements.style.left = "-53.4vw";

	document.getElementById("calendar").style.left = "40vw";
	document.getElementById("history_div").style.left = "30vw";

	document.getElementById("new_remboursement_div").style.backgroundColor = "#2d3845";
	document.getElementById("my_remboursements_div").style.backgroundColor = "white";
}

function showMonth() {
	forfait_elements.style.left = "6.6vw";
	hf_elements.style.left = "53.2vw";

	document.getElementById("calendar").style.left = "130vw";
	document.getElementById("history_div").style.left = "120vw";

	document.getElementById("new_remboursement_div").style.backgroundColor = "white";
	document.getElementById("my_remboursements_div").style.backgroundColor = "#2d3845";
}

function get_infos() {
	var id_user = document.getElementById("id_user").innerHTML;
	var hash = document.getElementById("hash").innerHTML;

	$.ajax({
		url : 'communicate.php',
		type : 'POST',
		dataType : 'html', 
		data:{
			hash:hash,
			id_user:id_user,
			month: current_date.getMonth() + 1,
			year: current_date.getFullYear(),
			action:'get_ff'
		},
		success : function(code_html, statut){
			var results = code_html;
			var array = results.split(";");
			console.log(array);
			nuit_input.value = array[0];
			repas_input.value = array[1];
			km_input.value = array[2];
		}
	});

	$.ajax({
		url : 'communicate.php',
		type : 'POST',
		dataType : 'html', 
		data:{
			hash:hash,
			id_user:id_user,
			month: current_date.getMonth() + 1,
			year: current_date.getFullYear(),
			action:'get_hf'
		},
		success : function(code_html, statut){
			blocks_div.innerHTML = "";
			var results = code_html;
			var array = results.split("|");
			console.log(array);
			array.forEach(function(element) {
				var infos = element.split(";");
				if (infos.length > 1) {
					var html_res = "<div class='hf_block'><label class='hf_block_title'>"+infos[0]+"</label><br><label class='hf_block_date'>"+infos[1]+"</label><label class='hf_block_montant'>"+infos[2]+" €</label><label class='id_hf' style='display:none'>"+infos[3]+"</label><img class='hf_block_close' src='close_btn.png' onclick='deleteHF(this)'>";
					if (infos[4].length > 1) {
						html_res += "<a class='link' href='"+infos[4]+"'>justificatif</a>";
					}
					html_res += "</div>";
					blocks_div.innerHTML += html_res;
					blocks_div.scrollTop += 100;
				}
			});
		}
	});
}

function deleteHF(element)
{
	var id_user = document.getElementById("id_user").innerHTML;
	var hash = document.getElementById("hash").innerHTML;

	var id_hf = element.parentElement.getElementsByClassName("id_hf")[0].innerHTML;
	$.ajax({
		url : 'communicate.php',
		type : 'POST',
		dataType : 'html', 
		data:{
			hash:hash,
			id_user:id_user,
			id_hf:id_hf,
			month: current_date.getMonth() + 1,
			year: current_date.getFullYear(),
			action:'deletehf'
		},
		success: function(response) {
			element.parentElement.remove();
			get_infos();
			updateMonth(0);
		}
	});
	
}

function check_data()
{
	var id_user = document.getElementById("id_user").innerHTML;
	var hash = document.getElementById("hash").innerHTML;

	$.ajax({
		url : 'communicate.php',
		type : 'POST',
		dataType : 'html', 
		data:{
			hash:hash,
			id_user:id_user,
			month: current_date.getMonth() + 1,
			year: current_date.getFullYear(),
			action:'new_month'
		},
		success: function(response) {
			console.log(response);
			get_infos();
		}
	});
	
}

$( function() {
	$( "#datepicker" ).datepicker( {
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		dateFormat: 'MM yy',
		defaultDate: history_date,
		onClose: function(dateText, inst) { 
			$(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
			var mydate = new Date(inst.selectedYear, inst.selectedMonth, 1);
			updateMonth(mydate.getMonth() - history_date.getMonth() + (12 * (mydate.getFullYear() - history_date.getFullYear())));

		},
	});
} );
