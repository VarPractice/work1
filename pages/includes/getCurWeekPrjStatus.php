<?php
	include_once("executers.php");
	if(!isset($_SESSION['user_auth_id']))
	{
		header("Location:".url);
	}
	if(!isset($_GET['prj_id']))
	{
		exit("invalid input received");
	}
	// Binding request data with variables
	$prj_id=$_GET['prj_id'];
	// Creating SQL Connection
	$con=create_sqlConnection();
	$projStats='';//declaring & intializing a variable
	$week=getCurWeekNYear();
	// $week="50,2016";
	
	$projStats=getPrjStatsOfWeek($prj_id, $week,$con); //week={weeknum,year} format
	
	// 	Gitting all project Names
    echo $projStats;

    // Closing Db connection
	close_sqlConnection($con);
?>