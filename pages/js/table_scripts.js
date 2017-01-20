$(document).ready(function()
{
    // This function will set projects in filter for Weekly status table search
    setEmpProjects();
    // This function toggles the display of filter menu
    $("#fltr-tgl-btn").click(function()
    {
        $(".sts-filter").toggle();
    });
    // This displays checkboxes for multi select in column filter
    $("#display-cols").multiselect(
    { 
        includeSelectAllOption: true,
        enableFiltering:true,
        numberDisplayed: 1,
        nonSelectedText :'Hide columns'    
    });
    // This function scrolls horizontally on mouce move
    var cntWd, sldWd, tb;
    $("#sts-table-panel").mousemove(function(e)
    {
        cntWd = $('#sts-table-panel').innerWidth();
        tb = $('#prj-sts-reports-tbl');
        sldWd = tb.outerWidth();
        var x=((cntWd - sldWd)*((e.pageX / cntWd).toFixed(3))).toFixed(0);
        x=parseInt(x)+30;
        // $("#sts_fltr_msg").text("Coordinate-x: "+x);
        tb.css({left:  x+"px" });
    });
    /***********************************************************/
    // Calling Datatable constructor
    var dataTable=$('#prj-sts-reports-tbl').DataTable();
    /***********************************************************/
    var min, max; // Will be assigned in search function & will be reset at end of function
    // Function to Filter Date column in the Reports table
    $.fn.dataTable.ext.search.push( // This method executes when dataTable.draw() is called
        function( settings, data, dataIndex )
        {
            //  This function actually matches the number range to filter data
            //  min & max are numbers genarated based the selected filter dates
            var rp_dateNum = parseFloat( data[0] ) || 0; // use data for the date column
            if ( ( isNaN( min ) && isNaN( max ) ) ||
                ( isNaN( min ) && rp_dateNum <= max ) ||
                ( min <= rp_dateNum   && isNaN( max ) ) ||
                ( min <= rp_dateNum   && rp_dateNum <= max ) )
            {
                return true; // Display the record
            }
            return false; // Hide the record
        }
    );
    //  This function caliculates the search number for given date
    function getSrchDateNum(rp_date)
    {
        if(rp_date=='')
        {
            return '';
        }
        try
        {
            var newDate=new Date(rp_date);
            // Setting time of day to start of the specified date
            newDate.setHours(0, 0, 0, 0);
            return Math.round(newDate.getTime()/1000.0);
        }
        catch(err)
        {
            $("#sts_fltr_msg").show();
            $("#sts_fltr_msg").text("Unable to process the entered date, unreliable results displayed");
            return '';
        }
    }
    //Implementing DataTable API to search
    $("#sts-fltr-srch").click(function()
    {
        //  Clearing the Error messages
        //  Resetting error message
        $("#sts_fltr_msg").text("");
        $("#sts_fltr_msg").hide();
        //  Reading data from Search fields
        var cols_to_display=$("#display-cols").val().map(Number);// returns an int array
        var prjs_selected=$("#set-projects").val().toString().replace(/,/g, "|"); //string with '|' delimiter
        var rp_strt_dt=$("#report-strt-dt").val();
        var rp_end_dt=$("#report-end-dt").val();
        // Validating dates
        if(rp_strt_dt.length!=0 && !validateDate(rp_strt_dt,'ymd'))
        {
            $("#sts_fltr_msg").show();
            $("#sts_fltr_msg").text("Invalid Start date format. If you are using chrome use the date picker, other browsers: format Should be yyyy-mm-dd or yyyy/mm/dd");
            return false;
        }
        if(rp_end_dt.length!=0 && !validateDate(rp_end_dt,'ymd'))
        {
            $("#sts_fltr_msg").show();
            $("#sts_fltr_msg").text("Invalid End date format. If you are using chrome use the date picker, other browsers: format Should be yyyy-mm-dd or yyyy/mm/dd");
            return false;
        }
        //  Filtering Display columns
        dataTable.columns().visible(true); //clearing previous Column filter
        dataTable.columns(cols_to_display.length>0 ? cols_to_display : '.nothing').visible(false);
        //  Filtering Projects
        dataTable.column(1).search(prjs_selected ? prjs_selected : '', true, false );
        //  Filtering Report dates
        var rp_strt_dt,rp_end_dt;
        rp_strt_dt=$("#report-strt-dt").val();
        rp_end_dt=$("#report-end-dt").val();
        //  Assigning min & max variables
        min=parseInt(getSrchDateNum(rp_strt_dt));
        max=parseInt(getSrchDateNum(rp_end_dt));
        //  Displaying the search results.
        dataTable.draw();
        /********************* Last things last ************************/
        //  resetting min & max values
        min='';
        max='';
    });
});