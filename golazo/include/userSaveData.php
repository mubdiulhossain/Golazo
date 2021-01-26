<?php
//Mubdiul
include("config.php");
include('database.inc.php');


if (array_key_exists('user', $_POST)) 
{
	if(array_key_exists('opass', $_POST))
	{
		if(!checkPassword($_POST['user'], $_POST['opass']))
		{
			echo "Old password didn't matched";
		}
		else
		{
			if(array_key_exists('fname', $_POST)||array_key_exists('lname', $_POST))
			{
				
				changeFLName($_POST['user'], $_POST['fname'], $_POST['lname']);
				echo "Saved Successfully";
			}
			else
			{
				if(array_key_exists('npass', $_POST))
				{
					changePassword($_POST['user'], $_POST['npass']);
					echo "Saved Successfully";
				}
				else
				{
					if(array_key_exists('email', $_POST))
					{
						if(!checkEmailExist($_POST['email']))
						{
							changeEmail($_POST['user'], $_POST['email']);
							echo "Saved Successfully";
						}
						else
						{
							echo "Email exists already";
						}
					}
				}
			}
		}
	}
	//echo $user;
	
}


?>
