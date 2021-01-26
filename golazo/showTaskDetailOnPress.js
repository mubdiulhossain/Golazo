//Mubdiul
var clientID;

function checkValue()
{
	document.getElementById("showError").innerHTML = "";
	fname = document.getElementById("fname").value;
	lname = document.getElementById("lname").value;
	email = document.getElementById("email").value;
	cEmail = document.getElementById("cEmail").value;
	opass = document.getElementById("opass").value;
	npass = document.getElementById("nPass").value;
	cnpass = document.getElementById("cNPass").value;
	console.log(email);
	if(cEmail!="")
	{
		if(cEmail!=email)
		{
			document.getElementById("showError").innerHTML = "";
			document.getElementById("showError").innerHTML = "Emails doesn't match";
		}
		else
		{
			document.getElementById("showError").innerHTML = "";
			if (window.XMLHttpRequest) 
			{
				xmlhttp = new XMLHttpRequest();
			}	
			else 
			{
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function() 
			{
				if (this.readyState == 4 && this.status == 200) 
				{
					document.getElementById("showError").innerHTML = this.responseText;
				}
			};
			xmlhttp.open("POST","include/userSaveData.php",true);
			xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
			xmlhttp.send("user="+clientID+"&email="+email+"&opass="+opass);
		}
	}
	else
	{
		if(npass!="")
		{
			if(npass!=cnpass)
			{
				document.getElementById("showError").innerHTML = "";
				document.getElementById("showError").innerHTML = "Password doesn't match";
			}
			else
			{
				document.getElementById("showError").innerHTML = "";
				if (window.XMLHttpRequest) 
				{
					xmlhttp = new XMLHttpRequest();
				}	
				else 
				{
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						document.getElementById("showError").innerHTML = this.responseText;
					}
				};
				xmlhttp.open("POST","include/userSaveData.php",true);
				xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
				xmlhttp.send("user="+clientID+"&npass="+npass+"&opass="+opass);
			}
		}
		else
		{
			if(fname==""||lname=="")
			{
				document.getElementById("showError").innerHTML = "Name Cannot be empty";
			}
			else
			{
				document.getElementById("showError").innerHTML = "";
				if (window.XMLHttpRequest) 
				{
					xmlhttp = new XMLHttpRequest();
				}	
				else 
				{
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange = function() 
				{
					if (this.readyState == 4 && this.status == 200) 
					{
						document.getElementById("showError").innerHTML = this.responseText;
					}
				};
				xmlhttp.open("POST","include/userSaveData.php",true);
				xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
				xmlhttp.send("user="+clientID+"&fname="+fname+"&lname="+lname+"&opass="+opass);
			}
		}
	}
}