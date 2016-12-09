
/************************************************* Sign in Function *************************************/
function sign_in()
{
		var xmlhttp;
		var usr_id=document.getElementById('empid').value;
		var usr_pwd=document.getElementById('password').value;
		document.getElementById("submit-btn").innerHTML="Loggin in..";
		if(usr_id=="" || usr_pwd=="")
		{
			alert("Please fill both fields.."+usr_id);
			document.getElementById("submit-btn").innerHTML="Login";
			return false;
		}
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
    				var x=xmlhttp.responseText;
				if(x=="success")
				{
					document.getElementById("login-form").reset();
					document.getElementById("submit-btn").innerHTML="Login";
					window.location="http://10.102.150.145/Maritz_dashboard/";
				}
				else
				{
					alert("sorry inavlid id or password, Please try again!");
					document.getElementById("submit-btn").innerHTML="Login";
				}
				
							
    			}			
		}
		xmlhttp.open("POST","includes/validate_login.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("mem_id="+usr_id+"&mem_pwd="+usr_pwd);
}