var blocks_div = document.getElementById("hf_blocks");
function addHF() {
	blocks_div.innerHTML += "<div class='hf_block'></div>";
	blocks_div.scrollTop += 100;
}