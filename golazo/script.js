function toSignUp() {
	location.href = "sign_up.html";
}

var modal = document.getElementById("modal");

var btn = document.getElementById("button");
btn.onclick = function() {
	modal.style.display = "block";
}

var btn2 = document.getElementsByClassName("close2")[0];
btn2.onclick = function() {
	modal.style.display = "none";
}

function removeTask(taskID) {
	if (confirm("Are you sure you want to delete this task?"))
		location = "dashboard.php?id=" + taskID + "&remove=1";
}	

var modal2 = document.getElementById("modal2");

function openTask(taskName, taskID) {
	location = "dashboard.php?id=" + taskID + "&name=" + taskName;
}

function openTasks(taskName, taskID) {
	location = "dashboard.php?tid=" + taskID + "&name=" + taskName;
}

window.onclick = function(event) {
  if (event.target == modal2) {
    modal2.style.display = "none";
  }
}