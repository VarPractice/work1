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
/***** This function Validates the Date with the format given separator should be '/' or '-'*********/
function validateDate(date,date_format)
{
    if(date.length<=0 || date_format.length!=3)
    {
      // Date not entered or invalid date format given to match
      return false;
    }
    var dateformat;
    var month_regex="(0?[1-9]|1[012])";
    var date_regex="(0?[1-9]|[12][0-9]|3[01])";
    var year_regex="\\d{4}";
    var dlmtr_regex="[\/\\-]";
    //Test which seperator is used '/' or '-'  
    var opera1 = date.split('/');  
    var opera2 = date.split('-');  
    var lopera1 = opera1.length;  
    var lopera2 = opera2.length;
    var pdate;
    // Extract the string into month, date and year  
    if (lopera1>1)  
    {  
      pdate = date.split('/');  
    }  
    else if (lopera2>1)  
    {  
      pdate = date.split('-');
    }
    else
    {
      // invalid date separator
      return false;
    }
    var dd,mm,yy;
    // Create list of days of a month [assume there is no leap year by default]  
    var ListofDays = [31,28,31,30,31,30,31,31,30,31,30,31];
    switch(date_format)
    {
        case "mdy": 
                    {
                      dateformat='^'+month_regex+dlmtr_regex+date_regex+dlmtr_regex+year_regex+'$';
                      mm = parseInt(pdate[0]);  
                      dd = parseInt(pdate[1]);  
                      yy = parseInt(pdate[2]);
                      break;
                    }
        case "myd": 
                    {
                      dateformat="^"+month_regex+dlmtr_regex+year_regex+dlmtr_regex+date_regex+"$";
                      mm = parseInt(pdate[0]);  
                      yy = parseInt(pdate[1]);  
                      dd = parseInt(pdate[2]);
                      break;
                    }
        case "dmy": 
                    {
                      dateformat="^"+date_regex+dlmtr_regex+month_regex+dlmtr_regex+year_regex+"$";
                      dd = parseInt(pdate[0]);  
                      mm = parseInt(pdate[1]);  
                      yy = parseInt(pdate[2]);
                      break;
                    }
        case "dym": 
                    {
                      dateformat="^"+date_regex+dlmtr_regex+year_regex+dlmtr_regex+month_regex+"$";
                      dd = parseInt(pdate[0]);  
                      yy  = parseInt(pdate[1]);  
                      mm = parseInt(pdate[2]);
                      break;
                    }
        case "ymd": 
                    {
                      dateformat="^"+year_regex+dlmtr_regex+month_regex+dlmtr_regex+date_regex+"$";
                      yy = parseInt(pdate[0]);  
                      mm  = parseInt(pdate[1]);  
                      dd = parseInt(pdate[2]);
                      break;
                    }
        case "ydm": 
                    {
                      dateformat="^"+year_regex+dlmtr_regex+date_regex+dlmtr_regex+month_regex+"$";
                      yy = parseInt(pdate[0]);  
                      dd  = parseInt(pdate[1]);  
                      mm = parseInt(pdate[2]);
                      break;
                    }
        default:    {
                        // Invalid date Matching format
                        return false;
                    }
    }
    if(dd==0)
    {
      // date shouldn't be zero
      return false;
    }
    // Forming the regular Expression
    dateformat=new RegExp(dateformat);
    // Match the date format through regular expression  
    if(!date.match(dateformat))
    {   
      // Date format not matched
      return false;  
    }
    //  Validating Month excepth Feb 
    if (mm==1 || mm>2)  
    {  
      if (dd>ListofDays[mm-1])  
      { 
        // date out of calander month
        return false;  
      }  
    }
    // Validating Feb month
    if (mm==2)  
    {  
      var lyear = false;
      // Verifying wether given year is a leap
      if ( (!(yy % 4) && yy % 100) || !(yy % 400))   
      {  
        lyear = true;  
      }  
      if ((lyear==false) && (dd>=29))  
      {
        return false;  
      }  
      if ((lyear==true) && (dd>29))  
      {  
        return false;  
      }  
    }
    return true; 
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