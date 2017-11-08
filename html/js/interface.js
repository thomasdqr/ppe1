var blocks_div = document.getElementById("hf_blocks");
function addHF() {
	blocks_div.innerHTML += "<div class='hf_block'></div>";
	blocks_div.scrollTop += 100;
}
$('#hf_div').on('click', function(){
	$('#arriere').css('display', 'block')
	$('#cacher').css('display', 'block');
$('#close').on('click', function(){
	$('#arriere').css('display', 'none')
	$('#cacher').css('display', 'none');
})


});