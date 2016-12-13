<?php 
    require_once("includes/header.php");
?>
        <!-- Page main content Starts -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Customized Metric Stats</h1>
                    <div class="form-group">
                            <div id="sts_frm_msg" style="display: none" class="alert alert-danger">I'm wrong!</div>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
                <div style="display: none" class="sts-filter col-lg-12">
                    <div class="col-lg-3" >
                        <div class="form-group">
                            <select id="set-projects" class="form-control" data-toggle="tooltip" title="Select your project">
                                <option value="">Select your Project</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">    
                            <input id="team-size" data-toggle="tooltip" title="Enter Team size" class="form-control" placeholder="Enter Team size" type="number" min=0>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">    
                            <input id="sprint-end-date" data-toggle="tooltip" title="Sprint End date" class="form-control" type="date">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">    
                            <input id="project-poc" data-toggle="tooltip" title="Project point of contact" class="form-control" placeholder="Emp Id's with coma delimiter">
                        </div>
                    </div>
                </div>  
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <!-- <div class="text-right">DataTables Advanced Tables</div> -->
                           
                            <div class="dropdown text-left">
                                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Export
                                <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <!-- <li><a href="#" onClick ="$('#dataTables-example').tableExport({type:'pdf',escape:'false'});">PDF</a></li> -->
                                    <li><a href="#" onClick ="$('#dataTables-example').tableExport({type:'excel',escape:'false'});">Excell</a></li>
                                </ul>
                                <button class="btn btn-default" id="fltr-tgl-btn">Filter results</button>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Week</th>
                                        <th>Project</th>
                                        <th>POC(s)</th>
                                        <th>Team Size</th>
                                        <th>Sprint End date</th>
                                        <th>Current Work</th>
                                        <th>Future work</th>
                                        <th>Challenges</th>
                                        <th>Quality</th>
                                        <th>Impact</th>
                                        <th>Test execution</th>
                                        <th>Test Design</th>
                                        <th>Ramp up/down</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        // Creating SQL Connection
                                        $con=create_sqlConnection();
                                        // Setting the query string
                                        $sts_query="select * from `project_maritz`";
                                        // Executing Query to get login details
                                        $res=exeQuery($sts_query,$con);
                                        if($res->num_rows > 0)
                                        {
                                            $i=1;
                                            while ($row = $res->fetch_assoc()) 
                                            {   
                                                //  Getting Date of report logged
                                                $week_year=explode(",",$row['for week']);
                                                $year=$week_year[1];
                                                $week=$week_year[0];
                                                //Returns the date of monday in week
                                                $from = date("d", strtotime("{$year}-W{$week}-1"));
                                                //Returns the date of Sunday in week 
                                                $to = date("d-M-y", strtotime("{$year}-W{$week}-7"));
                                                //  Getting name Project for which report logged for

                                                // printing data to table
                                                echo "<tr class='gradeX ".($i%2==0 ? "odd" : "even")."' >
                                                <td>".$from." to ".$to."</td>
                                                <td>".getProjectName($row['project id'], $con)."</td>
                                                <td>".$row['point of contact']."</td>
                                                <td>".$row['team_size']."</td>
                                                <td>".$row['sprint_end_date']."</td>
                                                <td>".$row['current work']."</td>
                                                <td>".$row['future work']."</td>
                                                <td>".$row['challenges']."</td>
                                                <td>".$row['quality']."</td>
                                                <td>".$row['impact']."</td>
                                                <td>".$row['execution']."</td>
                                                <td>".$row['design']."</td>
                                                <td>".$row['ramupdown']."</td>
                                                </tr>";
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper Main content Ends-->
<!-- Including some page level required JS files -->
<!-- Base JS file for exporting function -->
    <script type="text/javascript" src="js/tableExport.js" ></script>
    <script type="text/javascript" src="js/jquery.base64.js" ></script>
    <!-- JS to Export to PDF -->
    <script type="text/javascript" src="jspdf/libs/sprintf.js" ></script>
    <script type="text/javascript" src="jspdf/jspdf.js" ></script>
    <script type="text/javascript" src="jspdf/libs/base64.js" ></script>
    <script type="text/javascript">
    $(document).ready(function()
    {
        $("#fltr-tgl-btn").click(function()
        {
            $(".sts-filter").toggle();
        });
    });
</script>
<?php
    require_once("includes/footer.php");
?>