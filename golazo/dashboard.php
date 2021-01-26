
<?php
//Mubdiul
include("include/config.php");
include('include/database.inc.php');
$isReferee = false;
session_start();

if(!isset($_SESSION['user']))
{
	header("location:login.php");
	die();
}
else
{
	$user = $_SESSION['user'];
	$userReferee = getUserReferee($user[0]);
	$userGeneral = getUserGeneral($user[0]);
	if($userGeneral)
	{
		$activeTasks = fetchActiveTasks($user[0]);
		$completedTasks = fetchCompletedTasks($user[0]);
	}
	else
	{
		$isReferee = true;
		$activeTasks = fetchRefereeActiveAssignment($userReferee[1]);
		$completedTasks = fetchRefereeCompletedAssignment($userReferee[1]);
	}
	
	// syafiq
	if (isset($_GET["task"]) && isset($_GET["date"])) {
		$task = $_GET["task"];
		$date = $_GET["date"];
		addTask($user[0], $task, $date);
	}
	
	if (isset($_GET["id"])) {
		$taskID = $_GET["id"];
		$subtasks = showsubTask($taskID);
		if (isset($_GET["remove"]))
			removeTask($taskID);
	}
	else
		$subtasks = null;
	
	if (isset($_GET["nametask1"]) && isset($_GET["duedate1"]) && isset($_GET["taskID"])) {
		$task = $_GET["nametask1"];
		$duedate = $_GET["duedate1"];
		$taskID = $_GET["taskID"];
		addsubTask($task, $duedate, $taskID);
	}
		
	//fahmi
	if (isset($_GET["tid"])) {
		$taskID = $_GET["tid"];
		$subtasks = showsubTasks($taskID);
	}
	else
		$subtasks = null;
	
	if(isset($_GET['emailInv']) && isset($_GET['check'])){
		$email = $_GET['emailInv'];
		$taskID = $_GET['check'];
		$getUser = findUserIDbyEmail($email);
		$test = existingUser($getUser[0]);
		if(!$test){
			setRefereeID($getUser[0]);
			$refID = getRefereeID($getUser[0]);
		}
		else
			$refID = getRefereeID($getUser[0]);
		//echo $refID[0];
		$refe = setReferee($refID[0], $taskID);
		
	}
	
	if (isset($_GET["reminder"]) && isset($_GET["taskID"])) {
		$reminder = $_GET["reminder"];
		$taskID = $_GET["taskID"];
		setReminder($taskID, $reminder);
	}
}
?>

<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="utf-8">
	<title>My Dashboard - Golazo</title>
	<link rel="icon" href="images/icon 2.png" type="image/png" sizes="16x18">
	<link rel="stylesheet" href="reset.css">
	<link rel="stylesheet" href="dashboard.css?v=<?php echo time(); ?>">
	<link rel="stylesheet" href="include/calendar/calendar.css">
	<script type="text/javascript" src="testScript.js" defer></script>
	<script type="text/javascript" src="fahmiScript.js" defer></script>
	<script type="text/javascript" src="include/calendar/calendar.js"></script>
	<link rel="stylesheet" href="showTaskDetailOnPress.css">
	<script type="text/javascript" src="showTaskDetailOnPress.js"></script>
	<script>clientID = <?php echo $user[0] ?></script>
	<script src="script.js" defer></script>
</head>
<body>
	<header>
		<table>
			<tr>
				<td>
					
					<div class="headerAlign">
						<img src="images/home.png" alt="logo" width="50" height="54">
						
						<!--<div class="title">-->
						<a href="dashboard.php">
							<img src="images/title.png" alt="logo" width="220" height="50">
						</a>
						<!--</div>-->
					</div>
					
				</td>
				<td>
					<h2 id="clickToShowProfile" onclick = "showProfile()">Hello, <?php echo $user[2]." ".$user[3] ?> &#9776;</h2>
				</td>
			</tr>
		</table>
	</header>
	<div class="boxSection1">
		<div class="showTaskDetail" id="profile" style="display:none">
		<div class="close" onclick=hideProfile()></div>
		<p class="profileLabel">Profile</p>
		<form action="" method="post" >
			<div class="center">
				<div class="profileDiv">
					<div class="left"><b>First Name</b></div> 
					<div class="right"><input id = "fname" type="text" name="firstName" value="<?php echo $user[2] ?>"></div>
				</div>
				<div class="profileDiv">
					<div class="left"><b>Last Name</b></div> 
					<div class="right"><input id = "lname" type="text" name="lastName" value="<?php echo $user[3] ?>"></div>
				</div>
				<div class="profileDiv">
					<div class="left"><b>Email:</b></div> 
					<div class="right"><input id = "email" type="text" name="email" value="<?php echo $user[1]?>"></div>
				</div>
				<div class="profileDiv">
					<div class="left"><b>Confirm New Email:</b></div> 
					<div class="right"><input id = "cEmail" type="text" name="confirmEmail"></div>
				</div>
				<div class="profileDiv">
					<div class="left"><b>Old Password:</b></div> 
					<div class="right"><input id = "opass" type="password" name="oldpassword"></div>
				</div>
				<div class="profileDiv">
					<div class="left"><b>New Password:</b></div> 
					<div class="right"><input id = "nPass" type="password" name="confirmPassword"></div>
				</div>
				<div class="profileDiv">
					<div class="left"><b>Confirm New Password:</b></div> 
					<div class="right"><input id = "cNPass" type="password" name="confirmNPassword"></div>
				</div>
				<div class="profileDiv">
					<div class="left"><p id="showError"></div> 
				</div>
				<div class="profileDiv">
					<div class="center" colspan="2"><input class="submit" type="button" value="Save" onclick="checkValue()"></div>
				</div>
			</div>
		</form>
	</div>
		<div class="sidebar">
			<ul>
				<div id="currentPage"><!--Mubdiul-added list-->
					<li><a onclick="showActiveTasks()">Active Tasks</a></li>
				</div>
				<div id="section2">
					<li ><a onclick="showCompletedTasks()">Completed Tasks</a></li>
				</div>
				<div id="section4">
					<li><a onclick="showRefereeRequest()">Referee Request</a></li>
				</div>
				<li><a href="logout.php">Logout</a></li>
				<li></li>
				<li><input onclick="selectInvite()" id="butinv" type="button" name="invitebutton" value="Invite Referee"></li>
			</ul>
	</div>
	<!--fahmi added javascript, css and php-->
		<div id="modelBack" class="model">
			<div id="showInvitation">
				<p class="titleInv">Invite a referee</p>
				<form action="dashboard.php" method="GET">
					<div class="leftall">
						<p class="left">Email: </p>
						<input class="righty" type="text" name="emailInv" value="">
					</div>
					<div class="leftall">
						<?php $Tasks = fetchActiveTasks($user[0]);
						foreach($Tasks as $namet) {?>
						<ul><label class="container"><?php echo $namet[2];?>
							<input type="checkbox" name="check[]" value="<?php echo $namet[0]?>">
							<span class="checkmark"></span>
						</label></ul>
						<?php } ?>
					</div>
					<div class="buttonInv">
					<Button class="buttSub" id="closebut" type="button">Cancel</button>
					<input class="buttSub" type="submit" name="submitinv" value="submit">
					</div>
				</form>
			</div>
		</div>
		<!--
		<div id="modelTask" class="model">
			<div id="content">
				<p class="titleInv">Algorithm Design and Analysis</p>
				<form action="dashboard.php" method="GET" >
				<div class="leftall"  >
					<p class="left" style="font-size:16px">1. Algo Quiz</p>
					<p class="righty">Due: Februari 21, 2019<button class="butStart">Start</button>
					</p>
				</div>
				<div class="leftall">
					<div>
						<p class="left">Task Name: </p>
						<input class="righty"  type="text" name="nametask1" value="">
					</div>
					<br>
					<div >
						<p class="left">Due date: </p>
						<input class="righty" style="width:20%;margin-left:3em" name="duedate1" value="">
					</div>
				</div>
				<div class="leftall" style="text-align:center">
					<button class="butStart" >Add Task</button>
				</div><br>
				<div class="leftall" style="border:1px solid #888">
					<h3>Reminders: </h3>
					<textarea class="leftall">Hello World</textarea>
					<div style="text-align:center;">
						<button class="butStart">Set Reminders</button>
					</div>
				</div><br>
				<div class="leftall" style="text-align:right;">
					
					<input class="buttSub" type="submit" name="deletetask" value="Delete Task">
					<input class="buttSub" type="submit" name="updatetask" value="Update">
				</div>
				</form>
			</div>
		</div>-->
	<div id="activeTasks">
		<div class="tasks"><!--Mubdiul-added list for each entry-->
		<?php
		$tasks = $activeTasks;
		$monthsInWord = array("January", "February", "March", "April", "May", "June", "July","August","September","October","November","December");
		if(!$isReferee)
		{
			echo "<ul>";
			foreach($tasks as $t)
			{
				$timestamp = strtotime($t[4]);
				echo "<li onclick='openTask(\"".$t[2]."\", \"".$t[0]."\")'>";
					echo "<div class=\"listOfAssignments\">";
						echo "<h3>".$t[2]."</h3>";
						echo "<p><em>Due: ";
						//echo date('d/m/y', $timestamp);
						echo $monthsInWord[date('m', $timestamp)-1]." ";
						echo date('d', $timestamp).", ";
						echo date('Y', $timestamp);
						echo "</em></p>";
						echo "<script>
							var dates = \"".date('d', $timestamp)."\";
							var months = \"".date('m', $timestamp)."\";
							var years = \"".date('Y', $timestamp)."\";
							var taskNames = \"".$t[2]."\";
							getDatabaseInfo(dates, months, years, taskNames);
						</script>";
					echo "</div>";
						echo "<div class=\"percentageDone\">";
						echo "<div class=\"chart\" style=\"--value: ".$t[3]."%\">";
						echo "<p>".$t[3]."</p>";
						echo "</div>";
					echo "</div>";
				echo "</li>";
			}
			echo "</ul>";
		}
		
		?>
		</div>
	</div>
	<!-- syafiq -->
		<?php if (isset($_GET["id"])) echo "<div id='modal2' class='modal' style='display:block'>"; else echo "<div id='modal2' class='modal' style='display:none'>";
		$id = $_GET["id"];?>
			<div class="content">
				<table align="center">
					<tr>
						<td align="center" colspan="2"><h2><?php echo $_GET["name"];?></h2></td>
					</tr>
					<tr>
						<td class="left" colspan="2" style="width:100%">
						<?php 
							if (!$subtasks)
								echo "No subtask added";
							
							else {
								$tasks = $subtasks;
								echo "<ol>";
									foreach ($tasks as $t){
										echo "<li>";
											echo "<div class=\"leftall\">";
											echo "<p class=\"left\" style=\"font-size:16px\">" . $t[1] . "</p>";
											echo "<p class=\"righty\"><em>Due: " . $t[2] . "</em></p>";
											echo "</div>";
										echo "</li>";
									}
								echo "</ol>";
							}
						?>
						</td>
					</tr>
					<form action="dashboard.php" method="GET">
					<tr>
						<td class="left" colspan="2" style="width:100%">
						<br>
							<fieldset>
								</legend><strong>Add Tasks</strong></legend>
								<div class="leftall"><br>
									<div>
										<p class="left">Task Name: </p>
										<input class="righty"  type="text" name="nametask1" value="" required>
									</div>
									<p>
									<input type="hidden" name="taskID" value="<?php echo $id;?>">
									</p>
									<div style="margin-top:0.5em">
										<p class="left">Due date: </p>
										<input class="righty" style="width:20%;margin-left:3em" type="date" name="duedate1" value="" required>
									</div>
									<div class="leftall" style="text-align:right">
										<input class="butStart" type="submit" value="Add Task">
									</div>
								</div>
							</fieldset>
						</td>
					</tr>
					</form>
					<form action="dashboard.php" method="GET">
					<tr>
						<td class="left" colspan="2" style="width:100%">
								<br><div class="leftall" style="border:1px solid #888">
									<h3>Reminders: </h3>
									<?php if (!fetchActiveTasks($user[0]))
											echo "<p>No Reminders";
										
										else {
											$tasks = fetchActiveTasks($user[0]);
											echo "<ul>";
												foreach ($tasks as $t){
													echo "<li style=\"list-style:none\">";
														echo "<p style=\"margin-top:0.8em\">".$t[8]."</p>";
													echo "</li>";
												}
											echo "</ul>";
									}?>
									<div class="leftall">
										<textarea class="leftall" name="reminder">Enter new reminders</textarea>
									</div>
									<input type="hidden" name="taskID" value="<?php echo $id;?>">
									<div style="text-align:right;">
										<input class="butStart" type="submit" value="Set Reminders">
									</div>
								</div>
						</td>
					</tr>
					</form>
					<tr>
						<td id="removeButton" align="center" colspan="2"><?php echo "<input class='submit' type='button' value='Remove Task' onclick='return removeTask(" . $id . ")'>";?></td>
					</tr>
				</table>
			</div>
		</div>
	<div id="completedTasks" style="display: none;"><!--Mubdiul-added list for each entry-->
		<div class="tasks">
		<?php
			$tasks = $completedTasks;
			if(!$isReferee)
			{
			echo "<ul>";
			foreach($tasks as $t)
			{
				$timestamp = strtotime($t[4]);
				echo "<li>";
					echo "<div class=\"listOfAssignments\">";
						echo "<h3>".$t[2]."</h3>";
						echo "<p><em>Due: ";
						echo $monthsInWord[date('m', $timestamp)-1]." ";
						echo date('d', $timestamp).", ";
						echo date('Y', $timestamp);
						echo "</em></p>";
						echo "<script>
							var dates = \"".date('d', $timestamp)."\";
							var months = \"".date('m', $timestamp)."\";
							var years = \"".date('Y', $timestamp)."\";
							var taskNames = \"".$t[2]."\";
							getDatabaseInfo(dates, months, years, taskNames);
						</script>";
					echo "</div>";
						echo "<div class=\"percentageDone\">";
						echo "<div class=\"chart\" style=\"--value: ".$t[3]."%\">";
						echo "<p>".$t[3]."</p>";
						echo "</div>";
					echo "</div>";
				echo "</li>";
			}
			echo "</ul>";
		}
		
		?>
		</div>
	</div>
	<div id="RefereeReq" style="display:none;">
		<div class="tasks">
		<?php
			$tasks = fetchRefereeActiveAssignment($userReferee[1]);
			$comptasks = fetchRefereeCompletedAssignment($userReferee[1]);
			$monthsInWord = array("January", "February", "March", "April", "May", "June", "July","August","September","October","November","December");
			if(!$isReferee){
				echo "<ul>";
				foreach($tasks as $t)
				{
					$timestamp = strtotime($t[4]);
					
					echo "<li onclick='openTasks(\"".$t[2]."\", \"".$t[0]."\")'>";
						echo "<div class=\"listOfAssignments\">";
							$taskByName = userInfo($t[1]);
							echo "<h3>Task by ".$taskByName[2]." ".$taskByName[3]."</h3>";
							echo "<h3><a href=\"\">".$t[2]."</a></h3>";
							echo "<p><em>Due: ";
							echo $monthsInWord[date('m', $timestamp)-1]." ";
							echo date('d', $timestamp).", ";
							echo date('Y', $timestamp);
							echo "</em></p>";
							echo "<script>
								var dates = \"".date('d', $timestamp)."\";
								var months = \"".date('m', $timestamp)."\";
								var years = \"".date('Y', $timestamp)."\";
								var taskNames = \"".$t[2]."\";
								getDatabaseInfo(dates, months, years, taskNames.concat(\"-by \", \"".$taskByName[2]."\"));
							</script>";
						echo "</div>";
							echo "<div class=\"percentageDone\">";
							echo "<div class=\"chart\" style=\"--value: ".$t[3]."%\">";
							echo "<p>".$t[3]."</p>";
							echo "</div>";
						echo "</div>";
					echo "</li>";
				}	
				echo "</ul>";
			}
			if(!$isReferee){
				echo "<ul>";
				foreach($comptasks as $t)
				{
					$timestamp = strtotime($t[4]);
					echo "<li>";
						echo "<div class=\"listOfAssignments\">";
							$taskByName = userInfo($t[1]);
							echo "<h3>Task by ".$taskByName[2]." ".$taskByName[3]."</h3>";
							echo "<h3><a href=\"\">".$t[2]."</a></h3>";
							echo "<p><em>Due: ";
							echo $monthsInWord[date('m', $timestamp)-1]." ";
							echo date('d', $timestamp).", ";
							echo date('Y', $timestamp);
							echo "</em></p>";
							echo "<script>
								var dates = \"".date('d', $timestamp)."\";
								var months = \"".date('m', $timestamp)."\";
								var years = \"".date('Y', $timestamp)."\";
								var taskNames = \"".$t[2]."\";
								getDatabaseInfo(dates, months, years, taskNames.concat(\"-by \", \"".$taskByName[2]."\"));
							</script>";
						echo "</div>";
							echo "<div class=\"percentageDone\">";
							echo "<div class=\"chart\" style=\"--value: ".$t[3]."%\">";
							echo "<p>".$t[3]."</p>";
							echo "</div>";
						echo "</div>";
					echo "</li>";
				}	
				echo "</ul>";
			}
		?>
		</div>
	</div>
	<?php if (isset($_GET["tid"])) echo "<div id='modal2' class='modal' style='display:block'>"; else echo "<div id='modal2' class='modal' style='display:none'>";
		$id = $_GET["tid"];?>
			<div class="content">
				<table align="center">
					<tr>
						<td align="center" colspan="2"><h2><?php echo $_GET["name"];?></h2></td>
					</tr>
					<tr>
						<td class="left" colspan="2" style="width:100%">
						<?php 
							if (!$subtasks)
								echo "No subtask added";
							
							else {
								$tasks = $subtasks;
								echo "<ol>";
									foreach ($tasks as $t){
										echo "<li>";
											echo "<div class=\"leftall\">";
											echo "<p class=\"left\" style=\"font-size:16px\">" . $t[1] . "</p>";
											echo "<p class=\"righty\"><em>Due: " . $t[2] . "</em></p>";
											echo "</div>";
										echo "</li>";
									}
								echo "</ol>";
							}
						?>
						</td>
					</tr>
					<!--<form action="dashboard.php" method="GET">
					<tr>
						<td class="left" colspan="2" style="width:100%">
						<br>
							<fieldset>
								</legend><strong>Add Tasks</strong></legend>
								<div class="leftall"><br>
									<div>
										<p class="left">Task Name: </p>
										<input class="righty"  type="text" name="nametask1" value="" required>
									</div>
									<p>
									<input type="hidden" name="taskID" value="<?php //echo $id;?>">
									</p>
									<div style="margin-top:0.5em">
										<p class="left">Due date: </p>
										<input class="righty" style="width:20%;margin-left:3em" type="date" name="duedate1" value="" required>
									</div>
									<div class="leftall" style="text-align:right">
										<input class="butStart" type="submit" value="Add Task">
									</div>
								</div>
							</fieldset>
						</td>
					</tr>
					</form>-->
					<form action="dashboard.php" method="GET">
					<tr>
						<td class="left" colspan="2" style="width:100%">
								<br><div class="leftall" style="border:1px solid #888">
									<h3>Reminders: </h3>
									<?php if (!fetchRefereeActiveAssignment($userReferee[1]))
											echo "<p>No Reminders";
										
										else {
											$tasks = fetchRefereeActiveAssignment($userReferee[1]);
											echo "<ul>";
												foreach ($tasks as $t){
													echo "<li style=\"list-style:none\">";
														echo "<p style=\"margin-top:0.8em\">".$t[8]."</p>";
													echo "</li>";
												}
											echo "</ul>";
									}?>
									<div class="leftall">
										<textarea class="leftall" name="reminder">Enter new reminders</textarea>
									</div>
									<input type="hidden" name="taskID" value="<?php echo $id;?>">
									<div style="text-align:right;">
										<input class="butStart" type="submit" value="Set Reminders">
									</div>
								</div><br>
								<div style="text-align:right">
									<a class="buttSub" href="dashboard.php" style="text-decoration:none">Close</a>
								</div>
						</td>
					</tr>
					</form>
					<!--<tr>
						<td id="removeButton" align="center" colspan="2"><?php //echo "<input class='submit' type='button' value='Remove Task' onclick='return removeTask(" . $id . ")'>";?></td>
					</tr>-->
				</table>
			</div>
		</div>
		<!--Mubdiul- added Calender/deadline-->
		<div class="lefSideBar">
		<!--Calander php will go here-->
			<?php include("include/calendar/calendar.php")?>
		</div>
	</div>
	<footer>
		<!--Mubdiul-added footer all-->
		<div class="footer1">
			<div class="footerleft">
				<a href="noLink">About Us</a>
				<a href="noLink">Terms And Conditions</a>
				<a href="noLink">Privacy Policy</a>
			</div>
			<div class="footerRight">
				<img class="footerLogo" src="images/MMU_LOGO.png" alt="logo" width="140" height="40">
			</div>
			
		</div>
		<button id="button" type="button">+
			<span class="tooltip">Add</span>
		</button>
		<div id="modal" class="modal2">
			<form class="content2" action="dashboard.php" method="GET">
				<table align="center">
				<tr>
					<td class="left"><b>Task Name:</b></td> 
					<td align="right"><input type="text" name="task" required></td>
				</tr>
				<tr>
					<td class="left"><b>Due Date:</b></td> 
					<td align="right"><input type="date" name="date" required></td>
				</tr>
				<tr>
					<td align="center" colspan="2"><input class="submit" type="submit" value="Add Task"></td>
				</tr>
				</table>
				<button class="close2" type="button">&times;<span class="tooltip">Back</span></button>
			<form>
		</div>	
	</footer>
</body>
</html>