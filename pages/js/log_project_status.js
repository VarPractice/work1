/************************************************** This function Loads Projects assosiated to Loggedin Employee****************/
function setEmpProjects()
{
		var xmlhttp;
		if (window.XMLHttpRequest)
  		{
			// code for IE7+, Firefox, Chrome, Opera, Safari
  			xmlhttp=new XMLHttpRequest();
  		}
		else
  		{
			// code for IE6, IE5
  			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  		}		
		xmlhttp.onreadystatechange=function()
  		{
			
  			if (xmlhttp.readyState==4 && xmlhttp.status==200)
    		{
    			var x=JSON.parse(xmlhttp.responseText);
    			var projects="";
				for(var i=0; i<x.length;i++)
				{
					projects+="<option value='"+x[i].id+"'>"+x[i].name+"</option>";
				}
				document.getElementById("set-projects").innerHTML +=projects;
			}			
		}
		xmlhttp.open("POST","includes/get_user_projects.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send();
}
//************************************* log_weekly_status *****************************//
function log_weekly_status()
{
	var project= $("#set-projects").val();
	var team_size= $("#team-size").val();
	var sprnt_date= $("#sprint-end-date").val();
	var prj_poc= $("#project-poc").val();
	var cur_wrk= $("#cur-work").val();
	var futr_wrk= $("#future-work").val();
	var prj_chlng= $("#prj-chlng").val();
	var prj_chlng_desc= $("#prj-chlng-desc").val();
	var prj_qlty= $("#prj-qlty").val();
	var prj_impact= $("#prj-impact").val();
	var tst_exe= $("#tst-exe").val();
	var tst_dsgn= $("#tst-dsgn").val();
	var ram_up_dwn= $("#ram-up-dwn").val();
	var appr_fl_pth= $("#appr-file-pth").val();

	// ignoring Challenge desc if Challenge is not selected as Yes
	if (!(prj_chlng=="yes")) 
    {
    	prj_chlng_desc="";
    }
    // Checking for mandate info
    if(project=="" || team_size=="" || prj_poc=="" || cur_wrk=="" || futr_wrk=="" || prj_chlng=="" || prj_qlty=="" || prj_impact=="" || tst_exe=="" || tst_dsgn=="")
    {
    	$("#sts_frm_msg").attr("class", "alert alert-danger");
    	$("#sts_frm_msg").css("display","block");
    	$("#sts_frm_msg").text("Please fill all fields");
    	$('#sts_frm_msg').get(0).scrollIntoView(); 
    	return false;
    }
    // Creating a string with data to be posted to server
    var post_data="project_id="+project+"&team_size="+team_size+"&sprnt_date="+sprnt_date+"&prj_poc="+prj_poc+"&cur_wrk="+cur_wrk+"&futr_wrk="+futr_wrk+"&prj_chlng="+prj_chlng+"&prj_chlng_desc="+prj_chlng_desc+"&prj_qlty="+prj_qlty+"&prj_impact="+prj_impact+"&tst_exe="+tst_exe+"&tst_dsgn="+tst_dsgn+"&ram_up_dwn="+ram_up_dwn+"&appr_fl_pth="+appr_fl_pth;
	// return false;
	var xmlhttp;
	if (window.XMLHttpRequest)
  	{
		// code for IE7+, Firefox, Chrome, Opera, Safari
  		xmlhttp=new XMLHttpRequest();
  	}
	else
  	{
		// code for IE6, IE5
  		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  	}		
	xmlhttp.onreadystatechange=function()
  	{
		
  		if (xmlhttp.readyState==4 && xmlhttp.status==200)
    	{
    		$("#sts_frm_msg").css("display","block");
    		var x=xmlhttp.responseText;
    		if(x=="success")
    		{
    			$("#sts_frm_msg").attr("class", "alert alert-success");
    			$("#sts_frm_msg").text("Your weekly Statys saved successfully!");
    		}
    		else
    		{
    			$("#sts_frm_msg").attr("class", "alert alert-danger");
    			$("#sts_frm_msg").text("Unable to save data, please contact Technical support");
    		}
    		$('#sts_frm_msg').get(0).scrollIntoView();
		}			
	}
	xmlhttp.open("POST","includes/log_weekly_status.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send(post_data);
}

//***************************************** JQUERY event functions ************************//
$(document).ready(function()
{
	$("#prj-chlng").change(function()
	{
    	var chlng=document.getElementById("prj-chlng").value;
    	if (chlng=="yes") 
    	{
    		$("#prj-chlng-desc").prop( "disabled", false );
    	}
    	else
    	{
    		$("#prj-chlng-desc").prop( "disabled", true );
    	}
	});
	$("#wkly-sts-sbmt").click(function()
	{
		$("#wkly-sts-sbmt").text("Saving data...");
		log_weekly_status();
		$("#wkly-sts-sbmt").text("I'm done! Take my note");
	});
});