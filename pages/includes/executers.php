<?php
	if (session_status() == PHP_SESSION_NONE) 
	{
    		session_start();
	}
	//	Database details
	define("url", "http://10.102.150.145/Maritz_dashboard/");
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

    			// 	Gitting all project Names
    			$i=0;
    			foreach ($projects as $value)
    			{
    				$prj_name=getProjectName($value, $con);
    				$project_list[$i]=array('id'=>$value,'name'=>$prj_name);
    				$i++;
    			}
    			unset($value);
    			unset($i);
    			return json_encode($project_list);
			}
		}
    	catch (Exception $e) 
    	{
			echo "Exception_getProjects";
		}
	}
	// ********************** This function Returns All the employees under given supervisor *******************//
	function getEmpUnderSup($sup_id, $con)
	{
		try 
		{
			// Retrieving current Employees projects
			$res=exeQuery("select `projects` from `dashboard_users` where `emp_id`='$sup_id'",$con);
			$row = $res->fetch_assoc(); // As we alaways get only one row result set, no need of looping statements.
			$prj_ids=substr($row['projects'], 0, -1); // This removes the Coma(,) presented at the end of result
			$sup_projects=(explode(",",$prj_ids));
			// Preapring query string to retrieve all the users under current supervisor
			$query_strng="select * from `dashboard_users` a WHERE `emp_id`!='$sup_id' && (0";
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
?>