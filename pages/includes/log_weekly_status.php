<?php
	require_once("executers.php");
	// Catching Register data
	if(!isset($_SESSION["user_auth_id"]))
    {
        exit("invalid user");
    }
	// Getting all the Weekly log data from client
	try
	{
		$project_id=$_POST['project_id'];
		$team_size=$_POST['team_size'];
		$sprnt_date=$_POST['sprnt_date'];
		$prj_poc=$_POST['prj_poc'];
		$cur_wrk=$_POST['cur_wrk'];
		$futr_wrk=$_POST['futr_wrk'];
		$prj_chlng=$_POST['prj_chlng'];
		$prj_chlng_desc=$_POST['prj_chlng_desc'];
		$prj_qlty=$_POST['prj_qlty'];
		$prj_impact=$_POST['prj_impact'];
		$tst_exe=$_POST['tst_exe'];
		$tst_dsgn=$_POST['tst_dsgn'];
		$ram_up_dwn=$_POST['ram_up_dwn'];
		$appr_fl_pth=$_POST['appr_fl_pth'];
	}
	catch (Exception $e) 
	{
		exit("Unable to read the Weekly Status data");
	}
	// Storing Employee Id from session
	$emp_id=$_SESSION['user_auth_id'];
	// Setting variables for some required data
	$cur_week_number=date("W");
	$cur_week_day=date("D");
	$cur_year=date("Y");
	// Updating Week number to for Weekly status log *** If the current day is monday the status should be stored as previous weeks status
	if($cur_week_day=="Mon")
	{
		$cur_week_number--;
	}
	// Appending Current year to week number to get Reports date easily in future
	$cur_week_number=$cur_week_number.",".$cur_year;
	// 	Connecting To db
	$con=create_sqlConnection();
	// Setting the query string
	// Checking wehther status is already logged for current project
	$res=exeQuery("select `report id` from `project_maritz` where `for week`='$cur_week_number' and `project id`='$project_id'",$con);
	if($res->num_rows > 0)
	{
		$row = $res->fetch_assoc(); // As we alaways get only one row result set, no need of looping statements.
		$report_id=$row['report id'];
		// This will replace the existing status & insert current status
		$sts_log_query="update `project_maritz` set `point of contact`='$prj_poc',`team_size`='$team_size',`sprint_end_date`='$sprnt_date',`current work`='$cur_wrk', `future work`='$futr_wrk', `challenges`='$prj_chlng_desc', `quality`='$prj_qlty', `impact`='$prj_impact', `execution`='$tst_exe', `design`='$tst_dsgn', `ramupdown`='$ram_up_dwn', `appreciation`='$appr_fl_pth', `last updated by`='$emp_id' where `report id`='$report_id'";
	}
	else
	{
		// This will log new status
		$sts_log_query="insert into project_maritz(`for week`,`project id`,`point of contact`,`team_size`,`sprint_end_date`,`current work`, `future work`, `challenges`, `quality`, `impact`, `execution`, `design`, `ramupdown`, `appreciation`, `last updated by`)
	values('$cur_week_number','$project_id', '$prj_poc','$team_size','$sprnt_date', '$cur_wrk', '$futr_wrk', '$prj_chlng_desc', '$prj_qlty', '$prj_impact', '$tst_exe', '$tst_dsgn', '$ram_up_dwn', '$appr_fl_pth', '$emp_id')";
	}
	// Executing Query to get login details
	$res=exeQuery($sts_log_query,$con);
	// 	Varifying wether data is saved or not *** $con->insert_id returns the Id of last inserted record only if the data is successfully stored to DB
	// echo "Saved Record Id:",$con->insert_id;
	if($res)
	{
		echo "success";
	}
	else
	{
		echo "Unable to save";
	}
	// Closing Db connection
	close_sqlConnection($con);

?>