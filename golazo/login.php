<?php
//Mubdiul
include("include/config.php");
include('include/database.inc.php');
$error = "";
$user = null;
session_start();
if(isset($_SESSION['user']))
{
	header("location:dashboard.php");
}
if($_SERVER["REQUEST_METHOD"] == "POST") 
{
	if(isset($_POST['email']) && isset($_POST['password']) )
	{
		$user = findUserID($_POST['email'], $_POST['password']);
	}
	else
	{
		$error = "Enter email and password";
	}
	if($user)
	{
		$_SESSION['user'] = $user;
		header("location: dashboard.php");
	}
	else
	{
		$error = "Invalid email or password";
	}
}

?>
<!DOCTYPLE html>
<html>
<head lang="en">
	<meta charset="utf-8">
	<title>Log In - Golazo</title>
	<link rel="icon" href="images/icon 2.png" type="image/png" sizes="16x18">
	<link rel="stylesheet" href="reset.css">
	<link rel="stylesheet" href="login.css">
</head>
<body>
	<header>
		<table>
			<tr>
				<td>
					<div class="headerAlign">
						<img src="images/home.png" alt="logo" width="50" height="54">
						<a href="home.html">
						<img src="images/title.png" alt="logo" width="220" height="50">
						</a>
					</div>
				</td>
			</tr>
		</table>
	</header>
	<div class="center">	
		<br>
		<form action="login.php" method="POST">
			<table align="center">
				<tr>
					<td class="left"><b>Email:</b></td> 
					<td align="right"><input type="text" name="email" required></td>
				</tr>
				<tr>
					<td class="left"><b>Password:</b></td> 
					<td align="right"><input type="password" name="password" required></td>
				</tr>
				<tr>
					<td align="center" colspan="2"><input class="submit" type="submit" value="Log In"></td>
				</tr>
				<tr>
					<td align="center" colspan="2"><?php echo $error; ?></td>
				</tr>
			</table>
		</form>
	</div>
	<footer>
		<div class="footer1">
			<div class="footerleft">
				<a href="noLink">About Us</a>
				<a href="noLink">Terms And Conditions</a>
				<a href="noLink">Privacy Policy</a>
			</div>
			<div class="footerRight">
				<img src="images/MMU_LOGO.png" alt="logo" width="140" height="45">
			</div>
		</div>
	</footer>
</body>
</html>