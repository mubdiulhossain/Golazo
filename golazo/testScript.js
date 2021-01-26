/*mubdiul*/
var currentPage = 1;
function showActiveTasks() 
{
	var activeTasks = document.getElementById("activeTasks");
	var completedTasks = document.getElementById("completedTasks");
	var refereeReq = document.getElementById("RefereeReq");
	
	activeTasks.style.display = "block";
	completedTasks.style.display = "none";
	refereeReq.style.display = "none";
	
	
	if(currentPage==2)
	{
		document.getElementById("currentPage").setAttribute("id", "section2");
	}
	if(currentPage==4)
	{
		document.getElementById("currentPage").setAttribute("id", "section4");
	}
	document.getElementById("section1").setAttribute("id", "currentPage");
	
	this.currentPage = 1;
}
function showCompletedTasks()
{
	var activeTasks = document.getElementById("activeTasks");
	var completedTasks = document.getElementById("completedTasks");
	var refereeReq = document.getElementById("RefereeReq");
	activeTasks.style.display = "none";
	completedTasks.style.display = "block";
	refereeReq.style.display = "none";
	
	if(currentPage==1)
	{
		document.getElementById("currentPage").setAttribute("id", "section1");
	}
	if(currentPage==4)
	{
		document.getElementById("currentPage").setAttribute("id", "section4");
	}
	document.getElementById("section2").setAttribute("id", "currentPage");
	
	this.currentPage = 2;
}

function showRefereeRequest(){
	var activeTasks = document.getElementById("activeTasks");
	var completedTasks = document.getElementById("completedTasks");
	var refereeReq = document.getElementById("RefereeReq");
	activeTasks.style.display = "none";
	completedTasks.style.display = "none";
	refereeReq.style.display = "block";
	
	if(currentPage==1)
	{
		document.getElementById("currentPage").setAttribute("id", "section1");
	}
	
	
	if(currentPage==2)
	{
		document.getElementById("currentPage").setAttribute("id", "section2");
	}
	document.getElementById("section4").setAttribute("id", "currentPage");
	
	this.currentPage = 4;
}

function showProfile()
{
	document.getElementById("profile").style.display="block";
}
function hideProfile()
{
	document.getElementById("profile").style.display="none";
	window.location.href = 'dashboard.php';
}