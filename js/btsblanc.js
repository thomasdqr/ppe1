var MyTab = document.getElementById("MyTable");
GenerateTab();
function GenerateTab() {
	for (var i = 0; i < 5; i++) {
		var row = mytable.insertRow(i);
		for (var j = 0; j < 5; j++) {
			var div = document.createElement("div");
			div.setAttribute("id", "blank");
			var cell = row.insertCell(j);
			cell.appendChild(div);
		}
	}
	FillTab();
}

function FillTab() {
	var NumbersPositions = [[]];
	var PositionsUsed = [];
	for (var i = 0; i <= 9; i++) {
		var posx = Math.floor(Math.random() * 5);
		var posy = Math.floor(Math.random() * 5);
		var position = posx.toString() + posy.toString();
		
		while (jQuery.inArray(position, PositionsUsed) !== -1) {
			var posx = Math.floor(Math.random() * 5);
			var posy = Math.floor(Math.random() * 5);
			var position = posx.toString() + posy.toString();
		}
		
		PositionsUsed.push(position);
		var posToInsert = [posx, posy];
		NumbersPositions.unshift(posToInsert);
	}
	console.log(NumbersPositions);
	// Filling the TAB :
	for (var i = 0; i < 10; i++) {
		mytable.rows[NumbersPositions[i][0]].cells[NumbersPositions[i][1]].innerHTML = "<div id='numpad' onclick='TapPad("+i+")'>"+i+"</div>";
	}
}

function TapPad(number) {
	document.getElementById("code").value = document.getElementById("code").value + number;
}