<?php
	if (session_status() == PHP_SESSION_NONE) 
	{
    		session_start();
	}
	//	Database details
	define("url", "http://10.102.180.148:3/Maritz_dashboard/");
	define('my_sql_host','localhost');
	define('my_sql_unm','root');
	define('my_sql_pwd','');
	define('db','dashboard_projects');

	//	defined usable functions
	function create_sqlConnection()
	{
		// $con=mysqli_connect(my_sql_host,my_sql_unm,my_sql_pwd) or die("Unable to connect to mysql");
		$con=new mysqli(my_sql_host,my_sql_unm,my_sql_pwd,db)or die("Unable to connect to mysql");
		if($con->connect_error)
		{
			die("SQL Connection Failed: ".$con->connect_error);
		}
		return $con;
	}
	function connect_db($dbname,$con)
	{
		mysql_select_db($con,$dbname) or die("Unable to connect to DB");
	}
	/*function connect_db($con)
	{
		mysqli_select_db($con,db) or die("Unable to connect to DB");
	}*/
	function close_sqlConnection($con)
	{
		// mysqli_close($con) or die("Unable to close mysql connection");
		$con->close() or die("Unable to Close SQl Connection");
	}
	function exeQuery($query,$con)
	{
		// mysqli_query($con,$query) or die("Unable to Query");
		$res=$con->query($query) or die("Query Execution Failed.! ".$con->error);
		return $res;
	}
	// **************** This function Returns Current week & year in {W,yyy} format***************//
	function getCurWeekNYear()
	{
		// Setting variables for some required data
		$cur_week_number=date("W");
		$cur_week_day=date("D");
		$cur_month=date("m");
		$cur_year=date("Y");
		// Updating Week number to for Weekly status log *** If the current day is monday the status should be stored as previous weeks status
		// an employee is alowed to log his weekly status by Monday, so status logged on monday will be concidered as previous weeks
		if($cur_week_day=="Mon")
		{
			$date = new DateTime(date('dmy'));
			date_modify($date,"-1 days");
			$cur_week_number = $date->format("W");
		}
		// Updating Year based on the week number & if month=Jan
		if($cur_month==1 && $cur_week_number>50)
		{
			$cur_year--;
		}
		// Updating Year based on the week number & if month=Dec
		if($cur_month==12 && $cur_week_number==1)
		{
			$cur_year++;
		}
		// Appending Current year to week number to process Reports date easily in future
		return $cur_week_number.",".$cur_year;
	}
	// ********************** This function Returns project Name by it's Id *******************//
	function getProjectName($prj_id, $con)
	{
		try 
		{
			$res=exeQuery("select `Name` from `projects` where `id`='$prj_id'",$con);
			if($res->num_rows > 0)
			{
				// Getting project Name from Projects Table
				$row = $res->fetch_assoc(); // As we alaways get only one row result set, no need of looping statements.
				return $row['Name'];
			}
		}
    	catch (Exception $e) 
    	{
			echo "exception";
		}
	}
	// ********************** This function Returns JSON file projects names(id,name) *******************//
	function getJsonProjectNames($project_list,$con)
	{
		try 
		{
			// 	Gitting all project Names
    		$i=0;
    		foreach ($project_list as $value)
    		{
    			$prj_name=getProjectName($value, $con);
    			$project_list[$i]=array('id'=>$value,'name'=>$prj_name);
    			$i++;
    		}
    		unset($value);
    		unset($i);
    		return json_encode($project_list);
		} 
		catch (Exception $e) 
		{
			
		}
	}
	// ********************** This function Returns projects associated to an employee *******************//
	function getAccountProjects($acc_id, $con)
	{
		try 
		{
			$res=exeQuery("select id from `projects` where `Acc Id`='$acc_id'",$con);
			if($res->num_rows > 0)
			{
				// Getting All project Numbers from Users Table
				$prj_ids="";
				while($row = $res->fetch_assoc()) 
				{
					$prj_ids.=$row['id'].",";
				}
				$prj_ids=substr($prj_ids, 0, -1);
				$projects=(explode(",",$prj_ids));

    			return getJsonProjectNames($projects,$con);
			}
		}
    	catch (Exception $e) 
    	{
			echo "Exception_getProjects";
		}
	}
	// ********************** This function Returns projects associated to an employee *******************//
	function getEmpProjects($emp_id, $con)
	{
		try 
		{
			$res=exeQuery("select `projects` from `dashboard_users` where `emp_id`='$emp_id'",$con);
			if($res->num_rows > 0)
			{
				// Getting All project Numbers from Users Table
				$row = $res->fetch_assoc(); // As we alaways get only one row result set, no need of looping statements.
				$prj_ids=substr($row['projects'], 0, -1); // This removes the Coma(,) presented at the end of result
				$projects=(explode(",",$prj_ids));

    			// return implode(",", $projects);
				return getJsonProjectNames($projects,$con);
    			
			}
		}
    	catch (Exception $e) 
    	{
			echo "Exception_getProjects";
		}
	}
	// ************* This function Returns All the employees under given supervisor ***************//
	function getEmpUnderSup($sup_id, $role, $con)
	{
		try 
		{
			// Retrieving current Employees projects
			$res=exeQuery("select `projects` from `dashboard_users` where `emp_id`='$sup_id'",$con);
			$row = $res->fetch_assoc(); // As we alaways get only one row result set, no need of looping statements.
			$prj_ids=substr($row['projects'], 0, -1); // This removes the Coma(,) presented at the end of result
			$sup_projects=(explode(",",$prj_ids));
			// Preapring query string to retrieve all the users under current supervisor
			$query_strng="select * from `dashboard_users` a WHERE `emp_id`!='$sup_id' && `role`>'$role' && (0";
			foreach($sup_projects as $p_id)
			{
				$query_strng.="||find_in_set('$p_id',a.projects)";
			}
			$query_strng.=")";// closing the paranthesis to complete the syntax
	
			// Retreiving all employees under logged in supervisor
			return exeQuery($query_strng,$con);
		}
    	catch (Exception $e) 
    	{
			echo "Exception_getEmpUnderSup";
		}
	}
	// ********This function Returns common projects of given employees *****//
	function getCommonProjects($emp1,$emp2,$con)
	{
		try 
		{
			 $res=exeQuery("select `projects` from `dashboard_users` where `emp_id` in ('$emp1','$emp2')",$con);
			 /*** Under development*****/
			 return "";
		}
		catch (Exception $e)
		{
			echo "Exception_getCommonProjects";
		}
	}
	// ********This function Returns common projects of given employees *****//
	function getPrjStatsOfWeek($prj_id,$week)
	{
		try 
		{
			$prjStats="";
			$con=create_sqlConnection();
			$res=exeQuery("select * from `project_maritz` where `for week` ='$week' and `project id`='$prj_id'",$con);
			if($res->num_rows <= 0)
			{
				return json_encode($prjStats);
			}
			$row = $res->fetch_assoc(); // As we alaways get only one row result set, no need of looping statements.
			$prjStats[0]['week']=$row['for week'];
			$prjStats[0]['poc']=$row['point of contact'];
			$prjStats[0]['tm_size']=$row['team_size'];
			$prjStats[0]['sprnt_endDate']=$row['sprint_end_date'];
			$prjStats[0]['cur_wrk']=$row['current work'];
			$prjStats[0]['ftr_wrk']=$row['future work'];
			$prjStats[0]['chlngs']=$row['challenges'];
			$prjStats[0]['qlty']=$row['quality'];
			$prjStats[0]['impact']=$row['impact'];
			$prjStats[0]['execution']=$row['execution'];
			$prjStats[0]['design']=$row['design'];
			$prjStats[0]['rampdown']=$row['ramupdown'];

			return json_encode($prjStats);
		}
		catch (Exception $e)
		{
			echo "Exception_getCommonProjects";
		}
	}
?>