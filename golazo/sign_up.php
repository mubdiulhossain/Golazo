<?php
// syafiq
function setConnection() {	
	$host = "localhost";
	$user = "root";
	$pass = "";
	$db = "golazo";

	$conn = mysqli_connect($host, $user, $pass, $db);
		
	if (!$conn)
		die("Connection failed: " . mysqli_connect_error());
	else
		return $conn;
}

function existingUser($email) {
	$conn = setConnection();
	$sql = "SELECT email FROM user WHERE email='" . $email . "'";
	$result = mysqli_query($conn, $sql);
	$count = mysqli_num_rows($result);
	return $count;
}

function registerUser($first, $last, $email, $password) {
	$conn = setConnection();
	$sql = "INSERT INTO user (email, firstName, lastName, password) VALUES ('" . $email . "', '" . $first . "', '" . $last . "', '" . $password . "')";
	if (mysqli_query($conn, $sql))
		getUserID($email);
}

function getUserID($email) {
	$conn = setConnection();
	$sql = "SELECT userID FROM user WHERE email='" . $email . "'";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	setGeneralUser($row["userID"]);
}

function setGeneralUser($user) {
	$conn = setConnection();
	$sql = "INSERT INTO generaluser (userID) VALUES ('" . $user . "')";
	if (mysqli_query($conn, $sql)) 
		echo "<script type='text/javascript'>location.href = 'dashboard.php';</script>";
}

if (isset($_POST["first"]) && isset($_POST["last"]) && isset($_POST["emailaddress"]) && isset($_POST["password"]) && isset($_POST["confirmpassword"])) {
	$first = $_POST["first"];
	$last = $_POST["last"];
	$email = $_POST["emailaddress"];
	$password = $_POST["password"];
	$confirmpassword = $_POST["confirmpassword"];
	
	if (existingUser($email))
		echo "<script type='text/javascript'>alert('Email address already exists');</script>";
	else {
		if ($password == $confirmpassword) {
			registerUser($first, $last, $email, $password);
		}
		else
			echo "<script type='text/javascript'>alert('Passwords do not match');</script>";
	}
}
?>
<!DOCTYPLE html>
<html>
<head lang="en">
	<meta charset="utf-8">
	<title>Sign Up - Golazo</title>
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
		<form action="sign_up.php" method="post">
			<table align="center">
				<tr>
					<td class="left"><b>First Name:</b></td> 
					<td align="right"><input type="text" name="first" required></td>
				</tr>
				<tr>
					<td class="left"><b>Last Name:</b></td> 
					<td align="right"><input type="text" name="last" required></td>
				</tr>
				<tr>
					<td class="left"><b>Email:</b></td> 
					<td align="right"><input type="email" name="emailaddress" required></td>
				</tr>
				<tr>
					<td class="left"><b>Password:</b></td> 
					<td align="right"><input type="password" name="password" required></td>
				</tr>
				<tr>
					<td class="left"><b>Confirm Password:</b></td> 
					<td align="right"><input type="password" name="confirmpassword" required></td>
				</tr>
				<tr>
					<td align="center" colspan="2"><input class="submit" type="submit" value="Register"></td>
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