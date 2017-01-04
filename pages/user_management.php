<?php
	require_once("includes/executers.php");
	// Verifying whether requested user is logged in or not & whether he is authorized
	// $_SESSION["user_role"]>2 represents validating whether logged in user is Team leader/+
	if(!isset($_SESSION["user_auth_id"]) || !isset($_SESSION["user_role"]) || $_SESSION["user_role"]>2)
    {
        exit("You are not a authorized user!");
    }
    require_once("includes/header.php");
?>

	<div id="page-wrapper">
		<div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Employee management</h1>
                <div class="form-group">
                    <div id="emp_mngmt_msg" style="display: none" class="alert alert-danger">I'm wrong!</div>
                </div>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    	<div class="row">
<?php
	//
	$panel_open="<div class='col-lg-4'><div class='panel panel-info'>";
	$panel_head_open="<div class='panel-heading'>";
	$panel_body_open="<div class='panel-body'>";
	$panel_footer_open="<div class='panel-footer'>";
	$div_close="</div>";
	$panel_close="</div></div>";
	$test_data="<div class='form-group'>
                                            <label>In projects</label>
                                            <select multiple='' class='form-control'>
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </div>";
	// 	Connecting To db
	$con=create_sqlConnection();
	$res=getEmpUnderSup($_SESSION["user_auth_id"], $_SESSION["user_role"],$con);
	while ($row = $res->fetch_assoc()) 
	{
		// Getting projects of employee that are under Loggedin TL's Supervison
		// 			below function returns an array(k,v)
		$com_prjs=getCommonProjects($row['emp_id'], $_SESSION["user_auth_id"],$con);
		// Printing Employee data in panels
		echo $panel_open.
				$panel_head_open.
					"Id: ".$row['emp_id'].", Name: ".$row['First Name']." ".$row['Last Name'].
				$div_close.
				$panel_body_open.
					$test_data.
				$div_close.
				$panel_footer_open.
					" <button class='btn btn-default'> Save </button> ".
				$div_close.
			$panel_close;
	}
?>
        </div>
	</div>
<!-- Adding page level Scripts -->
<?php
    require_once("includes/footer.php");
?>