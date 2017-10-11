$("#comptable").on("click", function(){
	$("#divconnexion").css("left", "0vw");
	$("#divindex").css("left", "-100vw");
});
$("#previous").on("click", function(){
	$("#divindex").css("left", "0vw");
	$("#divconnexion").css("left", "100vw");
});
$("#visiteur").on("click", function(){
	$("#divcomptable").css("left", "0vw");
	$("#divindex").css("left", "-100vw");
});
$("#previouss").on("click", function(){
	$("#divindex").css("left", "0vw");
	$("#divcomptable").css("left", "100vw");
});