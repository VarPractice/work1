<?php
	include_once("executers.php");
	if(!isset($_SESSION['user_auth_id']))
	{
		header("Location:".url);
	}
	if(!isset($_GET['for']) || !($_GET['for']=='emp' || $_GET['for']=='account'))
	{
		exit("invalid input received");
	}
	// Creating SQL Connection
	$con=create_sqlConnection();
	$projects='';//declaring & intializing a variable
	// below function gets projects tagged to logged in Employee
	if ($_GET['for']=='emp')
	{
		$emp_id=$_SESSION['user_auth_id'];
		$projects=getEmpProjects($emp_id, $con);
	}
	else
	{
		$account_id=1;
		$projects=getAccountProjects($account_id, $con);
	}

	
	// 	Gitting all project Names
    echo $projects;

    // Closing Db connection
	close_sqlConnection($con);
?>