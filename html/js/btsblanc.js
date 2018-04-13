var MyTab = document.getElementById("MyTable");
GenerateTab();
function GenerateTab() {
	for (var i = 0; i < 5; i++) {
		var row = mytable.insertRow(i);
		for (var j = 0; j < 5; j++) {
			var cell = row.insertCell(j);
			cell.innerHTML="0";
		}
	}
}