/***** This function Loads Projects assosiated to an Account of logged in Employee****************/
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
    			/*var x=xmlhttp.responseText;
          		var x=JSON.parse(x);*/
    			var x=JSON.parse(xmlhttp.responseText);
    			var projects="";
				for(var i=0; i<x.length;i++)
				{
					projects+="<option>"+x[i].name+"</option>";
				}
				document.getElementById("set-projects").innerHTML +=projects;
				// This functions improves the UI of project filter dropdown menu
				$("#set-projects").multiselect(
            	{ 
                	includeSelectAllOption: true,
                	enableFiltering:true,
                	numberDisplayed: 1,
                	nonSelectedText :'Select Projects'    
           		});
			}			
		}
		xmlhttp.open("POST","includes/get_user_projects.php?for=account",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send();
}
// This method adds functionality to Date() to return weeknumber of given date
Date.prototype.getWeek = function() 
{
    var target  = new Date(this.valueOf());
    var dayNr   = (this.getDay() + 6) % 7;
    target.setDate(target.getDate() - dayNr + 3);
    var firstThursday = target.valueOf();
    target.setMonth(0, 1);
    if (target.getDay() != 4) {
        target.setMonth(0, 1 + ((4 - target.getDay()) + 7) % 7);
    }
    return 1 + Math.ceil((firstThursday - target) / 604800000);
};