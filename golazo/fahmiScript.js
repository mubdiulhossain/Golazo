
var closepop = document.getElementById("closebut");
var closepoop= document.getElementById("closebutt");
var cross = document.getElementsByClassName("close1")[0];
var pop = document.getElementById("modelTask");

function selectInvite(){
	var opens = document.getElementById("modelBack");
	opens.style.display="block";
}

closepop.onclick = function(){
	var opens = document.getElementById("modelBack");
	opens.style.display="none";
}
/*closepoop.onclick = function(){
	var opens = document.getElementById("modal2");
	opens.style.display="none";
}*/

function selectTask(){
	
	pop.style.display="block";
}


window.onclick = function(event) {
  if (event.target == pop) {
    pop.style.display = "none";
  }
}


