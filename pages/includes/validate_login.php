<?php
	require_once("executers.php");
	// Catching Register data
	$user_id="";
	$uname=$_POST['mem_id'];
	$pwd=$_POST['mem_pwd'];
	// 	Connecting To db
	$con=create_sqlConnection();
	// Executing Query to get login details
	$res=exeQuery("select `password` from user_credentials where `emp id`='$uname'",$con);
	if($res->num_rows > 0)
	{
		while($row = $res->fetch_assoc()) 
		{
       		$user_pwd=$row['password'];
    	}
    	if($user_pwd==$pwd)
    	{
    		// Session Setup
    		$_SESSION['user_auth_id']=$uname;
    		// Geting user Role from DB
    		$res=exeQuery("select `role` from `dashboard_users` where `emp_id`='$uname'",$con);
    		$row = $res->fetch_assoc(); // As we alaways get only one row result set, no need of looping statements.
			$_SESSION['user_role']=$row['role'];
    		echo "success";
    	}	
    	else
	    {
    		echo "invalid credentials";
    	}
	}
	else
	{
			echo "User not Exist";
	}	
	// Closing Db connection
	close_sqlConnection($con);

?>