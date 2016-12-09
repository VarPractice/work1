<?php
	include_once("executers.php");
	if(!isset($_SESSION['user_auth_id']))
	{
		header("Location:".url);
	}
	$emp_id=$_SESSION['user_auth_id'];
	// Creating SQL Connection
	$con=create_sqlConnection();
	// below function gets projects tagged to logged in Employee
	$projects=getEmpProjects($emp_id, $con);
	// 	Gitting all project Names
    echo $projects;

    // Closing Db connection
	close_sqlConnection($con);
?>