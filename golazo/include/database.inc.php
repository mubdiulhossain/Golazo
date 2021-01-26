<?php
//Mubdiul
function setConnectionInfo($values=array())
{
	$connString=$values[0];
	$user=$values[1];
	$password=$values[2];
	
	$pdo = new PDO($connString, $user, $password);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $pdo;
}
function runQuary($pdo, $sql, $parameters=array())
{
	if(!is_array($parameters))
	{
		$parameters=array($parameters);
	}
	$statement = null;
	if((count($parameters)>0))
	{
		$statement=$pdo->prepare($sql);
		$executedOk = $statement->execute($parameters);
		if(!$executedOk)
		{
			throw new PDOException;
		}
	}
	else
	{
		$statement = $pdo->query($sql);
		if(!$statement)
		{
			throw new PDOException;
		}
	}
	return $statement;
}
function findUserID($email, $password)
{
	$pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
	$statement = runQuary($pdo, "SELECT * FROM user WHERE email = ? and password = ?", array($email, $password));
	$row = $statement->fetch();
	return $row;
}
function fetchActiveTasks($userID)
{
	$pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
	$statement = runQuary($pdo, "SELECT * FROM tasks WHERE userID = ? and taskStatus = 'active'", array($userID));
	return $statement;
}
function fetchCompletedTasks($userID)
{
	$pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
	$statement = runQuary($pdo, "SELECT * FROM tasks WHERE userID = ? and taskStatus = 'completed'", array($userID));
	return $statement;
}
function getUserReferee($userType)
{
	$pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
	$statement = runQuary($pdo, "SELECT * FROM referee WHERE userID = ?", array($userType));
	$row = $statement->fetch();
	
	return $row;
}
function getUserGeneral($userType)
{
	$pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
	$statement = runQuary($pdo, "SELECT * FROM generaluser WHERE userID = ?", array($userType));
	$row = $statement->fetch();
	
	return $row;
}
function fetchRefereeActiveAssignment($refereeID)
{
	$pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
	$statement = runQuary($pdo, "SELECT * FROM tasks WHERE refereeID = ? and taskStatus = 'active'", array($refereeID));	
	return $statement;
}
function fetchRefereeCompletedAssignment($refereeID)
{
	$pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
	$statement = runQuary($pdo, "SELECT * FROM tasks WHERE refereeID = ? and taskStatus = 'completed'", array($refereeID));	
	return $statement;
}
function userInfo($userID)
{
	$pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
	$statement = runQuary($pdo, "SELECT * FROM user WHERE userID = ?", array($userID));
	$row = $statement->fetch();
	return $row;
}
function checkPassword($userID, $pass)
{
	$pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
	$statement = runQuary($pdo, "SELECT * FROM user WHERE userID = ? and password = ?", array($userID, $pass));
	$row = $statement->fetch();
	return $row;
}
function changeFLName($userID, $fname, $lname)
{
	$pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
	$statement = runQuary($pdo, "UPDATE user SET firstName = ?, lastName = ? where userID = ?", array($fname, $lname, $userID));
}
function changePassword($userID, $pass)
{
	$pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
	$statement = runQuary($pdo, "UPDATE user SET password = ? where userID = ?", array($pass, $userID));
}
function checkEmailExist($email)
{
	$pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
	$statement = runQuary($pdo, "SELECT * FROM user WHERE email = ?", array($email));
	$row = $statement->fetch();
	return $row;
}
function changeEmail($userID, $email)
{
	$pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
	$statement = runQuary($pdo, "UPDATE user SET email = ? where userID = ?", array($email, $userID));
}
// syafiq
function addTask($userID, $task, $date) {
	try {
		$pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
		$sql = "INSERT INTO tasks (userID, taskTitle, taskDueDate, taskStatus) VALUES (?, ?, ?, 'active')";
		$statement = $pdo->prepare($sql);
		$statement->bindValue(1, $userID);
		$statement->bindValue(2, $task);
		$statement->bindValue(3, $date);
		$statement->execute();
		echo "<script type='text/javascript'>location.href = 'dashboard.php';</script>";
	}
	catch (PDOException $e) {
		echo "<script type='text/javascript'>alert('Error while inserting data');</script>";
	}
}

function removeTask($taskID) {
	try {
		$pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
		$sql = "DELETE FROM tasks WHERE taskID = ?";
		$statement = $pdo->prepare($sql);
		$statement->bindValue(1, $taskID);
		$statement->execute();
		echo "<script type='text/javascript'>location.href = 'dashboard.php';</script>";
	}
	catch (PDOException $e) {
		echo "<script type='text/javascript'>alert('Error while deleting data');</script>";
	}
}

function showsubTask($taskID) {
	try {
		$pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
		$sql = "SELECT * FROM subtasks WHERE taskID = ?";
		$statement = runQuary($pdo, $sql, array($taskID));
		return $statement;
	}
	catch (PDOException $e) {
		echo "<script type='text/javascript'>alert('Error while retrieving data');</script>";
	}
}
function addsubTask($task, $duedate, $taskID) {
	try {
		$pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
		$sql = "INSERT INTO subtasks (subtaskTitle, subtaskDueDate, taskID) VALUES (?, ?, ?)";
		$statement = $pdo->prepare($sql);
		$statement->bindValue(1, $task);
		$statement->bindValue(2, $duedate);
		$statement->bindValue(3, $taskID);
		$statement->execute();
		echo "<script type='text/javascript'>location = 'dashboard.php';</script>";
	}
	catch (PDOException $e) {
		echo "<script type='text/javascript'>alert('Error while inserting data');</script>";
	}
}
//fahmi
function showsubTasks($taskID) {
	try {
		$pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
		$sql = "SELECT * FROM subtasks WHERE taskID = ?";
		$statement = runQuary($pdo, $sql, array($taskID));
		return $statement;
	}
	catch (PDOException $e) {
		echo "<script type='text/javascript'>alert('Error while retrieving data');</script>";
	}
}
function findUserIDbyEmail($email)
{
	$pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
	$statement = runQuary($pdo, "SELECT userID FROM user WHERE email = ?", array($email));
	$row = $statement->fetch();
	return $row;
}

function setRefereeID($userID){
	try{
		$pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
		$sql = "INSERT INTO referee (userID) VALUES (?)";
		$statement = $pdo -> prepare($sql);
		$statement -> bindValue(1, $userID);
		$statement->execute();
	}
	
	catch(PDOException $e){
		echo "<script type='text/javascript'>alert('Error while inserting data');</script>";
		
	}
}
function getRefereeID($userID){
	$pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
	$sql = "SELECT refereeID FROM referee where userID = ?";
	$statement= $pdo -> prepare($sql);
	$statement -> bindValue(1, $userID);
	$statement -> execute();
	$row = $statement->fetch();
	return $row;
}
function existingUser($UserID){
	$pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
	$sql = "SELECT COUNT(userID) FROM referee where userID = ?";
	$statement = $pdo -> prepare($sql);
	$statement -> bindValue(1, $UserID);
	$statement->execute();
	$count = $statement-> fetchColumn();
	return $count;
}

function setReferee($refID, $task=array()){
	foreach($task as $value){
		$pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
		$sql = "UPDATE tasks SET refereeID ='$refID' where taskID = $value";
		$count = $pdo->exec($sql);
		
	}
}

function setReminder($ID, $reminder){
		try {
			$pdo = setConnectionInfo(array(DBCONNECTION,DBUSER,DBPASS));
			$statement = runQuary($pdo, "UPDATE tasks SET reminders = ? where taskID = ?", array($reminder, $ID));
			echo "<script type='text/javascript'>location = 'dashboard.php';</script>";
		}
		catch(PDOException $e){
			echo "<script type='text/javascript'>alert('Error while updating data');</script>";		
		}
}
?>