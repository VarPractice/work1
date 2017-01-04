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
        nonSelectedText :'Select columns'    
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
    // This function filters the Reports in reports table
    $("#sts-fltr-srch").click(function()
    {
        // Declare variables 
        var table, tr, td_prj, td_tm, i,j=0,time_fltr=false,disp_week,disp_week_count;
        table = document.getElementById("prj-sts-reports-tbl");
        tr = table.getElementsByTagName("tr");
        // Getting total no.of columns in table.
        var total_cols=$("#display-cols option").length
        // Getting data from Filters.
        var cols_to_display=$("#display-cols").val();
        var prjs_selected=$("#set-projects").val();
        var rp_strt_dt=$("#report-strt-dt").val();
        var rp_end_dt=$("#report-end-dt").val();
        // Clearing previous Filter results
        $("tr").show();
        $("tr td, tr th").show();
        // Loop through all table rows, and hide those who don't match the search query in Week column
        if ((rp_strt_dt=="" && rp_end_dt!="") || (rp_strt_dt!="" && rp_end_dt=="")) 
        {
            $("#sts_fltr_msg").show();
            $("#sts_fltr_msg").text("Either Enter both Week Start and End dates or leave both blank");
            return false;
        }
        if(rp_strt_dt!="" && rp_end_dt!="")
        {
            var strt_yr, end_yr, strt_wk, end_wk, st_wk_cnt, end_wk_cnt;
            strt_yr=rp_strt_dt.substring(0,4); //yyyy-mm-dd
            end_yr=rp_end_dt.substring(0,4); //yyyy-mm-dd
            rp_strt_dt=new Date(rp_strt_dt);
            rp_end_dt=new Date(rp_end_dt);
            // Validating selected date range
            if (rp_strt_dt > rp_end_dt) 
            {
                $("#sts_fltr_msg").show();
                $("#sts_fltr_msg").text("Either Enter both Week Start and End dates or leave both blank");
                return false;
            }
            strt_wk=rp_strt_dt.getWeek();
            end_wk=rp_end_dt.getWeek();
            st_wk_cnt=parseInt(strt_wk)+parseInt(strt_yr);
            end_wk_cnt=parseInt(end_wk)+parseInt(end_yr);
            time_fltr=true;
        }
        // Loop through all table rows, and hide those who don't match the search query in Projects column
        if (prjs_selected.length!=0 || time_fltr)
        for (i = 0; i < tr.length; i++)
        {
            td_prj = tr[i].getElementsByTagName("td")[1];
            td_tm = tr[i].getElementsByTagName("td")[0];
            if (time_fltr &&td_tm)
            {
                disp_week=td_tm.getAttribute("value").toUpperCase().trim().split(",");
                disp_week_count=parseInt(disp_week[0])+parseInt(disp_week[1]);
                
                if (st_wk_cnt>disp_week_count || disp_week_count>end_wk_cnt)
                {
                    tr[i].style.display = "none";
                }
            }
            if (prjs_selected.length!=0 && td_prj)
            {
                if (!isPrjInSlctdLst(td_prj.innerHTML,prjs_selected)) 
                {
                    tr[i].style.display = "none";
                }
            } 
        }
        // Loop throw all table columns and display only selected
        if (cols_to_display.length!=0) 
        {
            for (i = 1; i < total_cols+1; i++) 
            {
                if(cols_to_display[j]==i)
                {
                    $("tr *:nth-child("+i+")").show();
                    j++;
                }
                else
                {
                    $("tr *:nth-child("+i+")").hide();
                }     
            }
        }
        // Resetting error message
        $("#sts_fltr_msg").text("");
        $("#sts_fltr_msg").hide();
        dataTable.draw();
    });
    // This function tells whether the given Project [1st Arg] is in lis of projects given [2nd Arg]
    function isPrjInSlctdLst(givPrj,prjs_lst)
    {
        var found=false;
        givPrj=givPrj.toUpperCase().trim();
        for(var i=0; i<prjs_lst.length;i++)
        {
            if (prjs_lst[i].toUpperCase().trim()==givPrj)
            {
                found=true;
                break;
            }
        }
        return found;
    }
});